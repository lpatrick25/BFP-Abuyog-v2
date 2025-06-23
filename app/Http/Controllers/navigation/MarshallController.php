<?php

namespace App\Http\Controllers\navigation;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Establishment;
use App\Models\Fsic;
use App\Models\Schedule;
use App\Models\User;
use App\Services\MappingService;
use App\Services\SessionTokenService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MarshallController extends Controller
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
            $marshall = $user->marshall;

            if (!$marshall) {
                throw new \Exception('Marshall profile not found.');
            }

            $metrics = [
                'pending_schedules' => Schedule::where('status', 'Ongoing')
                    ->count(),
                'completed_schedules' => Schedule::where('status', 'Completed')
                    ->count(),
                'total_establishments' => Establishment::count(),
                'total_applications' => Application::count(),
                'pending_applications' => Application::whereHas('applicationStatuses', function ($query) {
                    $query->where('status', 'Pending');
                })->count(),
                'completed_inspections' => Schedule::where('status', 'Completed')->count(),
                'issued_fsics' => Fsic::count(),
                'active_users' => User::where('is_active', true)->count(),
            ];

            return view('marshall.dashboard', compact('metrics', 'marshall'));
        } catch (\Exception $e) {
            Log::error('Error retrieving Marshall Dashboard View', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to load dashboard: ' . $e->getMessage());
        }
    }

    public function mapping()
    {
        try {
            $user = auth()->user();
            $role = $user->role ?? session('role');
            list($response, $summary) = $this->mappingService->getMappingData($role, $user);
            return view('marshall.mapping', compact('response', 'summary'));
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

    public function establishments()
    {
        try {
            return view('marshall.establishment');
        } catch (\Exception $e) {
            Log::error('Error retrieving Establishment View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Establishment View not found.'], 500);
        }
    }

    public function applicants()
    {
        try {
            // Get all inspectors
            $inspectors = User::where('role', 'Inspector')->with('inspector')->get();

            // Compute statistics directly
            $statistics = Application::with('latestStatus')
                ->get()
                ->groupBy(function ($application) {
                    return optional($application->latestStatus)->status ?? 'Unknown';
                })->map(function ($group) {
                    return $group->count();
                });

            // Initialize all possible statuses to 0 if not existing
            $finalStatistics = [
                'Under Review' => $statistics->get('Under Review', 0),
                'Scheduled for Inspection' => $statistics->get('Scheduled for Inspection', 0),
                'Certificate Approval Pending' => $statistics->get('Certificate Approval Pending', 0),
                'Certificate Issued' => $statistics->get('Certificate Issued', 0),
                'Denied' => $statistics->get('Denied', 0),
            ];

            return view('marshall.application', compact('inspectors', 'finalStatistics'));
        } catch (\Exception $e) {
            Log::error('Error retrieving Application View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Application View not found.'], 500);
        }
    }

    public function schedule()
    {
        try {
            // Retrieve all users with the role "Inspector" and eager-load the related Inspector model
            $inspectors = User::where('role', 'Inspector')->with('inspector')->get();

            // Pass the data to the view
            return view('marshall.schedule', compact('inspectors'));
        } catch (\Exception $e) {
            Log::error('Error retrieving Schedule View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Schedule View not found.'], 500);
        }
    }

    public function fsic()
    {
        try {
            return view('marshall.fsic');
        } catch (\Exception $e) {
            Log::error('Error retrieving FSIC View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'FSIC View not found.'], 500);
        }
    }

    public function reports()
    {
        try {
            return view('marshall.reports');
        } catch (\Exception $e) {
            Log::error('Error retrieving Reports View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Reports View not found.'], 500);
        }
    }

    public function reportsEstablishments()
    {
        try {
            return view('reports.establishment-reports');
        } catch (\Exception $e) {
            Log::error('Error retrieving Reports View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Reports View not found.'], 500);
        }
    }

    public function reportsApplications()
    {
        try {
            return view('reports.application-reports');
        } catch (\Exception $e) {
            Log::error('Error retrieving Reports View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Reports View not found.'], 500);
        }
    }

    public function reportsSchedules()
    {
        try {
            return view('reports.schedule-reports');
        } catch (\Exception $e) {
            Log::error('Error retrieving Reports View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Reports View not found.'], 500);
        }
    }

    public function reportsFsics()
    {
        try {
            return view('reports.fsic-reports');
        } catch (\Exception $e) {
            Log::error('Error retrieving Reports View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Reports View not found.'], 500);
        }
    }

    public function reportsCompliance()
    {
        try {
            return view('reports.compliance-reports');
        } catch (\Exception $e) {
            Log::error('Error retrieving Reports View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Reports View not found.'], 500);
        }
    }

    public function reportsStatistical()
    {
        try {
            $occupancyDistribution = Establishment::groupBy('type_of_occupancy')
                ->select('type_of_occupancy', DB::raw('count(*) as count'))
                ->get();
            return view('reports.statistical-reports', compact('occupancyDistribution'));
        } catch (\Exception $e) {
            Log::error('Error retrieving Reports View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Reports View not found.'], 500);
        }
    }

    public function reportsAudit()
    {
        try {
            return view('reports.audit-reports');
        } catch (\Exception $e) {
            Log::error('Error retrieving Reports View', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Reports View not found.'], 500);
        }
    }

    public function getApplication($id)
    {
        // Retrieve the application with its related establishment and client
        $application = Application::with(['establishment.client'])->find($id);

        if (!$application) {
            return response()->json([
                'error' => 'Application not found'
            ], 404);
        }

        return response()->json([
            'application' => $application
        ]);
    }

    public function getApplicationSchedule($id)
    {
        // Retrieve the application with its related establishment and client
        $application = Application::with(['schedule'])->find($id);

        if (!$application) {
            return response()->json([
                'error' => 'Application not found'
            ], 404);
        }

        return response()->json([
            'application' => $application
        ]);
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
