<?php

namespace Tests\Unit\Dtos;

use App\Dtos\Auth\TokenResult;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class TokenResultTest extends TestCase
{
    public function test_to_array_returns_correct_structure(): void
    {
        $user = new User;
        $user->email = 'user@example.com';

        $result = new TokenResult(
            type: 'Bearer',
            token: 'abc123',
            user: $user,
        );

        $array = $result->toArray();

        $this->assertArrayHasKey('type', $array);
        $this->assertArrayHasKey('token', $array);
        $this->assertArrayHasKey('user', $array);
        $this->assertSame('Bearer', $array['type']);
        $this->assertSame('abc123', $array['token']);
        $this->assertSame($user, $array['user']);
    }
}
