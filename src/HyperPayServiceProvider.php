<?php

namespace NoamanMahmoud\HyperPay;
use Illuminate\Support\ServiceProvider;

class HyperPayServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any package services.
     *
     * @return void
     */

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/hyperpay.php' => config_path('hyperpay.php'),
        ],'hyperpay');
    }

    /**
     * Register any application services.
     *
     * @return void
     */

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/hyperpay.php', 'hyperpay'
        );
    }
}