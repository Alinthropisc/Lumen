<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    private function actor(): User
    {
        return User::factory()->create();
    }

    public function test_index_returns_paginated_users(): void
    {
        Passport::actingAs($this->actor());
        User::factory()->count(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_show_returns_user(): void
    {
        $target = User::factory()->create();
        Passport::actingAs($this->actor());

        $response = $this->getJson("/api/users/{$target->id}");

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $target->id);
    }

    public function test_destroy_deletes_user(): void
    {
        $actor = $this->actor();
        Passport::actingAs($actor);

        $response = $this->deleteJson("/api/users/{$actor->id}");

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('users', ['id' => $actor->id]);
    }
}
