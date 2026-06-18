<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;
use Laravel\Passport\Client;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:keys', ['--force' => true]);

        Client::forceCreate([
            'id' => Str::uuid(),
            'owner_type' => null,
            'owner_id' => null,
            'name' => 'Test Personal Access Client',
            'secret' => Str::random(40),
            'provider' => 'users',
            'redirect_uris' => [],
            'grant_types' => ['personal_access'],
            'revoked' => false,
        ]);
    }
}
