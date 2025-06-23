<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationStatusRequest;
use App\Services\ApplicationStatusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApplicationStatusController extends Controller
{
    protected $applicationStatusService;

    public function __construct(ApplicationStatusService $applicationStatusService)
    {
        $this->applicationStatusService = $applicationStatusService;
    }

    public function update(ApplicationStatusRequest $request, $application_id): JsonResponse
    {
        return $this->applicationStatusService->updateApplicationStatus($request, $application_id);
    }
}
