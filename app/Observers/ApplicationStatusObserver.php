<?php

namespace App\Observers;

use App\Models\ApplicationStatus;
use App\Services\NotificationService;

class ApplicationStatusObserver
{
    protected NotificationService $notifier;

    public function __construct(NotificationService $notifier)
    {
        $this->notifier = $notifier;
    }

    public function updated(ApplicationStatus $applicationStatus)
    {
        $this->notifier->sendApplicationUpdate($applicationStatus, sendEmail: true, sendSms: true);
    }
}
