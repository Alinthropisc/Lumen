<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterByStatus extends QueryFilter
{
    public function __construct(private readonly ?string $status) {}

    public function handle(Builder $query, Closure $next): Builder
    {
        if ($this->hasValue($this->status)) {
            $query->where('status', $this->status);
        }

        return $next($query);
    }
}
