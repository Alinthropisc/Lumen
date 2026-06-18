<?php

namespace App\Dtos\Auth;

final readonly class ResetPasswordData
{
    public function __construct(
        public string $email,
        public string $password,
        public string $code,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'],
            password: $data['password'],
            code: $data['code'],
        );
    }
}
