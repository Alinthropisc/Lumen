<?php

namespace Tests\Unit\Contracts;

use App\Contracts\IUserRepository;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryContractTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_repository_implements_interface(): void
    {
        $repo = app(IUserRepository::class);

        $this->assertInstanceOf(UserRepository::class, $repo);
    }
}
