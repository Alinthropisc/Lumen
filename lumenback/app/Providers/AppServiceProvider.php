<?php

namespace App\Providers;

use App\Contracts\IEmailVerificationRepository;
use App\Contracts\IUserRepository;
use App\Events\Auth\UserRegistered;
use App\Listeners\Auth\SendWelcomeEmailListener;
use App\Models\User;
use App\Observers\UserObserver;
use App\Policies\UserPolicy;
use App\Repositories\EmailVerificationRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IEmailVerificationRepository::class, EmailVerificationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);

        Event::listen(UserRegistered::class, SendWelcomeEmailListener::class);

        Gate::policy(User::class, UserPolicy::class);
    }
}
