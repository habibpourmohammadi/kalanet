<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer("home.layouts.header", function ($view) {
            $view->with('categories', Category::where("parent_id", null)->get());
        });
        // get ticket messages
        view()->composer("admin.layouts.header", function ($view) {
            $view->with('messages', TicketMessage::where("seen", "false")->get());
        });
    }
}
