<?php

namespace App\Providers;

use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AclServiceProvider extends ServiceProvider
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
        if (Permission::count() == 0) {
            $permissionSeeder = new PermissionSeeder();
            $roleSeeder = new RoleSeeder();

            $permissionSeeder->run();
            $roleSeeder->run();

            $role = Role::where("name", "admin")->first();
            $permissions = Permission::all();

            $role->givePermissionTo($permissions);
        }
    }
}
