<?php

namespace App\Services;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApplicationService
{
    public function store(array $data)
    {
        try {
            DB::beginTransaction();
            $applicationNumber = $this->generateUniqueApplicationNumber();

            $data['application_number'] = $applicationNumber;
            $data['application_date'] = now();
            $application = Application::create($data);

            $this->handleFsicRequirements($application);

            DB::commit();

            return $application;
        } catch (\Exception $e) {
            DB::rollBack();
            return null;
        }
    }

    public function update(array $data, $id)
    {
        try {
            DB::beginTransaction();

            $application = Application::findOrFail($id);
            // Update application data if needed
            $application->update($data);

            // Handle re-uploaded FSIC requirements (only replace uploaded files)
            $this->handleFsicRequirements($application, true);

            DB::commit();

            return $application;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // Rethrow exception for proper error handling
        }
    }

    private function handleFsicRequirements(Application $application, bool $isUpdate = false)
    {
        $fsicType = $application->fsic_type;
        $requirements = config("fsic_requirements.$fsicType", []);

        foreach ($requirements as $requirement) {
            $inputName = Str::snake(str_replace(['(', ')', '/', ' '], '_', strtolower($requirement)));

            // Check if a file was uploaded for this requirement
            if (request()->hasFile($inputName)) {
                // If updating, remove the existing media with the same name (if it exists)
                if ($isUpdate) {
                    $existingMedia = $application->getMedia('fsic_requirements')
                        ->where('name', $requirement)
                        ->first();

                    if ($existingMedia) {
                        $existingMedia->delete(); // Delete only the specific media
                    }
                }

                // Add the new uploaded file
                $application->addMedia(request()->file($inputName))
                    ->usingName($requirement)
                    ->toMediaCollection('fsic_requirements');
            }
        }
    }

    public function getAllApplications(Request $request)
    {
        $user = auth()->user();
        $clientId = optional($user->client)->id;

        $application = Application::with(['establishment', 'latestStatus']);

        if (!$clientId) {
            if ($request->has('status')) {
                $application->whereHas('latestStatus', function ($query) use ($request) {
                    $query->where('status', $request->get('status'))
                    ->whereNull('remarks');
                });
            }

            return $application;
        }

        return $application
            ->whereHas('establishment', function ($query) use ($clientId) {
                $query->where('client_id', $clientId);
            });
    }

    private function generateUniqueApplicationNumber()
    {
        do {
            $applicationNumber = 'FSIC-' . strtoupper(Str::random(10));
        } while (Application::where('application_number', $applicationNumber)->exists());

        return $applicationNumber;
    }
}
