<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@lumen.test',
        ]);
        $admin->assignRole('admin');

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@lumen.test',
        ]);
    }
}
