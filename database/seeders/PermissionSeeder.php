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

        $permissions = [
            // Products Permissions
            [
                "name" => "show_product",
                "description" => "توانایی دیدن محصولات",
            ],
            [
                "name" => "create_product",
                "description" => "توانایی ایجاد محصول",
            ],
            [
                "name" => "edit_product",
                "description" => "توانایی ویرایش محصول",
            ],
            [
                "name" => "delete_product",
                "description" => "توانایی حذف محصول",
            ],

            // Categories Permissions
            [
                "name" => "show_category",
                "description" => "توانایی دیدن دسته بندی ها",
            ],
            [
                "name" => "create_category",
                "description" => "توانایی ایجاد دسته بندی",
            ],
            [
                "name" => "edit_category",
                "description" => "توانایی ویرایش دسته بندی",
            ],
            [
                "name" => "delete_category",
                "description" => "توانایی حذف دسته بندی",
            ],

            // Brands Permissions
            [
                "name" => "show_brand",
                "description" => "توانایی دیدن برند ها",
            ],
            [
                "name" => "create_brand",
                "description" => "توانایی ایجاد برند",
            ],
            [
                "name" => "edit_brand",
                "description" => "توانایی ویرایش برند",
            ],
            [
                "name" => "delete_brand",
                "description" => "توانایی حذف برند",
            ],

            // Colors Permissions
            [
                "name" => "show_color",
                "description" => "توانایی دیدن رنگ ها",
            ],
            [
                "name" => "create_color",
                "description" => "توانایی ایجاد رنگ",
            ],
            [
                "name" => "edit_color",
                "description" => "توانایی ویرایش رنگ",
            ],
            [
                "name" => "delete_color",
                "description" => "توانایی حذف رنگ",
            ],

            // Guarantees Permissions
            [
                "name" => "show_guarantee",
                "description" => "توانایی دیدن گارانتی ها",
            ],
            [
                "name" => "create_guarantee",
                "description" => "توانایی ایجاد گارانتی",
            ],
            [
                "name" => "edit_guarantee",
                "description" => "توانایی ویرایش گارانتی",
            ],
            [
                "name" => "delete_guarantee",
                "description" => "توانایی حذف گارانتی",
            ],

            // Orders Permissions
            [
                "name" => "show_order",
                "description" => "توانایی دیدن سفارشات",
            ],

            // Deliveries Permissions
            [
                "name" => "show_delivery",
                "description" => "توانایی دیدن روش های حمل و نقل",
            ],
            [
                "name" => "create_delivery",
                "description" => "توانایی ایجاد روش حمل و نقل",
            ],
            [
                "name" => "edit_delivery",
                "description" => "توانایی ویرایش روش حمل و نقل",
            ],
            [
                "name" => "delete_delivery",
                "description" => "توانایی حذف روش حمل و نقل",
            ],

            // Provinces Permissions
            [
                "name" => "show_province",
                "description" => "توانایی دیدن استان ها",
            ],
            [
                "name" => "create_province",
                "description" => "توانایی ایجاد استان",
            ],
            [
                "name" => "edit_province",
                "description" => "توانایی ویرایش استان",
            ],
            [
                "name" => "delete_province",
                "description" => "توانایی حذف استان",
            ],

            // Cities Permissions
            [
                "name" => "show_city",
                "description" => "توانایی دیدن شهر ها",
            ],
            [
                "name" => "create_city",
                "description" => "توانایی ایجاد شهر",
            ],
            [
                "name" => "edit_city",
                "description" => "توانایی ویرایش شهر",
            ],
            [
                "name" => "delete_city",
                "description" => "توانایی حذف شهر",
            ],

            // Users Permissions
            [
                "name" => "show_user",
                "description" => "توانایی دیدن کاربران",
            ],
            [
                "name" => "cahange_status_user",
                "description" => "توانایی تغییر وضعیت کاربر",
            ],

            // Roles Permissions
            [
                "name" => "show_role",
                "description" => "توانایی دیدن نقش ها",
            ],
            [
                "name" => "create_role",
                "description" => "توانایی ایجاد نقش",
            ],
            [
                "name" => "edit_role",
                "description" => "توانایی ویرایش نقش",
            ],
            [
                "name" => "delete_role",
                "description" => "توانایی حذف نقش",
            ],

            // Permissions Permissions
            [
                "name" => "show_permission",
                "description" => "توانایی دیدن مجوز ها",
            ],

            // Sliders Permissions
            [
                "name" => "show_slider",
                "description" => "توانایی دیدن اسلایدر ها",
            ],
            [
                "name" => "create_slider",
                "description" => "توانایی ایجاد اسلایدر",
            ],
            [
                "name" => "edit_slider",
                "description" => "توانایی ویرایش اسلایدر",
            ],
            [
                "name" => "delete_slider",
                "description" => "توانایی حذف اسلایدر",
            ],

            // Banners Permissions
            [
                "name" => "show_banner",
                "description" => "توانایی دیدن بنر ها",
            ],
            [
                "name" => "create_banner",
                "description" => "توانایی ایجاد بنر",
            ],
            [
                "name" => "edit_banner",
                "description" => "توانایی ویرایش بنر",
            ],
            [
                "name" => "delete_banner",
                "description" => "توانایی حذف بنر",
            ],

            // Tickets Permissions
            [
                "name" => "show_ticket",
                "description" => "توانایی دیدن تیکت ها",
            ],
            [
                "name" => "show_messages_ticket",
                "description" => "توانایی دیدن پیام های تیکت",
            ],
            [
                "name" => "send_message_ticket",
                "description" => "توانایی ارسال پیام در تیکت",
            ],
            [
                "name" => "change_status_ticket",
                "description" => "توانایی تغییر وضعیت تیکت",
            ],
            [
                "name" => "delete_ticket",
                "description" => "توانایی حذف تیکت",
            ],

            // Emails Permissions
            [
                "name" => "show_email",
                "description" => "توانایی دیدن اطلاعیه های ایمیلی",
            ],
            [
                "name" => "create_email",
                "description" => "توانایی ایجاد اطلاعیه ایمیلی",
            ],
            [
                "name" => "send_email",
                "description" => "توانایی ارسال اطلاعیه ایمیلی",
            ],
            [
                "name" => "edit_email",
                "description" => "توانایی ویرایش اطلاعیه ایمیلی",
            ],
            [
                "name" => "delete_email",
                "description" => "توانایی حذف اطلاعیه ایمیلی",
            ],

            // Coupon Discounts Permissions
            [
                "name" => "show_coupon",
                "description" => "توانایی دیدن کوپن های تخفیف",
            ],
            [
                "name" => "create_coupon",
                "description" => "توانایی ایجاد کوپن تخفیف",
            ],
            [
                "name" => "edit_coupon",
                "description" => "توانایی ویرایش کوپن تخفیف",
            ],
            [
                "name" => "change_status_coupon",
                "description" => "توانایی تغییر وضعیت کوپن تخفیف",
            ],
            [
                "name" => "delete_coupon",
                "description" => "توانایی حذف کوپن تخفیف",
            ],

            // General Discounts Permissions
            [
                "name" => "show_general_discount",
                "description" => "توانایی دیدن تخفیف های عمومی",
            ],
            [
                "name" => "create_general_discount",
                "description" => "توانایی ایجاد تخفیف عمومی",
            ],
            [
                "name" => "edit_general_discount",
                "description" => "توانایی ویرایش تخفیف عمومی",
            ],
            [
                "name" => "change_status_general_discount",
                "description" => "توانایی تغییر وضعیت تخفیف عمومی",
            ],
            [
                "name" => "delete_general_discount",
                "description" => "توانایی حذف تخفیف عمومی",
            ],

            // Payments Permissions
            [
                "name" => "show_payment",
                "description" => "توانایی دیدن پرداخت ها",
            ],
            [
                "name" => "change_status_payment",
                "description" => "توانایی تغییر وضعیت پرداخت",
            ],
        ];

        foreach($permissions as $permission){
            Permission::create($permission);
        }
    }
}
