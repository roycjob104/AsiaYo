<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        // Define the morph map
        Relation::morphMap([
            'order_twd' => 'App\Models\Order\Currencies\OrderTwdModel',
            'order_usd' => 'App\Models\Order\Currencies\OrderUsdModel',
            'order_jpy' => 'App\Models\Order\Currencies\OrderJpyModel',
            'order_rmb' => 'App\Models\Order\Currencies\OrderRmbModel',
            'order_myr' => 'App\Models\Order\Currencies\OrderMyrModel',
        ]);
    }
}
