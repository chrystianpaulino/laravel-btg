<?php

namespace BeeDelivery\Btg;

use Carbon\Laravel\ServiceProvider;

class BtgServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/btg.php', 'btg');

        // Register the service the package provides.
        $this->app->singleton('btg', function ($app) {
            return new Btg;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/btg.php' => config_path('btg.php'),
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['btg'];
    }
}
