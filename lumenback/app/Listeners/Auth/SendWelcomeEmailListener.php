<?php

namespace App\Listeners\Auth;

use App\Events\Auth\UserRegistered;
use App\Jobs\SendWelcomeEmailJob;

class SendWelcomeEmailListener
{
    public function handle(UserRegistered $event): void
    {
        SendWelcomeEmailJob::dispatch($event->user);
    }
}
