<?php

namespace App\Mail;

use App\Models\Fsic;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FsicNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $fsic;
    public $pdfFilePath;
    public $subject;
    public $client;
    public $establishment;
    public $address;
    public $remarks;
    public $remarksMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(Fsic $fsic, string $pdfFilePath)
    {
        $this->fsic = $fsic;
        $this->pdfFilePath = $pdfFilePath;
        $this->subject = 'Fire Safety Inspection Certificate (FSIC) Issued';

        $this->client = $fsic->application->establishment->client ?? null;
        $this->establishment = $fsic->application->establishment ?? null;
        $this->address = ucwords(strtolower($this->establishment->address_brgy ?? 'Unknown')) . ', Abuyog, Leyte';

        $this->remarks = 'Your FSIC has been successfully issued.';
        $this->remarksMessage = 'Please find the FSIC document attached below for your records. Should you have any questions or require further assistance, do not hesitate to reach out to us.';
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->view('emails.fsic_notification')
            ->attach($this->pdfFilePath, [
                'as' => 'FSIC_Certificate.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
