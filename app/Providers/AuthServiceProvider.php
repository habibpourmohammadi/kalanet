<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Color;
use App\Models\Delivery;
use App\Models\Guarantee;
use App\Models\Order;
use App\Models\Product;
use App\Models\Province;
use App\Models\Slider;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\BannerPolicy;
use App\Policies\BrandPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\CityPolicy;
use App\Policies\ColorPolicy;
use App\Policies\DeliveryPolicy;
use App\Policies\GuaranteePolicy;
use App\Policies\OrderPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ProductPolicy;
use App\Policies\ProvincePolicy;
use App\Policies\RolePolicy;
use App\Policies\SliderPolicy;
use App\Policies\TicketPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Permission::class => PermissionPolicy::class,
        Product::class => ProductPolicy::class,
        Category::class => CategoryPolicy::class,
        Brand::class => BrandPolicy::class,
        Color::class => ColorPolicy::class,
        Guarantee::class => GuaranteePolicy::class,
        Order::class => OrderPolicy::class,
        Delivery::class => DeliveryPolicy::class,
        Province::class => ProvincePolicy::class,
        City::class => CityPolicy::class,
        User::class => UserPolicy::class,
        Slider::class => SliderPolicy::class,
        Banner::class => BannerPolicy::class,
        Role::class => RolePolicy::class,
        Ticket::class => TicketPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
