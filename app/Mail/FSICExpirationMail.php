<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Models\Fsic;

class FSICExpirationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $fsic;

    public function __construct($fsic, $client)
    {
        $this->fsic = $fsic;
        $this->client = $client;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $application = $this->fsic->application;
        $establishment = $application ? $application->establishment : null;
        return $this->subject('Your FSIC is Near Expiration')
            ->view('emails.fsic_expiry_notice')
            ->with([
                'clientName' => $this->client->first_name . ' ' . $this->client->last_name,
                'establishmentName' => $establishment ? $establishment->name : '',
                'expirationDate' => $this->fsic->expiration_date ? $this->fsic->expiration_date->format('F d, Y') : '',
            ]);
    }
}
