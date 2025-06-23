<?php

namespace App\Services;

use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ApplicationStatusService
{
    public function updateApplicationStatus($request, $application_id)
    {
        try {
            DB::beginTransaction();

            $application = Application::findOrFail($application_id);
            $schedule = Schedule::where('application_id', $application_id)->first();

            $currentStatus = $request->status === 'Certificate Approval Pending'
                ? 'Scheduled for Inspection'
                : $request->status;

            $applicationStatus = ApplicationStatus::where('application_id', $application_id)
                ->where('status', $currentStatus)
                ->whereNull('remarks')
                ->first();

            if ($request->status === 'Certificate Approval Pending' && $schedule) {
                $schedule->update(['status' => 'Completed']);
            }

            if ($applicationStatus) {
                $applicationStatus->update(['remarks' => $request->remarks]);
            }

            ApplicationStatus::create([
                'application_id' => $application_id,
                'status' => $request->status,
            ]);

            if ($request->hasFile('image_proof')) {
                Session::put('skip_schedule_notification_again', true);
                $application->addMedia($request->file('image_proof'))
                    ->usingName('Proof of Investigation')
                    ->toMediaCollection('fsic_requirements');
            }

            if ($request->hasFile('image_proof_reject')) {
                Session::put('skip_schedule_notification_again_again', true);
                $application->addMedia($request->file('image_proof_reject'))
                    ->usingName('Proof of Investigation Rejected')
                    ->toMediaCollection('fsic_requirements');
            }

            if ($request->filled('schedule_date') && $schedule) {
                Session::put('skip_schedule_notification', true);
                $schedule->update(['schedule_date' => $request->schedule_date]);
            }

            DB::commit();
            Log::info("Application status updated for Application ID: {$application_id}");
            return response()->json(['message' => 'Application status updated'], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to update application status: " . $e->getMessage());
            return response()->json(['message' => 'Failed to update application status'], 500);
        }
    }
}
