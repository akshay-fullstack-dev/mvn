<?php

namespace IntersoftStripe;

use Illuminate\Support\ServiceProvider;

class StripeApisServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang/', 'stripe');
    }
}
