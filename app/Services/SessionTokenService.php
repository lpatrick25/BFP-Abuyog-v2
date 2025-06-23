<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SessionTokenService
{
    /**
     * Generate a unique session token, store it with expiration, and return the token.
     *
     * @param mixed $sessionValue
     * @param int $minutes
     * @return array
     */
    public function generate($sessionValue, $minutes = 60)
    {
        try {
            $sessionID = (string) Str::uuid();
            session([$sessionID => $sessionValue]);
            session()->put('session_expiry_' . $sessionID, now()->addMinutes($minutes));
            return ['sessionID' => $sessionID];
        } catch (\Exception $e) {
            Log::error('Error generating session token', ['error' => $e->getMessage()]);
            return ['error' => 'Failed to generate session token.'];
        }
    }
}
