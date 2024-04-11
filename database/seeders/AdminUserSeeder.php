<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Creates an admin user and assigns the admin role to them.
     */
    public function run(): void
    {
        // Get the admin email address from the environment variables or use a default one.
        $adminEmail = env("ADMIN_EMAIL_ADDRESS", "habibpourmohammady@gmail.com");

        // Create the admin user if it doesn't already exist, based on the provided email
        $admin = User::firstOrCreate([
            "email" => $adminEmail,
        ]);

        // Find the admin role.
        $adminRole = Role::where("name", "admin")->first();

        // If admin role found, assign it to the admin user.
        if ($adminRole) {
            $admin->syncRoles($adminRole);
        }
    }
}
