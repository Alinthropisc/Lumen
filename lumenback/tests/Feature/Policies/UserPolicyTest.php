<?php

namespace Tests\Feature\Policies;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserPolicyTest extends TestCase
{
    use RefreshDatabase;

    private UserPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new UserPolicy;
    }

    public function test_user_can_update_own_profile(): void
    {
        $user = User::factory()->create();

        $this->assertTrue($this->policy->update($user, $user));
    }

    public function test_user_cannot_update_others_profile(): void
    {
        $actor = User::factory()->create();
        $target = User::factory()->create();

        $this->assertFalse($this->policy->update($actor, $target));
    }

    public function test_admin_can_update_any_profile(): void
    {
        Role::create(['name' => 'admin', 'guard_name' => 'web']);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $target = User::factory()->create();

        $this->assertTrue($this->policy->update($admin, $target));
    }
}
