<?php

namespace App\Actions\User;

use App\Models\User;
use App\Repositories\UserRepository;

class DeleteUserAction
{
    public function __construct(private readonly UserRepository $repository) {}

    public function execute(int $id): User
    {
        /** @var User $model */
        $model = $this->repository->findById($id);
        $model->delete();

        return $model;
    }
}
