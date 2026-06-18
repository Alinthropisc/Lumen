<?php

namespace App\Contracts;

use App\Models\User;

interface IUserRepository extends IBaseRepository
{
    public function findByEmail(string $email): ?User;

    public function findByEmailOrName(string $emailOrName): ?User;

    public function createToken(string $email): string;

    public function removeToken(string|User $user): int;
}
