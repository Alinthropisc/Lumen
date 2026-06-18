<?php

namespace App\Actions\User;

use App\Models\User;
use App\Repositories\UserRepository;

class UpdateUserAction
{
    public function __construct(private readonly UserRepository $repository) {}

    public function execute(array $data, int $id): User
    {
        return $this->repository->update($data, $id);
    }
}
