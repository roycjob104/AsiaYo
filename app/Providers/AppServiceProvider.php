<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
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
        // Define the morph map
        Relation::morphMap([
            'orders_twd' => 'App\Models\Order\Currencies\OrderTwdModel',
            'orders_usd' => 'App\Models\Order\Currencies\OrderUsdModel',
            'orders_jpy' => 'App\Models\Order\Currencies\OrderJpyModel',
            'orders_rmb' => 'App\Models\Order\Currencies\OrderRmbModel',
            'orders_myr' => 'App\Models\Order\Currencies\OrderMyrModel',
        ]);
    }
}
