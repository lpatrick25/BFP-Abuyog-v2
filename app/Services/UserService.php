<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function store(array $data, string $role)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'password' => Hash::make($data['password']),
                'email' => $data['email'],
                'email_verified_at' => now(),
                'role' => $role,
                'is_active' => true,
            ]);

            $data['user_id'] = $user->id;

            $modelClass = $this->getModelClass($role);
            $model = $modelClass::create($data);

            DB::commit();

            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            return null;
        }
    }

    public function update(array $data, string $role, int $id)
    {
        try {
            $modelClass = $this->getModelClass($role);
            $model = $modelClass::findOrFail($id);

            $user = User::findOrFail($model->user_id);
            if (isset($data['email']) && $data['email'] !== $user->email) {
                $user->update(['email' => $data['email']]);
            }

            if (!empty($data['password'])) {
                $user->update(['password' => Hash::make($data['password'])]);
            }

            $model->update($data);

            DB::commit();

            return $model;
        } catch (\Exception $e) {
            DB::rollBack();

            return null;
        }
    }


    public function getAllUser(string $role)
    {
        $modelClass = $this->getModelClass($role);
        $model = $modelClass::with(['user']);

        return $model;
    }

    private function getModelClass(string $role): string
    {
        return match ($role) {
            'Client' => \App\Models\Client::class,
            'Inspector' => \App\Models\Inspector::class,
            'Marshall' => \App\Models\Marshall::class,
            default => throw new \InvalidArgumentException("Invalid role: $role"),
        };
    }
}
