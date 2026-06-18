<?php

namespace Tests\Unit\Dtos;

use App\Dtos\Auth\LoginData;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class LoginDataTest extends TestCase
{
    public function test_from_array_creates_correct_instance(): void
    {
        $data = [
            'email' => 'user@example.com',
            'password' => 'secret1234',
        ];

        $dto = LoginData::fromArray($data);

        $this->assertInstanceOf(LoginData::class, $dto);
        $this->assertSame('user@example.com', $dto->email);
        $this->assertSame('secret1234', $dto->password);
    }

    public function test_properties_are_readonly(): void
    {
        $reflection = new ReflectionClass(LoginData::class);

        foreach ($reflection->getProperties() as $property) {
            $this->assertTrue($property->isReadOnly(), "Property {$property->getName()} should be readonly");
        }
    }
}
