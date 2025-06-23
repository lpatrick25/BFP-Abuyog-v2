<?php

namespace App\Mail;

use App\Models\ApplicationStatus;
use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $applicationStatus;
    public $remarksMessage;
    public $subject;
    public $inspectionType;

    public function __construct(ApplicationStatus $applicationStatus, string $remarksMessage, string $subject, string $inspectionType)
    {
        $this->applicationStatus = $applicationStatus;
        $this->remarksMessage = $remarksMessage;
        $this->subject = $subject;
        $this->inspectionType = $inspectionType;
    }

    public function build()
    {
        $schedule = Schedule::where('application_id', $this->applicationStatus->application->id)->first();

        return $this->subject($this->subject)
            ->view('emails.application_status_updated')
            ->with([
                'status' => $this->applicationStatus->status,
                'remarks' => $remarks ?? 'No remarks provided.',
                'client' => $this->applicationStatus->application->establishment->client,
                'establishment' => $this->applicationStatus->application->establishment,
                'subject' => $this->subject,
                'remarksMessage' => $this->remarksMessage,
                'scheduleDate' => $schedule?->schedule_date ?? '',
                'inspector' => $schedule?->inspector,
                'inspectionType' => $this->inspectionType,
            ]);
    }
}
