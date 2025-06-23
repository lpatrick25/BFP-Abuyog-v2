<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PushSubscription;
use Illuminate\Http\JsonResponse;

class PushNotificationController extends Controller
{
    public function storeSubscription(Request $request): JsonResponse
    {
        // Validate and store the subscription object in the database
        $validated = $request->validate([
            'endpoint' => 'required|string',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
        ]);

        PushSubscription::create([
            'endpoint' => $validated['endpoint'],
            'keys' => json_encode($validated['keys']),
        ]);

        return response()->json(['message' => 'Subscription stored successfully']);
    }
}
