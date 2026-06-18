<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest\StoreCrudGeneratorRequest;
use App\Http\Requests\UpdateRequest\UpdateCrudGeneratorRequest;
use App\Http\Resources\CrudGeneratorResource;
use App\Models\CrudGenerator;
use App\Services\CrudGeneratorService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class CrudGeneratorController extends Controller
{
    private CrudGeneratorService $service;

    public function __construct(CrudGeneratorService $service)
    {
        $this->service = $service;
    }

    /**
     * @return AnonymousResourceCollection
     *
     * @throws Throwable
     */
    public function index(Request $request)
    {
        return CrudGeneratorResource::collection($this->service->paginatedList($request->all()));
    }

    /**
     * @throws Throwable
     */
    public function store(StoreCrudGeneratorRequest $request): array|Builder|Collection|CrudGenerator
    {
        return $this->service->createModel($request->validated());

    }

    /**
     * @return CrudGeneratorResource
     *
     * @throws Throwable
     */
    public function show(int $CrudgeneratorId)
    {
        return new CrudGeneratorResource($this->service->getModelById($CrudgeneratorId));
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateCrudGeneratorRequest $request, int $CrudgeneratorId): array|CrudGenerator|Collection|Builder
    {
        return $this->service->updateModel($request->validated(), $CrudgeneratorId);

    }

    /**
     * @throws Throwable
     */
    public function destroy(int $CrudgeneratorId): array|Builder|Collection|CrudGenerator
    {
        return $this->service->deleteModel($CrudgeneratorId);
    }
}
