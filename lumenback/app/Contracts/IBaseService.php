<?php

namespace App\Contracts;

interface IBaseService
{
    public function paginatedList(array $data): mixed;

    public function createModel(array $data): mixed;

    public function updateModel(array $data, int $id): mixed;

    public function deleteModel(int $id): mixed;

    public function getModelById(int $id): mixed;
}
