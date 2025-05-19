<?php

namespace App\Providers;

use App\Models\Divida;
use App\Models\ParcelaDivida;
use App\Observers\DividaObserver;
use App\Observers\ParcelaDividaObserver;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Divida::observe(DividaObserver::class);
        ParcelaDivida::observe(ParcelaDividaObserver::class);
    }
}
