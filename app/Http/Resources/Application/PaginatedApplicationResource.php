<?php

namespace App\Http\Resources\Application;

use App\Http\Resources\PaginatedResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class PaginatedApplicationResource extends PaginatedResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function data($collection): AnonymousResourceCollection
    {
        return ApplicationResource::collection($collection);
    }

    /**
     * Override toResponse() to remove meta and links
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'rows' => $this->data($this->collection),
            'pagination' => $this->pagination,
        ]);
    }
}

