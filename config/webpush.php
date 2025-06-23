<?php

return [
    'vapid' => [
        'subject' => env('WEBPUSH_SUBJECT', 'mailto:your-email@example.com'),
        'public_key' => env('WEBPUSH_PUBLIC_KEY', ''),
        'private_key' => env('WEBPUSH_PRIVATE_KEY', ''),
    ],
];
