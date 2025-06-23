<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstablishmentStoreRequest;
use App\Http\Requests\EstablishmentUpdateRequest;
use App\Http\Resources\Establishment\EstablishmentResource;
use App\Http\Resources\Establishment\PaginatedEstablishmentResource;
use App\Models\Establishment;
use App\Services\EstablishmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstablishmentController extends Controller
{

    protected $establishmentService;
    protected $limit;
    protected $page;

    public function __construct(EstablishmentService $establishmentService, Request $request)
    {
        $this->limit = (int) $request->get('limit', 10);
        $this->page = (int) $request->get('page', 1);
        $this->establishmentService = $establishmentService;
    }

    public function store(EstablishmentStoreRequest $request): EstablishmentResource
    {
        $establishment = $this->establishmentService->store($request->validated());

        return new EstablishmentResource($establishment);
    }

    public function update(EstablishmentUpdateRequest $request, $id): EstablishmentResource
    {
        $establishment = $this->establishmentService->update($request->validated(), $id);

        return new EstablishmentResource($establishment);
    }

    public function destroy(Establishment $establishment): JsonResponse
    {

        try {
            DB::beginTransaction();

            $establishment->delete();

            DB::commit();

            return response()->json('', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json('Failed to delete', 500);
        }
    }

    public function index(): PaginatedEstablishmentResource
    {
        $query = $this->establishmentService->getAllEstablishments();

        $establishments = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new PaginatedEstablishmentResource($establishments);
    }

    public function show(Establishment $establishment): EstablishmentResource
    {
        return new EstablishmentResource($establishment);
    }
}
