<?php

namespace App\Providers;

use App\Services\Interfaces\IAuthService;
use App\Services\Interfaces\IOtpService;
use App\Services\Interfaces\IDeviceService;
use App\Services\AuthServices;
use App\Services\BookingServices;
use App\Services\Client;
use App\Services\Client\PackageServices;
use App\Services\CommonService;
use App\Services\CouponServices;
use App\Services\Interfaces\IMediaServices;
use App\Services\MediaServices;
use App\Services\OtpServices;
use App\Services\DeviceServices;
use App\Services\Interfaces\Client as IClient;
use App\Services\Interfaces\Client\IPackageServices;
use App\Services\Interfaces\IBookingServices;
use App\Services\Interfaces\ICommonService;
use App\Services\Interfaces\ICouponServices;
use App\Services\Interfaces\INotificationService;
use App\Services\Interfaces\IServicesServices;
use App\Services\Interfaces\IStripeServices;
use App\Services\Interfaces\IVehicleServices;
use App\Services\Interfaces\IVersionService;
use App\Services\NotificationService;
use App\Services\ServicesServices;
use App\Services\StripeServices;
use App\Services\VehicleServices;
use App\Services\VersionService;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IAuthService::class, AuthServices::class);
        $this->app->bind(IMediaServices::class, MediaServices::class);
        $this->app->bind(IOtpService::class, OtpServices::class);
        $this->app->bind(IDeviceService::class, DeviceServices::class);
        $this->app->bind(IServicesServices::class, ServicesServices::class);
        $this->app->bind(INotificationService::class, NotificationService::class);

        // client service binding
        $this->app->bind(IClient\IClientAuthService::class, Client\ClientAuthServices::class);
        $this->app->bind(IClient\IClientServices::class, Client\ClientServices::class);

        // bind stripe services
        $this->app->bind(IStripeServices::class, StripeServices::class);
        // bind vehicle services
        $this->app->bind(IVehicleServices::class, VehicleServices::class);
        // coupon service
        $this->app->bind(ICouponServices::class, CouponServices::class);
        // bind booking service
        $this->app->bind(IBookingServices::class, BookingServices::class);

        $this->app->bind(IVersionService::class, VersionService::class);

        $this->app->bind(ICommonService::class, CommonService::class);

        $this->app->bind(IPackageServices::class, PackageServices::class);


        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //data bse default string length for migration 
        Builder::defaultStringLength(191);
    }
}
