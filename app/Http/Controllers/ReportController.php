<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\Establishment;
use App\Models\Fsic;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Main dashboard for reports
    public function index()
    {
        return view('reports');
    }

    // Establishment Reports
    public function establishmentReports(Request $request): JsonResponse
    {
        $query = Establishment::with('client')
            ->select('id', 'name', 'trade_name', 'client_id', 'total_building_area', 'type_of_occupancy', 'address_brgy', 'high_rise', 'eminent_danger')
            ->when($request->high_rise, fn($query) => $query->where('high_rise', 1))
            ->when($request->eminent_danger, fn($query) => $query->where('eminent_danger', 1));

        // Handle server-side pagination and sorting
        $total = $query->count();
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');

        $establishments = $query->orderBy($sort, $order)
            ->skip($offset)
            ->take($limit)
            ->get()
            ->map(function ($establishment) {
                $establishment->client_name = optional($establishment->client)->getFullName() ?? 'N/A';
                return $establishment;
            });

        return response()->json([
            'total' => $total,
            'rows' => $establishments
        ]);
    }

    // Application Reports
    public function applicationReports(Request $request): JsonResponse
    {
        $query = Application::with(['establishment', 'applicationStatuses'])
            ->select('id', 'application_number', 'establishment_id', 'fsic_type', 'application_date')
            ->when($request->fsic_type, fn($query) => $query->where('fsic_type', $request->fsic_type));
            // ->withTrashed();

        $total = $query->count();
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');

        $applications = $query->orderBy($sort, $order)
            ->skip($offset)
            ->take($limit)
            ->get()
            ->map(function ($application) {
                $application->establishment_name = $application->establishment->name ?? 'N/A';
                $application->latest_status = $application->applicationStatuses->isNotEmpty() ? $application->applicationStatuses->last()->status : null;
                $application->latest_remarks = $application->applicationStatuses->isNotEmpty() ? $application->applicationStatuses->last()->remarks : null;
                return $application;
            });

        return response()->json([
            'total' => $total,
            'rows' => $applications
        ]);
    }

    // Inspection Schedule Reports
    public function scheduleReports(Request $request): JsonResponse
    {
        $query = Schedule::with(['application.establishment', 'inspector'])
            ->select('id', 'application_id', 'inspector_id', 'schedule_date', 'status')
            ->when($request->status, fn($query) => $query->where('status', $request->status));
            // ->withTrashed();

        $total = $query->count();
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');

        $schedules = $query->orderBy($sort, $order)
            ->skip($offset)
            ->take($limit)
            ->get()
            ->map(function ($schedule) {
                $schedule->application_number = $schedule->application->application_number ?? 'N/A';
                $schedule->establishment_name = $schedule->application->establishment->name ?? 'N/A';
                $schedule->inspector_name = optional($schedule->inspector)->getFullName() ?? 'N/A';
                return $schedule;
            });

        return response()->json([
            'total' => $total,
            'rows' => $schedules
        ]);
    }

    // FSIC Reports
    public function fsicReports(Request $request): JsonResponse
    {
        $query = Fsic::with(['application.establishment', 'inspector', 'marshall'])
            ->select('id', 'fsic_no', 'application_id', 'issue_date', 'expiration_date', 'amount', 'or_number', 'payment_date')
            ->when($request->expired, fn($query) => $query->where('expiration_date', '<', now()));
            // ->withTrashed();

        $total = $query->count();
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');

        $fsics = $query->orderBy($sort, $order)
            ->skip($offset)
            ->take($limit)
            ->get()
            ->map(function ($fsic) {
                $fsic->establishment_name = $fsic->application->establishment->name ?? 'N/A';
                return $fsic;
            });

        return response()->json([
            'total' => $total,
            'rows' => $fsics
        ]);
    }

    // Compliance and Risk Reports
    public function complianceReports(Request $request): JsonResponse
    {
        $query = Establishment::leftJoin('applications', 'establishments.id', '=', 'applications.establishment_id')
            ->leftJoin('application_statuses', 'applications.id', '=', 'application_statuses.application_id')
            ->leftJoin('fsics', 'applications.id', '=', 'fsics.application_id')
            ->select(
                'establishments.id',
                'establishments.name',
                'establishments.address_brgy',
                'establishments.contact_number',
                'applications.application_number',
                'application_statuses.status',
                'fsics.fsic_no',
                'fsics.expiration_date'
            )
            ->where(function ($query) {
                $query->whereNull('fsics.fsic_no')
                    ->orWhere('fsics.expiration_date', '<', now())
                    ->orWhereNotIn('application_statuses.status', ['Approved']);
            });

        $total = $query->count();
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $sort = $request->input('sort', 'establishments.id');
        $order = $request->input('order', 'asc');

        $nonCompliant = $query->orderBy($sort, $order)
            ->skip($offset)
            ->take($limit)
            ->get();

        return response()->json([
            'total' => $total,
            'rows' => $nonCompliant
        ]);
    }

    // Audit and Historical Reports
    public function auditReports(Request $request): JsonResponse
    {
        $query = ApplicationStatus::with('application.establishment')
            ->select('id', 'application_id', 'status', 'remarks', 'created_at', 'updated_at')
            ->when($request->application_id, fn($query) => $query->where('application_id', $request->application_id));
            // ->withTrashed();

        $total = $query->count();
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'asc');

        $applicationHistory = $query->orderBy($sort, $order)
            ->skip($offset)
            ->take($limit)
            ->get()
            ->map(function ($status) {
                $status->application_number = $status->application->application_number ?? 'N/A';
                $status->establishment_name = $status->application->establishment->name ?? 'N/A';
                return $status;
            });

        return response()->json([
            'total' => $total,
            'rows' => $applicationHistory
        ]);
    }
}
