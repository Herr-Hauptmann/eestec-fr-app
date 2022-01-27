<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Gate::define('update-post', function (User $user, Post $post) {
        //     return $user->role_id == 1;
        // });
        Gate::define('manage-users', function (User $user) {
            return $user->role_id == 1;
        });
        Gate::define('manage-events', function (User $user) {
            return $user->role_id == 1;
        });
        Gate::define('manage-companies', function (User $user) {
            return $user->role_id == 1 || $user->role_id == 2;
        });
        Gate::define('manage-reports', function (User $user) {
            return $user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3;
        });
        Gate::define('manage-statuses', function (User $user) {
            return $user->role_id == 1 || $user->role_id == 2;
        });
        Gate::define('tl-manage-events', function (User $user) {
            return $user->role_id == 2;
        });
    }
}
