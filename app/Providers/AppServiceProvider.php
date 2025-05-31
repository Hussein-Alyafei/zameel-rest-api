<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', function (User $user) {
            return $user->role_id === Role::ADMIN;
        });

        Gate::define('manager', function (User $user) {
            return $user->role_id === Role::MANAGER;
        });

        Gate::define('academic', function (User $user) {
            return $user->role_id === Role::ACADEMIC;
        });

        Gate::define('representer', function (User $user) {
            return $user->role_id === Role::REPRESENTER;
        });

        Gate::define('student', function (User $user) {
            return $user->role_id === Role::STUDENT;
        });

        Password::defaults(function () {
            return Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols();
        });
    }
}
