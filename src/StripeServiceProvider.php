<?php

namespace Suraj1716\Onetimestripe;

use Illuminate\Support\ServiceProvider;

class StripeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'onetimestripe'
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('onetimestripe.php'),
        ], 'onetimestripe-config');


        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views','onetimestripe');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations','onetimestripe');
    }
}
