<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\PermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed permissions.
        $this->call(PermissionSeeder::class);

        // Seed roles.
        $this->call(RoleSeeder::class);

        // Seed admin user.
        $this->call(AdminUserSeeder::class);
    }
}
