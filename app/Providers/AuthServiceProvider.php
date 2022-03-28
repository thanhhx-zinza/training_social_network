<?php

namespace App\Providers;

use App\Models\Admin;
use App\Policies\PostPolicy;
use App\Policies\AdminPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-list', function ($admin) {
            return $admin->checkPermissionAcess(config("permission.access.admins-list"));
        });
        Gate::define('admin-add', function ($admin) {
            return $admin->checkPermissionAcess(config("permission.access.admins-add"));
        });
        Gate::define('admin-edit', function ($admin) {
            return $admin->checkPermissionAcess(config("permission.access.admins-edit"));
        });
        Gate::define('admin-delete', function ($admin) {
            return $admin->checkPermissionAcess(config("permission.access.admins-delete"));
        });

        Gate::define('post-list', function ($post) {
            return $post->checkPermissionAcess(config("permission.access.posts-list"));
        });
        Gate::define('post-add', function ($post) {
            return $post->checkPermissionAcess(config("permission.access.posts-add"));
        });
        Gate::define('post-edit', function ($post) {
            return $post->checkPermissionAcess(config("permission.access.posts-edit"));
        });
        Gate::define('post-delete', function ($post) {
            return $post->checkPermissionAcess(config("permission.access.posts-delete"));
        });

        Gate::define('users-list', function ($user) {
            return $user->checkPermissionAcess(config("permission.access.users-list"));
        });
        Gate::define('users-add', function ($user) {
            return $user->checkPermissionAcess(config("permission.access.users-add"));
        });
        Gate::define('users-edit', function ($user) {
            return $user->checkPermissionAcess(config("permission.access.users-edit"));
        });
        Gate::define('users-delete', function ($user) {
            return $user->checkPermissionAcess(config("permission.access.users-delete"));
        });
    }
}
