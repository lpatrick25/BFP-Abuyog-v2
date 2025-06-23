<?php

namespace App\Services;

use App\Models\Establishment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EstablishmentService
{
    public function getAllEstablishments()
    {
        $establishment = Establishment::with('client', 'latestApplication.applicationStatuses');
        $client = auth()->user()->client;
        if ($client) {
            $establishment->where('client_id', $client->id);
        }

        return $establishment;
    }

    public function store(array $data)
    {
        try {
            DB::beginTransaction();
            $data['client_id'] = optional(auth()->user())->client->id;

            // Auto-set high_rise based on number_of_storey
            $data['high_rise'] = isset($data['number_of_storey']) && $data['number_of_storey'] > 0 ? true : false;

            $establishment = Establishment::create($data);

            DB::commit();
            return $establishment;
        } catch (\Exception $e) {
            Log::error('Failed to create establishment', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            DB::rollBack();
            return null;
        }
    }

    public function update(array $data, $id)
    {
        try {
            DB::beginTransaction();

            $establishment = Establishment::find($id);
            $establishment->update($data);
            DB::commit();

            return $establishment;
        } catch (\Exception $e) {
            DB::rollBack();
            return null;
        }
    }
}
