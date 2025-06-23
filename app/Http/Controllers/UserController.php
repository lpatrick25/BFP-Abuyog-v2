<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    /**
     * Update a User and associated User.
     */
    public function update(UserUpdateRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Find the user
            $user = User::findOrFail($id);

            // Check if the request contains a password
            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->password), // Hash password before saving
                ]);
            }

            DB::commit();
            Log::info('User updated successfully', ['user_id' => $user->id]);

            return response()->json(['message' => 'User updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating User', ['error' => $e->getMessage()]);

            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    /**
     * Get all User.
     */
    public function index(Request $request)
    {
        try {
            // Get pagination parameters from request
            $limit = $request->get('limit', 10); // Default to 10 records per page
            $page = $request->get('page', 1); // Default to page 1

            // Fetch only users that are related to User, Inspector, or Marshall
            $users = User::with(['client', 'inspector', 'marshall'])
                ->whereHas('client')
                ->orWhereHas('inspector')
                ->orWhereHas('marshall')
                ->paginate($limit, ['*'], 'page', $page);

            // Format response for Bootstrap Table
            return response()->json([
                'total' => $users->total(),    // Total number of records
                'rows' => $users->items(),     // Current page data
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching Users', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
}
