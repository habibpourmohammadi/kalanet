<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Runs the role creation and permission assignment process.
     */
    public function run(): void
    {
        // Create admin role
        Role::create([
            "name" => "admin",
            "description" => "رول ادمین در وبسایت، قدرت انجام هر فعالیتی را داراست، از مدیریت کاربران و محتوا گرفته تا رفع مشکلات فنی و مدیریت امنیتی، این نقش مسئولیت‌های گسترده‌ای را بر عهده دارد و به عنوان مدیر اصلی وبسایت عمل می‌کند.",
        ]);

        // Retrieve admin role
        $role = Role::where("name", "admin")->first();

        // Retrieve all permissions
        $permissions = Permission::all();

        // Assign all permissions to admin role
        $role->givePermissionTo($permissions);
    }
}
