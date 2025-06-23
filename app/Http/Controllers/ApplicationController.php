<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationStoreRequest;
use App\Http\Requests\ApplicationUpdateRequest;
use App\Http\Resources\Application\ApplicationResource;
use App\Http\Resources\Application\PaginatedApplicationResource;
use App\Models\Application;
use App\Services\ApplicationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ApplicationController extends Controller
{
    protected $applicationService;
    protected $limit;
    protected $page;

    public function __construct(ApplicationService $applicationService, Request $request)
    {
        $this->limit = (int) $request->get('limit', 10);
        $this->page = (int) $request->get('page', 1);
        $this->applicationService = $applicationService;
    }

    public function store(ApplicationStoreRequest $request): ApplicationResource
    {
        $application = $this->applicationService->store($request->validated());

        return new ApplicationResource($application);
    }

    public function update(ApplicationUpdateRequest $request, $id): ApplicationResource
    {
        $application = $this->applicationService->update($request->validated(), $id);

        return new ApplicationResource($application);
    }

    public function destroy(Application $application): JsonResponse
    {
        try {
            DB::beginTransaction();

            $application->delete();

            DB::commit();

            return response()->json('', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json('Failed to delete', 500);
        }
    }

    public function index(Request $request): PaginatedApplicationResource
    {
        $query = $this->applicationService->getAllApplications($request);
        $applications = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new PaginatedApplicationResource($applications);
    }

    public function show(Application $application): Collection
    {
        return $application->getMedia('fsic_requirements')->map(function (Media $media) {
            return [
                'name' => $media->name,
                'url' => $media->getUrl(),
                'thumbnail' => $media->hasGeneratedConversion('thumbnail')
                    ? $media->getUrl('thumbnail')
                    : asset('img/bfp.svg'),
            ];
        });
    }
}
