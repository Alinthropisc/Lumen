<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Throwable;

trait RepositoryHelper
{
    /**
     * @throws Throwable
     */
    protected function query(): Builder|Model
    {
        $query = $this->getModel()->query();

        return $query->orderByDesc('id');
    }

    /**
     * @throws Throwable
     */
    protected function getModel(): Model
    {
        return $this->modelClass;
    }
}
