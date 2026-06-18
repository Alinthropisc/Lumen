<?php

namespace App\Observers;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserObserver
{
    public function created(User $user): void
    {
        if (Role::where('name', 'user')->where('guard_name', 'api')->exists()) {
            $user->assignRole('user');
        }
    }
}
