<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('assign-ticket', function ($user) {
            return in_array($user->role, ['admin']);
        });

        Gate::define('view-all-tickets', function ($user) {
            return in_array($user->role, ['admin','agent']);
        });
    }
}
