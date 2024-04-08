<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            "name" => "admin",
            "description" => "رول ادمین در وبسایت، قدرت انجام هر فعالیتی را داراست، از مدیریت کاربران و محتوا گرفته تا رفع مشکلات فنی و مدیریت امنیتی، این نقش مسئولیت‌های گسترده‌ای را بر عهده دارد و به عنوان مدیر اصلی وبسایت عمل می‌کند.",
        ]);
    }
}
