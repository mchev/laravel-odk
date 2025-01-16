<?php

namespace Mchev\LaravelOdk\Providers;

use Illuminate\Support\ServiceProvider;
use Mchev\LaravelOdk\OdkCentral;

class OdkCentralServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/config.php' => config_path('odkcentral.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'odkcentral');

        $this->app->bind('odkcentral', function ($app) {
            return new OdkCentral;
        });

    }
}
