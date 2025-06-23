<?php

namespace App\Mail;

use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduleNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $schedule;
    public $inspectionType;

    /**
     * Create a new message instance.
     */
    public function __construct(Schedule $schedule, $inspectionType)
    {
        $this->schedule = $schedule;
        $this->inspectionType = $inspectionType;
    }

    /**
     * Build the message.
     */
    public function build()
    {

        $subject = '';
        if ($this->inspectionType == 'Reinspection') {
            $subject = 'Establishment Scheduled for Reinspection';
        } else if ($this->inspectionType == 'Reschedule') {
            $subject = 'Establishment Inspection Reschedule';
        } else {
            $subject = 'Establishment Scheduled for Inspection';
        }

        return $this->subject($subject)
            ->markdown('emails.schedule_notification')
            ->with([
                'scheduleDate' => $this->schedule->schedule_date,
                'inspector' => $this->schedule->inspector,
                'client' => $this->schedule->application->establishment->client,
                'establishment' => $this->schedule->application->establishment,
                'inspectionType' => $this->inspectionType,
                'subject' => $subject,
            ]);
    }
}
