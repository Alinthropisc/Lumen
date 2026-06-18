<?php

namespace App\Repositories;

use App\Contracts\IUserRepository;
use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function create(array $data): array|Collection|Builder|BaseModel|null
    {
        $model = $this->getModel();
        $model->fill($data);
        $model->save();

        if (isset($data['roles'])) {
            foreach ($data['roles'] as $role) {
                $model->assignRole($role['role_code']);
            }
        }

        return $model;
    }

    public function update(array $data, int $id): array|BaseModel|Builder|Collection|Model|null
    {
        $model = $this->findById($id);
        $model->fill($data);
        $model->save();

        if (isset($data['roles'])) {
            foreach ($data['roles'] as $role) {
                $model->assignRole($role['role_code']);
            }
        }

        return $model;
    }

    /**
     * @throws Throwable
     */
    public function findByEmail(string $email): ?User
    {
        $model = $this->getModel();

        return $model::query()->where('email', '=', $email)->first();
    }

    /**
     * @throws Throwable
     */
    public function findByEmailOrName(string $emailOrName): ?User
    {
        $model = $this->getModel();

        return $model::query()->where('email', '=', $emailOrName)->orWhere('name', '=', $emailOrName)->first();
    }

    /**
     * @throws Throwable
     */
    public function createToken(string $email): string
    {
        $model = $this->findByEmailOrName($email);

        return $model->createToken('auth_token')->accessToken;
    }

    /**
     * @throws Throwable
     */
    public function removeToken(string|User $email): int
    {
        if (is_string($email)) {
            $model = $this->findByEmail($email);
        } else {
            $model = $email;
        }

        return $model->tokens()->delete();
    }
}
