<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class ApplicationNotification extends Notification
{
    use Queueable;

    protected $application;

    public function __construct($application)
    {
        $this->application = $application;
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('New Application Submitted')
            ->body("Application ID: {$this->application->id} is under review.")
            ->action('View Application', url('/applications/' . $this->application->id))
            ->icon('/images/logo.png');
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'application_id' => $this->application->id,
            'message' => 'A new application has been submitted.',
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'application_id' => $this->application->id,
            'message' => 'A new application has been submitted.',
        ];
    }
}
