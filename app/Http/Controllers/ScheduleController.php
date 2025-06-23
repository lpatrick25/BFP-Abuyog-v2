<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleStoreRequest;
use App\Http\Requests\ScheduleUpdateRequest;
use App\Http\Resources\Schedule\PaginatedScheduleResource;
use App\Http\Resources\Schedule\ScheduleResource;
use App\Services\ScheduleService;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{

    protected $scheduleService;
    protected $limit;
    protected $page;

    public function __construct(ScheduleService $scheduleService, Request $request)
    {
        $this->limit = (int) $request->get('limit', 10);
        $this->page = (int) $request->get('page', 1);
        $this->scheduleService = $scheduleService;
    }

    public function store(ScheduleStoreRequest $request): ScheduleResource
    {
        $schedule = $this->scheduleService->store($request->validated());

        return new ScheduleResource($schedule);
    }

    public function update(ScheduleUpdateRequest $request, $application_id): ScheduleResource
    {
        $schedule = $this->scheduleService->update($request->validated(), $application_id);

        return new ScheduleResource($schedule);
    }

    public function index(Request $request): PaginatedScheduleResource
    {
        $query = $this->scheduleService->getAllSchedule($request);
        $schedules = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new PaginatedScheduleResource($schedules);
    }
}
