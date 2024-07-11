<?php

namespace App\Providers;

use App\Http\Middleware\ResourceHandler;
use App\Http\Resources\Handler;
use App\Http\Resources\Interfaces\IHandler;
use Illuminate\Support\ServiceProvider;

class ResourceServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $kernel = $this->app['Illuminate\Contracts\Http\Kernel'];
         $kernel->pushMiddleware(ResourceHandler::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IHandler::class, Handler::class);
    }
}
