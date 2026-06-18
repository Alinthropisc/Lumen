<?php

namespace App\Services;

use App\Contracts\IBaseService;
use App\Models\BaseModel;
use App\Repositories\BaseRepository;
use App\Traits\ServiceHelper;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Throwable;

abstract class BaseService implements IBaseService
{
    use ServiceHelper;

    protected ?BaseRepository $repository;

    /**
     * @throws Throwable
     */
    public function paginatedList(array $data): LengthAwarePaginator
    {
        return $this->repository->paginatedList($data);
    }

    /**
     * @return BaseModel|BaseModel[]|Builder|Builder[]|Collection|Model|null
     *
     * @throws Throwable
     */
    public function createModel(array $data): Model|array|Collection|Builder|BaseModel|null
    {
        return $this->getRepository()->create($data);
    }

    /**
     * @return BaseModel|BaseModel[]|Builder|Builder[]|Collection|Model|null
     *
     * @throws Throwable
     */
    public function updateModel(array $data, int $id): Model|array|Collection|Builder|BaseModel|null
    {
        return $this->getRepository()->update($data, $id);
    }

    /**
     * @return array|Builder|Builder[]|Collection|Model|Model[]
     *
     * @throws Throwable
     */
    public function deleteModel(int $id): array|Builder|Collection|Model
    {
        return $this->getRepository()->delete($id);
    }

    /**
     * @return BaseModel|BaseModel[]|Builder|Builder[]|Collection|Model|null
     *
     * @throws Throwable
     */
    public function getModelById(int $id): Model|array|Collection|Builder|BaseModel|null
    {
        return $this->getRepository()->findById($id);
    }
}
