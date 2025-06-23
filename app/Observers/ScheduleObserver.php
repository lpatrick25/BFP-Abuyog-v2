<?php

namespace App\Observers;

use App\Models\Schedule;
use App\Mail\ScheduleNotification;
use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ScheduleObserver
{
    protected NotificationService $notifier;

    public function __construct(NotificationService $notifier)
    {
        $this->notifier = $notifier;
    }

    public function created(Schedule $schedule)
    {
        $this->notifier->sendScheduleNotification($schedule, 'Inspection', true, true);
    }

    public function updated(Schedule $schedule): void
    {
        if (Session::get('skip_schedule_notification', false)) {
            Log::info('Schedule update from ApplicationStatusService — skipping notification.');
            Session::forget('skip_schedule_notification');
            return;
        }
        if (Session::get('skip_schedule_notification_again', false)) {
            Log::info('Schedule update from ApplicationStatusService — skipping notification again.');
            Session::forget('skip_schedule_notification');
            return;
        }
        if (Session::get('skip_schedule_notification_again_again', false)) {
            Log::info('Schedule update from ApplicationStatusService — skipping notification again.');
            Session::forget('skip_schedule_notification');
            return;
        }

        Log::info('Schedule update from ScheduleService — trigger notification.');
        $this->notifier->sendScheduleNotification($schedule, 'Reschedule', true, true);
    }
}
