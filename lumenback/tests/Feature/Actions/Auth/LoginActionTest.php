<?php

namespace Tests\Feature\Actions\Auth;

use App\Dtos\Auth\LoginData;
use App\Dtos\Auth\TokenResult;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tests\TestCase;

class LoginActionTest extends TestCase
{
    use RefreshDatabase;

    private AuthService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(AuthService::class);
    }

    public function test_login_returns_token_result(): void
    {
        $user = User::factory()->create(['password' => 'secret1234']);

        $result = $this->service->login(new LoginData($user->email, 'secret1234'));

        $this->assertInstanceOf(TokenResult::class, $result);
        $this->assertSame('Bearer', $result->type);
        $this->assertNotEmpty($result->token);
        $this->assertSame($user->id, $result->user->id);
    }

    public function test_login_throws_on_wrong_password(): void
    {
        $user = User::factory()->create(['password' => 'secret1234']);

        $this->expectException(UnauthorizedHttpException::class);
        $this->service->login(new LoginData($user->email, 'wrongpassword'));
    }

    public function test_login_throws_on_unknown_email(): void
    {
        $this->expectException(UnauthorizedHttpException::class);
        $this->service->login(new LoginData('nobody@example.com', 'secret1234'));
    }
}
