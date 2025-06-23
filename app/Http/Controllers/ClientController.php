<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientCreateRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Http\Resources\User\PaginatedUserResource;
use App\Http\Resources\User\UserResource;
use App\Models\Client;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{

    protected $userService;
    protected $limit;
    protected $page;

    public function __construct(UserService $userService, Request $request)
    {
        $this->limit = (int) $request->get('limit', 10);
        $this->page = (int) $request->get('page', 1);
        $this->userService = $userService;
    }

    public function store(ClientCreateRequest $request): UserResource
    {
        $user = $this->userService->store($request->validated(), 'Client');

        return new UserResource($user);
    }

    public function update(ClientUpdateRequest $request, $id): UserResource
    {
        $user = $this->userService->update($request->validated(), 'Client', $id);

        return new UserResource($user);
    }

    public function index(): PaginatedUserResource
    {
        $query = $this->userService->getAllUser('Client');
        $users = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new PaginatedUserResource($users);
    }

    public function destroy(Client $client): JsonResponse
    {
        try {
            DB::beginTransaction();

            $client->delete();

            DB::commit();

            return response()->json('', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json('Failed to delete', 500);
        }
    }
}
