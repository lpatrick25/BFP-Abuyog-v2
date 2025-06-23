<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        switch ($user->role) {
            case 'Client':
                $client = $user->client;
                if ($client) {
                    $client->update($request->all());
                    return new UserResource($client);
                }
                break;
            case 'Marshall':
                $marshall = $user->marshall;
                if ($marshall) {
                    $marshall->update($request->all());
                    return new UserResource($marshall);
                }
                break;
            case 'Inspector':
                $inspector = $user->inspector;
                if ($inspector) {
                    $inspector->update($request->all());
                    return new UserResource($inspector);
                }
                break;
            default:
                return redirect()->back()->with('error', 'Profile update failed. User role not recognized.');
        }
    }

    public function toggleStatus($id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $user->is_active = !$user->is_active; // Cleaner toggle
            $user->save();

            DB::commit();

            Log::info('User status toggled', ['user_id' => $user->id]);

            return response()->json(['message' => 'User status updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to toggle user status', ['error' => $e->getMessage()]);

            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
}
