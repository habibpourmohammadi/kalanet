<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // products
        Permission::create(["name" => "show_product"]);
        Permission::create(["name" => "create_product"]);
        Permission::create(["name" => "edit_product"]);
        Permission::create(["name" => "delete_product"]);

        // categories
        Permission::create(["name" => "show_category"]);
        Permission::create(["name" => "create_category"]);
        Permission::create(["name" => "edit_category"]);
        Permission::create(["name" => "delete_category"]);

        // brands
        Permission::create(["name" => "show_brand"]);
        Permission::create(["name" => "create_brand"]);
        Permission::create(["name" => "edit_brand"]);
        Permission::create(["name" => "delete_brand"]);

        // colors
        Permission::create(["name" => "show_color"]);
        Permission::create(["name" => "create_color"]);
        Permission::create(["name" => "edit_color"]);
        Permission::create(["name" => "delete_color"]);

        // guarantees
        Permission::create(["name" => "show_guarantee"]);
        Permission::create(["name" => "create_guarantee"]);
        Permission::create(["name" => "edit_guarantee"]);
        Permission::create(["name" => "delete_guarantee"]);

        // orders
        Permission::create(["name" => "show_order"]);

        // deliveries
        Permission::create(["name" => "show_delivery"]);
        Permission::create(["name" => "create_delivery"]);
        Permission::create(["name" => "edit_delivery"]);
        Permission::create(["name" => "delete_delivery"]);

        // provinces
        Permission::create(["name" => "show_province"]);
        Permission::create(["name" => "create_province"]);
        Permission::create(["name" => "edit_province"]);
        Permission::create(["name" => "delete_province"]);

        // cities
        Permission::create(["name" => "show_city"]);
        Permission::create(["name" => "create_city"]);
        Permission::create(["name" => "edit_city"]);
        Permission::create(["name" => "delete_city"]);

        // users
        Permission::create(["name" => "show_user"]);
        Permission::create(["name" => "cahange_status_user"]);

        // roles
        Permission::create(["name" => "show_role"]);
        Permission::create(["name" => "create_role"]);
        Permission::create(["name" => "edit_role"]);
        Permission::create(["name" => "delete_role"]);

        // permissions
        Permission::create(["name" => "show_permission"]);

        // sliders
        Permission::create(["name" => "show_slider"]);
        Permission::create(["name" => "create_slider"]);
        Permission::create(["name" => "edit_slider"]);
        Permission::create(["name" => "delete_slider"]);

        // banners
        Permission::create(["name" => "show_banner"]);
        Permission::create(["name" => "create_banner"]);
        Permission::create(["name" => "edit_banner"]);
        Permission::create(["name" => "delete_banner"]);
    }
}
