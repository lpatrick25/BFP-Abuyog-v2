<?php

namespace App\Services;

use App\Models\Establishment;
use Illuminate\Support\Facades\Log;

class MappingService
{
    /**
     * Get mapping data for establishments by role.
     *
     * @param string $role
     * @param \App\Models\User|null $user
     * @return array [response, summary]
     */
    public function getMappingData($role, $user)
    {
        $response = [];
        $summary = [
            'inspected' => 0,
            'not_inspected' => 0,
            'not_applied' => 0,
        ];

        $establishmentsQuery = Establishment::query()->with(['applications.fsics']);
        if ($role === 'Client' && $user && $user->client) {
            $establishmentsQuery->where('client_id', $user->client->id);
        }
        $establishments = $establishmentsQuery->get();

        // if ($role === 'client' && $establishments->isEmpty()) {
        //     throw new \Exception('Establishment not found.');
        // }

        foreach ($establishments as $establishment) {
            $application = $establishment->applications->first();
            $inspected = $application && $application->fsics->isNotEmpty();

            if (!$application) {
                if (!in_array($role, ['marshall', 'inspector'])) {
                    $summary['not_applied']++;
                    $response[] = [
                        floatval($establishment->location_latitude),
                        floatval($establishment->location_longitude),
                        $establishment->id,
                        false,
                        'Not Applied'
                    ];
                }
            } else {
                $inspected ? $summary['inspected']++ : $summary['not_inspected']++;
                $response[] = [
                    floatval($establishment->location_latitude),
                    floatval($establishment->location_longitude),
                    $establishment->id,
                    $inspected,
                    $inspected ? 'Inspected' : 'Not Inspected'
                ];
            }
        }
        return [$response, $summary];
    }
}
