<?php

namespace App\Contracts;

interface IBaseRepository
{
    public function paginatedList(array $data): mixed;

    public function create(array $data): mixed;

    public function update(array $data, int $id): mixed;

    public function delete(int $id): mixed;

    public function findById(int $id): mixed;
}
