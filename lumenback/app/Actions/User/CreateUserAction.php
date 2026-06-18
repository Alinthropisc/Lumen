<?php

namespace App\Actions\User;

use App\Models\User;
use App\Repositories\UserRepository;

class CreateUserAction
{
    public function __construct(private readonly UserRepository $repository) {}

    public function execute(array $data): User
    {
        return $this->repository->create($data);
    }
}
