<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class SortBy extends QueryFilter
{
    private const ALLOWED_COLUMNS = ['id', 'name', 'email', 'created_at'];

    public function __construct(
        private readonly ?string $column = 'id',
        private readonly string $direction = 'desc',
    ) {}

    public function handle(Builder $query, Closure $next): Builder
    {
        $column = in_array($this->column, self::ALLOWED_COLUMNS, true)
            ? $this->column
            : 'id';

        $direction = in_array(strtolower($this->direction), ['asc', 'desc'], true)
            ? $this->direction
            : 'desc';

        return $next($query->orderBy($column, $direction));
    }
}
