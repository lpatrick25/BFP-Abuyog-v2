<?php

namespace App\Services;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleService
{

    public function getAllSchedule(Request $request)
    {
        $schedule = Schedule::with(['application.establishment', 'inspector']);

        if (auth()->user()->role === 'Inspector') {
            $inspector = auth()->user()->inspector;

            if ($inspector) {
                if ($request->has('filter')) {
                    $schedule->where('inspector_id', $inspector->id)
                        ->where('status', 'Completed');
                } else {
                    $schedule->where('inspector_id', $inspector->id)
                        ->where('status', 'Ongoing');
                }
            }
        }

        if (auth()->user()->role === 'Client') {
            $client = auth()->user()->client;

            if ($client) {
                $schedule = Schedule::whereHas('application', function ($query) use ($client) {
                    $query->whereHas('establishment', function ($q) use ($client) {
                        $q->where('client_id', $client->id);
                    });
                });
            }
        }

        return $schedule;
    }

    public function store(array $data)
    {
        try {
            DB::beginTransaction();

            $schedule = Schedule::create($data);

            Log::info("Schedule created successfully", ['schedule_id' => $schedule->id]);
            DB::commit();

            return $schedule;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to create schedule", ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function update(array $data, $application_id)
    {
        try {
            DB::beginTransaction();

            $schedule = Schedule::where('application_id', $application_id)->first();

            if (!$schedule) {
                Log::warning("No schedule found for application ID: {$application_id}");
                return null;
            }

            $schedule->update($data);

            Log::info("Schedule updated successfully", ['schedule_id' => $schedule->id]);
            DB::commit();

            return $schedule;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to update schedule", ['error' => $e->getMessage()]);
            return null;
        }
    }
}
