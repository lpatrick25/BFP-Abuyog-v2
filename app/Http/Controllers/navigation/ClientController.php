<?php

namespace App\Http\Controllers\navigation;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Establishment;
use App\Services\MappingService;
use App\Services\SessionTokenService;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    protected $sessionTokenService;
    protected $mappingService;

    public function __construct(SessionTokenService $sessionTokenService, MappingService $mappingService)
    {
        $this->sessionTokenService = $sessionTokenService;
        $this->mappingService = $mappingService;
    }

    public function dashboards()
    {
        try {
            $user = auth()->user();
            $client = $user->client;

            if (!$client) {
                throw new \Exception('Client profile not found.');
            }

            $metrics = [
                'total_establishments' => Establishment::where('client_id', $client->id)->count(),
                'total_applications' => Application::whereHas('establishment', function ($query) use ($client) {
                    $query->where('client_id', $client->id);
                })->count(),
                'pending_applications' => Application::whereHas('establishment', function ($query) use ($client) {
                    $query->where('client_id', $client->id);
                })->whereHas('applicationStatuses', function ($query) {
                    $query->where('status', 'Pending');
                })->count(),
                'issued_fsics' => \App\Models\Fsic::whereHas('application.establishment', function ($query) use ($client) {
                    $query->where('client_id', $client->id);
                })->count(),
            ];

            return view('client.dashboard', compact('metrics', 'client'));
        } catch (\Exception $e) {
            Log::error('Error retrieving Client Dashboard View', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to load dashboard: ' . $e->getMessage());
        }
    }

    public function mapping()
    {
        try {
            $user = auth()->user();
            $role = $user->role;
            list($response, $summary) = $this->mappingService->getMappingData($role, $user);
            return view('client.mapping', compact('response', 'summary'));
        } catch (\Exception $e) {
            Log::error('Error retrieving Mapping View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Mapping View not found.'], 500);
        }
    }

    public function establishments()
    {
        try {
            return view('client.establishment');
        } catch (\Exception $e) {
            Log::error('Error retrieving Establishment View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Establishment View not found.'], 500);
        }
    }

    public function applications()
    {
        try {
            return view('client.application');
        } catch (\Exception $e) {
            Log::error('Error retrieving Application View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Application View not found.'], 500);
        }
    }

    public function schedules()
    {
        try {
            return view('client.schedule');
        } catch (\Exception $e) {
            Log::error('Error retrieving Schedule View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Schedule View not found.'], 500);
        }
    }

    public function addEstablishment()
    {
        try {
            return view('establishment.create');
        } catch (\Exception $e) {
            Log::error('Error retrieving Establishment View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Establishment View not found.'], 500);
        }
    }

    public function addApplication()
    {
        try {
            $client = optional(auth()->user())->client;
            $establishments = Establishment::where('client_id', $client->id)->get();
            return view('application.create', compact('establishments'));
        } catch (\Exception $e) {
            Log::error('Error retrieving Application View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Application View not found.'], 500);
        }
    }

    public function editEstablishment($sessionID)
    {
        try {
            // Check if session exists and is not expired
            if (!session()->has($sessionID) || now()->greaterThan(session()->get('session_expiry_' . $sessionID))) {
                return redirect()->route('establishment.list')->with('error', 'Session expired.');
            }

            // Retrieve the establishment ID from the session
            $userId = session()->get($sessionID);

            // Fetch the establishment data
            $establishment = Establishment::findOrFail($userId);

            return view('establishment.update', compact('establishment'));
        } catch (\Exception $e) {
            Log::error('Error retrieving Establishment View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Establishment View not found.'], 500);
        }
    }

    public function showEstablishment($sessionID)
    {
        try {
            // Check if session exists and is not expired
            if (!session()->has($sessionID) || now()->greaterThan(session()->get('session_expiry_' . $sessionID))) {
                return redirect()->route('establishment.list')->with('error', 'Session expired.');
            }

            // Retrieve the establishment ID from the session
            $userId = session()->get($sessionID);

            // Fetch the establishment data
            $establishment = Establishment::findOrFail($userId);

            return view('establishment.show', compact('establishment'));
        } catch (\Exception $e) {
            Log::error('Error retrieving Establishment View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Establishment View not found.'], 500);
        }
    }

    public function fsic()
    {
        try {
            return view('client.fsic');
        } catch (\Exception $e) {
            Log::error('Error retrieving FSIC View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'FSIC View not found.'], 500);
        }
    }

    public function generateSessionToken($sessionId)
    {
        $result = $this->sessionTokenService->generate($sessionId);
        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 500);
        }
        return response()->json(['sessionID' => $result['sessionID']]);
    }

    public function getEstablishmentApplication($establishmentId)
    {
        try {
            // Fetch establishment with applications and FSICs
            $establishment = Establishment::with(['applications.fsics'])->find($establishmentId);

            $haveFSICApplication = false;
            $haveFSICExpired = false;

            if ($establishment && $establishment->applications->isNotEmpty()) {
                foreach ($establishment->applications as $application) {
                    if ($application->fsics->isNotEmpty()) {
                        $haveFSICApplication = true; // There is at least one FSIC application

                        foreach ($application->fsics as $fsic) {
                            if ($fsic->expiration_date && $fsic->expiration_date->isPast()) {
                                $haveFSICExpired = true;
                                break 2;
                            }
                        }
                    }
                }
            }

            return response()->json([
                'haveFSICApplication' => $haveFSICApplication,
                'haveFSICExpired' => $haveFSICExpired,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error retrieving Establishment Application', ['error' => $e->getMessage()]);

            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
}
