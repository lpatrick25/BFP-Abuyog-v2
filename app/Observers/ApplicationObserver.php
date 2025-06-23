<?php

namespace App\Observers;

use App\Events\NewApplication;
use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\User;
use App\Notifications\ApplicationNotification;
use Illuminate\Support\Facades\Notification;

class ApplicationObserver
{
    /**
     * Handle the Application "created" event.
     */
    public function created(Application $application)
    {
        // Create application status
        ApplicationStatus::create([
            'application_id' => $application->id,
            'status' => 'Under Review',
        ]);

        // Broadcast New Application
        broadcast(new NewApplication($application))->toOthers();

        // Notify Marshall role users
        $marshallUsers = User::where('role', 'Marshall')->get();
        Notification::send($marshallUsers, new ApplicationNotification($application));
    }
}
