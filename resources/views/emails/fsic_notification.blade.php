@include('emails.layout', [
    'subject' => $subject,
    'clientName' => $client->getFullName(),
    'body' => "
        <p>We are pleased to inform you that the Fire Safety Inspection Certificate (FSIC) has been successfully issued for your property located at <strong>{$address}</strong>.</p>
        <p><strong>Remarks:</strong> {$remarks}</p>
        <p>{$remarksMessage}</p>
    ",
    'contactEmail' => config('mail.from.address'),
])
