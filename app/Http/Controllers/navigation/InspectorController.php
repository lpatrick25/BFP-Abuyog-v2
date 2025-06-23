<?php

namespace App\Http\Controllers\navigation;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\Fsic;
use App\Models\Schedule;
use App\Services\MappingService;
use App\Services\SessionTokenService;
use Illuminate\Support\Facades\Log;

class InspectorController extends Controller
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
            $inspector = $user->inspector;

            if (!$inspector) {
                throw new \Exception('Inspector profile not found.');
            }

            $metrics = [
                'issued_fsics' => Fsic::where('inspector_id', $inspector->id)->count(),
                'pending_schedules' => Schedule::where('inspector_id', $inspector->id)
                    ->where('status', 'Ongoing')
                    ->count(),
                'completed_schedules' => Schedule::where('inspector_id', $inspector->id)
                    ->where('status', 'Completed')
                    ->count(),
                'total_applications' => \App\Models\Application::whereHas('fsics', function ($query) use ($inspector) {
                    $query->where('inspector_id', $inspector->id);
                })->count(),
            ];

            return view('inspector.dashboard', compact('metrics', 'inspector'));
        } catch (\Exception $e) {
            Log::error('Error retrieving Inspector Dashboard View', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to load dashboard: ' . $e->getMessage());
        }
    }

    public function mapping()
    {
        try {
            $user = auth()->user();
            $role = $user->role ?? session('role');
            list($response, $summary) = $this->mappingService->getMappingData($role, $user);
            return view('inspector.mapping', compact('response', 'summary'));
        } catch (\Exception $e) {
            Log::error('Error retrieving Mapping View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Mapping View not found.'], 500);
        }
    }

    public function showEstablishment($sessionID)
    {
        try {
            // Check if session exists and is not expired
            if (!session()->has($sessionID) || now()->greaterThan(session()->get('session_expiry_' . $sessionID))) {
                return redirect()->route('inspector.mapping')->with('error', 'Session expired.');
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

    public function schedule()
    {
        try {
            return view('inspector.schedule');
        } catch (\Exception $e) {
            Log::error('Error retrieving Schedule View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Schedule View not found.'], 500);
        }
    }

    public function inspected()
    {
        try {
            return view('inspector.inspected');
        } catch (\Exception $e) {
            Log::error('Error retrieving Schedule View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Schedule View not found.'], 500);
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
}
