<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    abstract public function handle(Builder $query, Closure $next): Builder;

    protected function hasValue(mixed $value): bool
    {
        return ! is_null($value) && $value !== '' && $value !== [];
    }
}
