<?php

namespace App\Dtos\Auth;

final readonly class RegisterData
{
    public function __construct(
        public string $email,
        public string $password,
        public string $code,
        public ?string $name = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'],
            password: $data['password'],
            code: $data['code'],
            name: $data['name'] ?? null,
        );
    }
}
