<?php

namespace App\Dtos\Auth;

use App\Models\User;

final readonly class TokenResult
{
    public function __construct(
        public string $type,
        public string $token,
        public User $user,
    ) {}

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'token' => $this->token,
            'user' => $this->user,
        ];
    }
}
