<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        // $this->registerPolicies();

        // Define gates for role-based access control
        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('manager', function ($user) {
            return $user->isManager();
        });

        Gate::define('admin-manager', function ($user) {
            return $user->isAdmin() || $user->isManager();
        });


        Gate::define('accounts', function ($user) {
            return $user->isAccounts();
        });

        Gate::define('operations', function ($user) {
            return $user->isOperations();
        });
    }
}
