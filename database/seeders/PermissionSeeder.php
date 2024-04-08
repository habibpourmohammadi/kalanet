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
        Permission::create([
            "name" => "show_product",
            "description" => "توانایی دیدن محصولات",
        ]);
        Permission::create([
            "name" => "create_product",
            "description" => "توانایی ایجاد محصول",
        ]);
        Permission::create([
            "name" => "edit_product",
            "description" => "توانایی ویرایش محصول",
        ]);
        Permission::create([
            "name" => "delete_product",
            "description" => "توانایی حذف محصول",
        ]);

        // categories
        Permission::create([
            "name" => "show_category",
            "description" => "توانایی دیدن دسته بندی ها",
        ]);
        Permission::create([
            "name" => "create_category",
            "description" => "توانایی ایجاد دسته بندی",
        ]);
        Permission::create([
            "name" => "edit_category",
            "description" => "توانایی ویرایش دسته بندی",
        ]);
        Permission::create([
            "name" => "delete_category",
            "description" => "توانایی حذف دسته بندی",
        ]);

        // brands
        Permission::create([
            "name" => "show_brand",
            "description" => "توانایی دیدن برند ها",
        ]);
        Permission::create([
            "name" => "create_brand",
            "description" => "توانایی ایجاد برند",
        ]);
        Permission::create([
            "name" => "edit_brand",
            "description" => "توانایی ویرایش برند",
        ]);
        Permission::create([
            "name" => "delete_brand",
            "description" => "توانایی حذف برند",
        ]);

        // colors
        Permission::create([
            "name" => "show_color",
            "description" => "توانایی دیدن رنگ ها",
        ]);
        Permission::create([
            "name" => "create_color",
            "description" => "توانایی ایجاد رنگ",
        ]);
        Permission::create([
            "name" => "edit_color",
            "description" => "توانایی ویرایش رنگ",
        ]);
        Permission::create([
            "name" => "delete_color",
            "description" => "توانایی حذف رنگ",
        ]);

        // guarantees
        Permission::create([
            "name" => "show_guarantee",
            "description" => "توانایی دیدن گارانتی ها",
        ]);
        Permission::create([
            "name" => "create_guarantee",
            "description" => "توانایی ایجاد گارانتی",
        ]);
        Permission::create([
            "name" => "edit_guarantee",
            "description" => "توانایی ویرایش گارانتی",
        ]);
        Permission::create([
            "name" => "delete_guarantee",
            "description" => "توانایی حذف گارانتی",
        ]);

        // orders
        Permission::create([
            "name" => "show_order",
            "description" => "توانایی دیدن سفارشات",
        ]);

        // deliveries
        Permission::create([
            "name" => "show_delivery",
            "description" => "توانایی دیدن روش های حمل و نقل",
        ]);
        Permission::create([
            "name" => "create_delivery",
            "description" => "توانایی ایجاد روش حمل و نقل",
        ]);
        Permission::create([
            "name" => "edit_delivery",
            "description" => "توانایی ویرایش روش حمل و نقل",
        ]);
        Permission::create([
            "name" => "delete_delivery",
            "description" => "توانایی حذف روش حمل و نقل",
        ]);

        // provinces
        Permission::create([
            "name" => "show_province",
            "description" => "توانایی دیدن استان ها",
        ]);
        Permission::create([
            "name" => "create_province",
            "description" => "توانایی ایجاد استان",
        ]);
        Permission::create([
            "name" => "edit_province",
            "description" => "توانایی ویرایش استان",
        ]);
        Permission::create([
            "name" => "delete_province",
            "description" => "توانایی حذف استان",
        ]);

        // cities
        Permission::create([
            "name" => "show_city",
            "description" => "توانایی دیدن شهر ها",
        ]);
        Permission::create([
            "name" => "create_city",
            "description" => "توانایی ایجاد شهر",
        ]);
        Permission::create([
            "name" => "edit_city",
            "description" => "توانایی ویرایش شهر",
        ]);
        Permission::create([
            "name" => "delete_city",
            "description" => "توانایی حذف شهر",
        ]);

        // users
        Permission::create([
            "name" => "show_user",
            "description" => "توانایی دیدن کاربران",
        ]);
        Permission::create([
            "name" => "cahange_status_user",
            "description" => "توانایی تغییر وضعیت کاربر",
        ]);

        // roles
        Permission::create([
            "name" => "show_role",
            "description" => "توانایی دیدن نقش ها",
        ]);
        Permission::create([
            "name" => "create_role",
            "description" => "توانایی ایجاد نقش",
        ]);
        Permission::create([
            "name" => "edit_role",
            "description" => "توانایی ویرایش نقش",
        ]);
        Permission::create([
            "name" => "delete_role",
            "description" => "توانایی حذف نقش",
        ]);

        // permissions
        Permission::create([
            "name" => "show_permission",
            "description" => "توانایی دیدن مجوز ها",
        ]);

        // sliders
        Permission::create([
            "name" => "show_slider",
            "description" => "توانایی دیدن اسلایدر ها",
        ]);
        Permission::create([
            "name" => "create_slider",
            "description" => "توانایی ایجاد اسلایدر",
        ]);

        Permission::create([
            "name" => "edit_slider",
            "description" => "توانایی ویرایش اسلایدر",
        ]);
        Permission::create([
            "name" => "delete_slider",
            "description" => "توانایی حذف اسلایدر",
        ]);

        // banners
        Permission::create([
            "name" => "show_banner",
            "description" => "توانایی دیدن بنر ها",
        ]);
        Permission::create([
            "name" => "create_banner",
            "description" => "توانایی ایجاد بنر",
        ]);
        Permission::create([
            "name" => "edit_banner",
            "description" => "توانایی ویرایش بنر",
        ]);
        Permission::create([
            "name" => "delete_banner",
            "description" => "توانایی حذف بنر",
        ]);

        // tickets
        Permission::create([
            "name" => "show_ticket",
            "description" => "توانایی دیدن تیکت ها",
        ]);
        Permission::create([
            "name" => "show_messages_ticket",
            "description" => "توانایی دیدن پیام های تیکت",
        ]);
        Permission::create([
            "name" => "send_message_ticket",
            "description" => "توانایی ارسال پیام در تیکت",
        ]);
        Permission::create([
            "name" => "change_status_ticket",
            "description" => "توانایی تغییر وضعیت تیکت",
        ]);
        Permission::create([
            "name" => "delete_ticket",
            "description" => "توانایی حذف تیکت",
        ]);

        // emails
        Permission::create([
            "name" => "show_email",
            "description" => "توانایی دیدن اطلاعیه های ایمیلی",
        ]);
        Permission::create([
            "name" => "create_email",
            "description" => "توانایی ایجاد اطلاعیه ایمیلی",
        ]);
        Permission::create([
            "name" => "send_email",
            "description" => "توانایی ارسال اطلاعیه ایمیلی",
        ]);
        Permission::create([
            "name" => "edit_email",
            "description" => "توانایی ویرایش اطلاعیه ایمیلی",
        ]);
        Permission::create([
            "name" => "delete_email",
            "description" => "توانایی حذف اطلاعیه ایمیلی",
        ]);

        // coupon discounts
        Permission::create([
            "name" => "show_coupon",
            "description" => "توانایی دیدن کوپن های تخفیف",
        ]);
        Permission::create([
            "name" => "create_coupon",
            "description" => "توانایی ایجاد کوپن تخفیف",
        ]);
        Permission::create([
            "name" => "edit_coupon",
            "description" => "توانایی ویرایش کوپن تخفیف",
        ]);
        Permission::create([
            "name" => "change_status_coupon",
            "description" => "توانایی تغییر وضعیت کوپن تخفیف",
        ]);
        Permission::create([
            "name" => "delete_coupon",
            "description" => "توانایی حذف کوپن تخفیف",
        ]);

        // general discounts
        Permission::create([
            "name" => "show_general_discount",
            "description" => "توانایی دیدن تخفیف های عمومی",
        ]);
        Permission::create([
            "name" => "create_general_discount",
            "description" => "توانایی ایجاد تخفیف عمومی",
        ]);
        Permission::create([
            "name" => "edit_general_discount",
            "description" => "توانایی ویرایش تخفیف عمومی",
        ]);
        Permission::create([
            "name" => "change_status_general_discount",
            "description" => "توانایی تغییر وضعیت تخفیف عمومی",
        ]);
        Permission::create([
            "name" => "delete_general_discount",
            "description" => "توانایی حذف تخفیف عمومی",
        ]);

        // payments
        Permission::create([
            "name" => "show_payment",
            "description" => "توانایی دیدن پرداخت ها",
        ]);
        Permission::create([
            "name" => "change_status_payment",
            "description" => "توانایی تغییر وضعیت پرداخت",
        ]);
    }
}
