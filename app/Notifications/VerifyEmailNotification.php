<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends BaseVerifyEmail
{

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('emails.verify_email', [
                'user' => $notifiable,
                'verificationUrl' => $this->verificationUrl($notifiable),
                'subject' => 'Verify Your Email Address'
            ]);
    }


    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
    }
}
