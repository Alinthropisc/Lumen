<?php

namespace App\Dtos\User;

use App\Models\User;

final readonly class UserData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $createdAt,
    ) {}

    public static function fromModel(User $user): self
    {
        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            createdAt: $user->created_at->toDateTimeString(),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->createdAt,
        ];
    }
}
