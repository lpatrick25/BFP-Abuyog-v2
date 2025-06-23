<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class LoginController extends Controller
{
    protected $maxAttempts = 3;
    protected $lockoutTime = 60;

    public function login(Request $request): JsonResponse
    {
        $cacheKey = 'login_attempts:' . md5($request->ip());

        if (Cache::has($cacheKey . ':lockout')) {
            $lockoutEnd = Cache::get($cacheKey . ':lockout');
            $secondsRemaining = Carbon::parse($lockoutEnd)->diffInSeconds(now());
            return response()->json([
                'status' => 'error',
                'message' => "Too many login attempts. Please try again in {$secondsRemaining} seconds.",
                'seconds_remaining' => $secondsRemaining,
                'lockout_end' => $lockoutEnd
            ], 429);
        }

        $attempts = Cache::get($cacheKey, 0);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $this->incrementAttempts($cacheKey, $attempts);
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
                'remaining_attempts' => $this->maxAttempts - ($attempts + 1)
            ], 422);
        }

        $user = User::withTrashed()->where('email', $request->email)->first();

        if (!$user || $user->trashed()) {
            $this->incrementAttempts($cacheKey, $attempts);
            return response()->json([
                'status' => 'error',
                'message' => 'Account is no longer available.',
                'remaining_attempts' => $this->maxAttempts - ($attempts + 1)
            ], 403);
        }

        if (!$user->is_active) {
            $this->incrementAttempts($cacheKey, $attempts);
            return response()->json([
                'status' => 'error',
                'message' => 'Your account is inactive. Please contact support.',
                'remaining_attempts' => $this->maxAttempts - ($attempts + 1)
            ], 403);
        }

        switch ($user->role) {
            case 'Client':
                $client = $user->client()->withTrashed()->first();
                if (!$client || $client->trashed()) {
                    $this->incrementAttempts($cacheKey, $attempts);
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Client account is no longer available.',
                        'remaining_attempts' => $this->maxAttempts - ($attempts + 1)
                    ], 403);
                }
                break;

            case 'Inspector':
                $inspector = $user->inspector()->withTrashed()->first();
                if (!$inspector || $inspector->trashed()) {
                    $this->incrementAttempts($cacheKey, $attempts);
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Inspector account is no longer available.',
                        'remaining_attempts' => $this->maxAttempts - ($attempts + 1)
                    ], 403);
                }
                break;

            case 'Marshall':
                $marshall = $user->marshall()->withTrashed()->first();
                if (!$marshall || $marshall->trashed()) {
                    $this->incrementAttempts($cacheKey, $attempts);
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Marshall account is no longer available.',
                        'remaining_attempts' => $this->maxAttempts - ($attempts + 1)
                    ], 403);
                }
                break;
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            Cache::forget($cacheKey);
            Cache::forget($cacheKey . ':lockout');

            $expiresAt = Carbon::now()->addDays(7);
            $tokenResult = $user->createToken('api-token', ['*'], $expiresAt);
            $token = $tokenResult->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'token' => $token,
                'expires_at' => $expiresAt->toISOString(),
                'user' => $user
            ], 200);
        }

        $this->incrementAttempts($cacheKey, $attempts);
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid email or password.',
            'remaining_attempts' => $this->maxAttempts - ($attempts + 1)
        ], 401);
    }

    protected function incrementAttempts($cacheKey, $attempts)
    {
        $attempts++;
        Cache::put($cacheKey, $attempts, $this->lockoutTime);

        if ($attempts >= $this->maxAttempts) {
            Cache::put($cacheKey . ':lockout', now()->addSeconds($this->lockoutTime)->toISOString(), $this->lockoutTime);
        }
    }

    public function checkLockout(Request $request): JsonResponse
    {
        $cacheKey = 'login_attempts:' . md5($request->ip());

        if (Cache::has($cacheKey . ':lockout')) {
            $lockoutEnd = Cache::get($cacheKey . ':lockout');
            $secondsRemaining = Carbon::parse($lockoutEnd)->diffInSeconds(now());
            return response()->json([
                'status' => 'locked',
                'message' => "Too many login attempts. Please try again in {$secondsRemaining} seconds.",
                'seconds_remaining' => $secondsRemaining,
                'lockout_end' => $lockoutEnd
            ], 429);
        }

        return response()->json([
            'status' => 'ok',
            'message' => 'No lockout active.'
        ], 200);
    }
}
