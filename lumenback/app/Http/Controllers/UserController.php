<?php

namespace App\Http\Controllers;

use App\Actions\User\CreateUserAction;
use App\Actions\User\DeleteUserAction;
use App\Actions\User\UpdateUserAction;
use App\Constants\UsersRoles;
use App\Dtos\ApiResponse;
use App\Http\Requests\StoreRequest\StoreUserRequest;
use App\Http\Requests\UpdateRequest\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $service,
        private readonly CreateUserAction $createAction,
        private readonly UpdateUserAction $updateAction,
        private readonly DeleteUserAction $deleteAction,
    ) {}

    /**
     * @throws Throwable
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return UserResource::collection($this->service->paginatedList($request->all()));
    }

    /**
     * @throws Throwable
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        return ApiResponse::success(['user' => $this->createAction->execute($request->validated())]);
    }

    /**
     * @throws Throwable
     */
    public function show(int $usersId): UserResource
    {
        $model = $this->service->getModelById($usersId);
        $this->authorize('view', $model);

        return new UserResource($model);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateUserRequest $request, int $usersId): JsonResponse
    {
        $model = $this->service->getModelById($usersId);
        $this->authorize('update', $model);

        return ApiResponse::success(['user' => $this->updateAction->execute($request->validated(), $usersId)]);
    }

    /**
     * @throws Throwable
     */
    public function destroy(int $usersId): JsonResponse
    {
        $model = $this->service->getModelById($usersId);
        $this->authorize('delete', $model);

        return ApiResponse::success(['deleted' => $this->deleteAction->execute($usersId)]);
    }

    public function roles(): JsonResponse
    {
        $role = new UsersRoles;

        return ApiResponse::success($role->getRoleList());
    }
}
