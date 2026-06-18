<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterBySearch extends QueryFilter
{
    public function __construct(private readonly ?string $search) {}

    public function handle(Builder $query, Closure $next): Builder
    {
        if ($this->hasValue($this->search)) {
            $query->where(function (Builder $q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        return $next($query);
    }
}
