<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiV1Routes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiV1Routes()
    {  // load basic auth api's
        $this->loadVendorRoutes();

        // load client url
        $this->loadClientRoutes();

        // load common user routes
        $this->loadCommonRoutes();
    }

    // this function will load the auth routes
    private function loadVendorRoutes()
    {
        Route::prefix('v1')->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/vendor/auth.php'));

        Route::prefix('v1')->middleware(['api', 'auth:api'])
            ->namespace($this->namespace . '\v1')
            ->group(base_path('routes/api/v1/vendor/notification.php'));

        Route::prefix('v1')->middleware(['api', 'check_blocked'])
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/vendor/service.php'));

        Route::prefix('v1')->middleware(['api', 'check_blocked'])
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/vendor/stripe.php'));

        Route::prefix('v1')->middleware(['api', 'check_blocked'])
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/vendor/vehicle.php'));

        Route::prefix('v1')->middleware(['api', 'check_blocked'])
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/vendor/coupon.php'));

        Route::prefix('v1')->middleware(['api', 'check_blocked'])
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/vendor/booking.php'));
    }

    // ------------------------client url section started
    private function loadClientRoutes()
    {
        Route::prefix('v1/client')->middleware(['api'])
            ->namespace($this->namespace . '\v1\Client')
            ->group(base_path('routes/api/v1/client/auth.php'));

        // add service routes
        Route::prefix('v1/client')->middleware(['api'])
            ->namespace($this->namespace . '\v1\Client')
            ->group(base_path('routes/api/v1/client/service.php'));

        // Load route for the packages
        Route::prefix('v1/package')->middleware('api')
            ->namespace($this->namespace . '\v1\Client')
            ->group(base_path('routes/api/v1/client/package.php'));
    }
    private function loadCommonRoutes()
    {
        Route::prefix('v1')->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/media.php'));

        Route::prefix('v1')->middleware('api')
            ->namespace($this->namespace, '\v1')
            ->group(base_path('routes/api/v1/common_apis.php'));
    }
}
