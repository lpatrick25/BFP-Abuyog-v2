@include('emails.layout', [
    'subject' => $subject,
    'clientName' => $client->getFullName(),
    'body' =>
        "
        <p>Your application for the establishment <strong>{$establishment->name}</strong>, located at <strong>{$establishment->address_brgy}</strong>, has been scheduled for a <strong>" .
        strtolower($inspectionType) .
        "</strong>.</p>
    ",
    'details' =>
        "
        <p><strong>📅 Inspection Date:</strong> " .
        date('F j, Y', strtotime($scheduleDate)) .
        "</p>
        <p><strong>📝 Inspection Type:</strong> {$inspectionType}</p>
        <p><strong>👨‍🚒 Inspector Assigned:</strong> {$inspector->getFullName()}</p>
    ",
    'notice' =>
        $inspectionType === 'Reinspection'
            ? "
        <p><strong>⚠️ Important Notice:</strong> This is a reinspection due to previous remarks. Please ensure compliance before the scheduled date.</p>
    "
            : null,
    'contactEmail' => config('mail.from.address'),
])
