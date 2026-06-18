<?php

namespace Tests\Unit\QueryFilters;

use App\Models\User;
use App\QueryFilters\SortBy;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class SortByTest extends BaseTestCase
{
    public function test_sorts_by_allowed_column(): void
    {
        $query = User::query();
        $filter = new SortBy('name', 'asc');
        $result = $filter->handle($query, fn ($q) => $q);

        $sql = $result->toSql();

        $this->assertStringContainsString('"name"', $sql);
        $this->assertStringContainsString('asc', strtolower($sql));
    }

    public function test_falls_back_to_id_for_unknown_column(): void
    {
        $query = User::query();
        $filter = new SortBy('hacked_column', 'desc');
        $result = $filter->handle($query, fn ($q) => $q);

        $sql = $result->toSql();

        $this->assertStringContainsString('"id"', $sql);
        $this->assertStringNotContainsString('"hacked_column"', $sql);
    }

    public function test_uses_desc_direction_by_default(): void
    {
        $query = User::query();
        $filter = new SortBy;
        $result = $filter->handle($query, fn ($q) => $q);

        $sql = $result->toSql();

        $this->assertStringContainsString('"id"', $sql);
        $this->assertStringContainsString('desc', strtolower($sql));
    }
}
