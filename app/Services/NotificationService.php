<?php

namespace App\Services;

use App\Mail\ApplicationStatusUpdated;
use App\Mail\FsicNotification;
use App\Mail\ScheduleNotification;
use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\Fsic;
use App\Models\Schedule;
use App\Models\SmsRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function sendApplicationUpdate(ApplicationStatus $applicationStatus, bool $sendEmail = true, bool $sendSms = true): void
    {
        $application = $applicationStatus->application;
        $establishment = $application->establishment;
        $client = $establishment?->client;

        if (!$client) {
            Log::warning("No client found for application ID {$application->id}");
            return;
        }

        $remarks = $applicationStatus->remarks;
        [$subject, $remarksMessage, $inspectionType] = $this->getMessageDetails($remarks);
        $schedule = Schedule::where('application_id', $application->id)->first();

        // Send SMS if requested
        if ($sendSms) {
            if (!$client->contact_number) {
                Log::warning("SMS not sent. No contact number for client ID {$client->id}");
            } else {
                $smsMessage = $this->buildSmsMessage(
                    $client->getFullName(),
                    $subject,
                    $remarks,
                    $remarksMessage,
                    $establishment,
                    $schedule,
                    $inspectionType
                );

                SmsRequest::create([
                    'phone_number' => $client->contact_number,
                    'message' => $smsMessage,
                ]);
            }
        }

        // Send Email if requested
        if ($sendEmail) {
            if ($client->email) {
                Mail::to($client->email)->send(
                    new ApplicationStatusUpdated($applicationStatus, $remarksMessage, $subject, $inspectionType)
                );
            } else {
                Log::warning("Email not sent. No email address for client ID {$client->id}");
            }
        }
    }

    private function getMessageDetails(string $remarks): array
    {
        return match ($remarks) {
            ApplicationStatus::NOTICE_COMPLY =>
            ['Notice to Comply Issued', 'You are required to comply with the stated fire safety requirements.', 'Reinspection'],
            ApplicationStatus::NOTICE_VIOLATION =>
            ['Notice to Correct Violation Issued', 'You are required to correct the stated violations promptly.', 'Reinspection'],
            ApplicationStatus::ABATEMENT_ORDER =>
            ['Abatement Order Issued', 'An abatement order has been issued. Please take immediate action.', 'Reinspection'],
            ApplicationStatus::STOPPAGE_ORDER =>
            ['Stoppage of Operation Issued', 'A stoppage of operation has been enforced. Please resolve the issues immediately.', 'Stoppage'],
            ApplicationStatus::COMPLIED =>
            ['Establishment Complied', 'We are pleased to inform you that your establishment has complied with all the required fire safety standards.', 'Completed'],
            ApplicationStatus::CERTIFICATE_RELEASE =>
            ['Establishment Complied', 'We are pleased to inform you that your establishment has complied with all the required fire safety standards.', 'Completed'],
            default =>
            ['Application Denied', 'Your application has been denied. Please address the issues mentioned.', 'Pending'],
        };
    }

    private function buildSmsMessage(
        string $clientName,
        string $subject,
        string $remarks,
        string $remarksMessage,
        object $establishment,
        ?Schedule $schedule,
        string $inspectionType
    ): string {
        $message = "{$subject}\n\nDear {$clientName},\n\n";

        switch ($subject) {
            case 'Establishment Complied':
                return $message . "FSIC has been issued for your establishment \"{$establishment->name}\" at {$establishment->address_brgy}.\n{$remarksMessage}";

            case 'Application Denied':
                return $message . "Your application for \"{$establishment->name}\" was denied.\nRemarks: {$remarks}\n{$remarksMessage}";

            default:
                $message .= "Your application for \"{$establishment->name}\" at {$establishment->address_brgy} has been reviewed.\nRemarks: {$remarks}\n{$remarksMessage}\n\n";

                if ($schedule?->schedule_date) {
                    $message .= "📅 Inspection Date: " . date('F j, Y', strtotime($schedule->schedule_date)) . "\n";
                    $message .= "📝 Inspection Type: {$inspectionType}\n";
                    $message .= "👨‍🚒 Inspector: " . ($schedule->inspector?->getFullName() ?? 'Not yet assigned');
                } else {
                    $message .= "⚠️ No inspection date has been scheduled yet. Please comply to proceed.";
                }

                return $message;
        }
    }

    public function sendFsicIssuedNotification(Fsic $fsic, bool $sendEmail = true, bool $sendSms = true): void
    {
        $application = $fsic->application;
        $establishment = $application->establishment;
        $client = $establishment?->client;

        if (!$client) {
            $this->logMissingClient($application->id);
            return;
        }

        $subject = 'FSIC Certificate Issued';
        $remarksMessage = 'We are pleased to inform you that your Fire Safety Inspection Certificate (FSIC) has been issued.';
        $smsMessage = $this->generateFsicSmsMessage($client->getFullName(), $establishment, $subject, $remarksMessage);

        if ($sendSms) {
            $this->sendSms($client->contact_number, $client->id, $smsMessage);
        }

        if ($sendEmail && $client->email) {
            $pdfPath = storage_path('app/public/' . $fsic->fsic_no . '.pdf');
            Mail::to($client->email)->send(new FsicNotification($fsic, $pdfPath));
        } elseif ($sendEmail) {
            $this->logMissingEmail($client->id);
        }
    }

    public function sendScheduleNotification(Schedule $schedule, string $inspectionType, bool $sendEmail = true, bool $sendSms = true): void
    {
        $application = $schedule->application;
        $establishment = $application->establishment;
        $client = $establishment?->client;

        if (!$client) {
            $this->logMissingClient($application->id);
            return;
        }

        $subject = $inspectionType === 'Inspection'
            ? 'Establishment Scheduled for Inspection'
            : 'Establishment Scheduled for Reinspection';

        $remarksMessage = $inspectionType === 'Inspection'
            ? 'Your establishment has been scheduled for an initial inspection. Please review the details and prepare accordingly.'
            : 'There has been a change to your reinspection schedule. Please see the updated date and details below.';

        $smsMessage = $this->generateScheduleSmsMessage($client->getFullName(), $establishment, $schedule, $inspectionType, $subject, $remarksMessage);

        if ($sendSms) {
            $this->sendSms($client->contact_number, $client->id, $smsMessage);
        }

        if ($sendEmail && $client->email) {
            Mail::to($client->email)->send(new ScheduleNotification($schedule, $inspectionType));
        } elseif ($sendEmail) {
            $this->logMissingEmail($client->id);
        }

        if ($inspectionType === 'Inspection') {
            ApplicationStatus::create([
                'application_id' => $application->id,
                'status' => 'Scheduled for Inspection',
            ]);
        }
    }

    private function generateFsicSmsMessage(string $clientName, object $establishment, string $subject, string $remarksMessage): string
    {
        return "{$subject}\n\nDear {$clientName},\n\n" .
            "We are pleased to inform you that your FSIC has been successfully issued for \"{$establishment->name}\" located at {$establishment->address_brgy}.\n\n" .
            "{$remarksMessage}\n\nPlease check your email for the attached document containing further details.";
    }

    private function generateScheduleSmsMessage(string $clientName, object $establishment, Schedule $schedule, string $inspectionType, string $subject, string $remarksMessage): string
    {
        return "{$subject}\n\nDear {$clientName},\n\n" .
            "Your application for \"{$establishment->name}\" at {$establishment->address_brgy} has been scheduled for {$inspectionType}.\n\n" .
            "📅 Inspection Date: " . date('F j, Y', strtotime($schedule->schedule_date)) . "\n" .
            "📝 Inspection Type: {$inspectionType}\n" .
            "👨‍🚒 Inspector: " . ($schedule->inspector?->getFullName() ?? 'Not yet assigned') . "\n\n" .
            "{$remarksMessage}";
    }

    private function sendSms(?string $number, int $clientId, string $message): void
    {
        if ($number) {
            SmsRequest::create([
                'phone_number' => $number,
                'message' => $message,
            ]);
        } else {
            $this->logMissingContact($clientId);
        }
    }

    private function logMissingClient(int $applicationId): void
    {
        Log::warning("No client found for application ID {$applicationId}");
    }

    private function logMissingContact(int $clientId): void
    {
        Log::warning("SMS not sent. No contact number for client ID {$clientId}");
    }

    private function logMissingEmail(int $clientId): void
    {
        Log::warning("Email not sent. No email address for client ID {$clientId}");
    }
}
