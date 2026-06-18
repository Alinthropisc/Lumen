<?php

namespace App\Repositories;

use App\Constants\GeneralStatus;
use App\Contracts\IBaseRepository;
use App\Models\BaseModel;
use App\QueryFilters\FilterBySearch;
use App\QueryFilters\QueryFilter;
use App\QueryFilters\SortBy;
use App\Traits\RepositoryHelper;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;
use Throwable;

abstract class BaseRepository implements IBaseRepository
{
    use RepositoryHelper;

    protected Model $modelClass;

    public function __construct(Model $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    /**
     * @param  array|string|null  $with
     *
     * @throws Throwable
     */
    public function paginatedList(array $data, mixed $with = null): LengthAwarePaginator
    {
        $query = $this->getModel()::query();

        $query = app(Pipeline::class)
            ->send($query)
            ->through($this->buildFilters($data))
            ->thenReturn();

        if (! is_null($with)) {
            $query->with($with);
        }

        return $query->paginate($data['per_page'] ?? GeneralStatus::PER_PAGE);
    }

    /**
     * @return array<int, QueryFilter>
     */
    protected function buildFilters(array $data): array
    {
        return [
            new FilterBySearch($data['search'] ?? null),
            new SortBy($data['sort_by'] ?? 'id', $data['sort_direction'] ?? 'desc'),
        ];
    }

    /**
     * @return BaseModel|BaseModel[]|Builder|Builder[]|Collection|Model|null
     *
     * @throws Throwable
     */
    public function create(array $data): Model|array|Collection|Builder|BaseModel|null
    {
        $model = $this->getModel();
        $model->fill($data);
        $model->save();

        return $model;
    }

    /**
     * @return BaseModel|BaseModel[]|Builder|Builder[]|Collection|Model|null
     *
     * @throws Throwable
     */
    public function update(array $data, int $id): Model|array|Collection|Builder|BaseModel|null
    {
        $model = $this->findById($id);
        $model->fill($data);
        $model->save();

        return $model;
    }

    /**
     * @throws Throwable
     */
    public function delete(int $id): array|Builder|Collection|BaseModel|Model
    {
        $model = $this->findById($id);
        $model->delete();

        return $model;
    }

    /**
     * @throws Throwable
     */
    public function findById(int $id): Model|array|Collection|Builder|BaseModel|null
    {
        return $this->getModel()::query()->findOrFail($id);
    }
}
