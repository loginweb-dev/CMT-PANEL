<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TCG\Voyager\Facades\Voyager;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Voyager::addAction(\App\Actions\TeletrabajoCompartir::class);
        Voyager::addAction(\App\Actions\ConvocatoriaCompartir::class);
        Voyager::addAction(\App\Actions\GacetaCompartir::class);
        Voyager::addAction(\App\Actions\DocumentalCompartir::class);
    }
}
