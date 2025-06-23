<?php

namespace App\Http\Controllers;

use App\Http\Requests\FSICRequestRequest;
use App\Http\Resources\Fsic\FsicResource;
use App\Http\Resources\Fsic\PaginatedFsicResource;
use App\Models\Fsic;
use App\Services\FsicService;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FsicController extends Controller
{
    protected $fsicService;
    protected $limit;
    protected $page;

    public function __construct(FsicService $fsicService, Request $request)
    {
        $this->limit = (int) $request->get('limit', 10);
        $this->page = (int) $request->get('page', 1);
        $this->fsicService = $fsicService;
    }

    public function store(FSICRequestRequest $request): FsicResource
    {
        $fsic = $this->fsicService->store($request->validated());

        return new FsicResource($fsic);
    }

    public function index(): PaginatedFsicResource
    {
        $query = $this->fsicService->getFsicList();
        $fsics  = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new PaginatedFsicResource($fsics);
    }

    public function show(Fsic $fsic): Collection
    {
        return $fsic->application->getMedia('fsic_requirements')->map(function (Media $media) {
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
