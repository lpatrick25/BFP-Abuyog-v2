<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class FSICCertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $applicationData;
    public $fsicData;

    /**
     * Create a new message instance.
     */
    public function __construct($applicationData, $fsicData)
    {
        $this->applicationData = $applicationData;
        $this->fsicData = $fsicData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Fire Safety Inspection Certificate Issued')
            ->view('emails.fsic_certificate')
            ->attach(storage_path('app/' . $this->fsicData['filePath'])); // Corrected path
    }
}
