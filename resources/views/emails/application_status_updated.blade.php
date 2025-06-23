@include('emails.layout', [
    'subject' => $subject,
    'clientName' => $client->getFullName(),
    'body' => "
        <p>Your application for the establishment <strong>{$establishment->name}</strong>, located at <strong>{$establishment->address_brgy}</strong>, has been reviewed.</p>
        <p><strong>Remarks:</strong> {$remarks}</p>
        <p>{$remarksMessage}</p>
    ",
    'details' =>
        "
        <p><strong>📅 Inspection Date:</strong> " .
        date('F j, Y', strtotime($scheduleDate)) .
        "</p>
        <p><strong>📝 Inspection Type:</strong> {$inspectionType}</p>" .
        ($inspector
            ? "<p><strong>👨‍🚒 Inspector Assigned:</strong> {$inspector->getFullName()}</p>"
            : '<p><strong>👨‍🚒 Inspector Assigned:</strong> Not yet assigned</p>'),
    'notice' =>
        $inspectionType === 'Reinspection'
            ? "
        <p><strong>⚠️ Important Notice:</strong> This is a reinspection due to previous remarks. Please ensure compliance before the scheduled date.</p>
    "
            : null,
    'contactEmail' => config('mail.from.address'),
])
