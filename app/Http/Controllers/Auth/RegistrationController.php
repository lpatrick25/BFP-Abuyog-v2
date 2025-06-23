<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Client;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client as HttpClient;

class RegistrationController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // Verify reCAPTCHA
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $recaptchaSecret = env('RECAPTCHA_SECRET_KEY');

        $httpClient = new HttpClient();

        try {
            $recaptchaVerification = $httpClient->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret' => $recaptchaSecret,
                    'response' => $recaptchaResponse,
                    'remoteip' => $request->ip(),
                ],
            ]);
            $recaptchaResult = json_decode($recaptchaVerification->getBody(), true);

            if (!$recaptchaResult['success']) {
                return response()->json(['error' => 'reCAPTCHA verification failed.'], 422);
            }
        } catch (\Exception $e) {
            Log::error('reCAPTCHA error: ' . $e->getMessage());
            return response()->json(['error' => 'reCAPTCHA verification error.'], 500);
        }

        DB::beginTransaction();

        try {
            $user = User::create([
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'role' => 'Client',
                'is_active' => true,
            ]);

            $client = Client::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'extension_name' => $request->extension_name,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
                'user_id' => $user->id,
            ]);

            Auth::login($user);

            $user->notify(new VerifyEmailNotification());

            DB::commit();
            Log::info('Client created successfully', ['client_id' => $client->id]);

            return response()->json(['message' => 'Account registration success', 'account' => $client], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            if ($e instanceof \Illuminate\Database\QueryException && $e->getCode() == 23000) {
                return response()->json([
                    'error' => 'The email or contact number already exists in our records.'
                ], 422);
            }

            Log::error('Error creating Client', ['error' => $e->getMessage()]);

            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
}
