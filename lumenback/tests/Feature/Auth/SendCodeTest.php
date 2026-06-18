<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_code_queues_email_and_stores_verification(): void
    {
        Mail::fake();

        $response = $this->postJson('/api/auth/send-code', [
            'email' => 'user@example.com',
            'type' => 'register',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('email_verifications', ['email' => 'user@example.com']);
    }

    public function test_send_code_requires_valid_email(): void
    {
        $response = $this->postJson('/api/auth/send-code', [
            'email' => 'not-an-email',
            'type' => 'register',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_send_code_requires_valid_type(): void
    {
        $response = $this->postJson('/api/auth/send-code', [
            'email' => 'user@example.com',
            'type' => 'invalid_type',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['type']);
    }
}
