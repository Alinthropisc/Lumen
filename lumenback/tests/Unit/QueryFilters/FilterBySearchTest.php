<?php

namespace Tests\Unit\QueryFilters;

use App\QueryFilters\FilterBySearch;
use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\TestCase;

class FilterBySearchTest extends TestCase
{
    private function makeBuilder(bool $expectsWhere): Builder
    {
        $builder = $this->createMock(Builder::class);

        if ($expectsWhere) {
            $builder->expects($this->once())->method('where')->willReturnSelf();
        } else {
            $builder->expects($this->never())->method('where');
        }

        return $builder;
    }

    public function test_filter_applies_when_search_provided(): void
    {
        $builder = $this->createMock(Builder::class);
        $builder->expects($this->once())
            ->method('where')
            ->willReturnSelf();

        $filter = new FilterBySearch('john');
        $result = $filter->handle($builder, fn (Builder $q) => $q);

        $this->assertSame($builder, $result);
    }

    public function test_filter_skipped_when_search_null(): void
    {
        $builder = $this->createMock(Builder::class);
        $builder->expects($this->never())->method('where');

        $filter = new FilterBySearch(null);
        $result = $filter->handle($builder, fn (Builder $q) => $q);

        $this->assertSame($builder, $result);
    }

    public function test_filter_skipped_when_search_empty(): void
    {
        $builder = $this->createMock(Builder::class);
        $builder->expects($this->never())->method('where');

        $filter = new FilterBySearch('');
        $result = $filter->handle($builder, fn (Builder $q) => $q);

        $this->assertSame($builder, $result);
    }
}
