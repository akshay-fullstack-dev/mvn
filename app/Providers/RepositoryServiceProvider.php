<?php

namespace App\Providers;

use App\Repositories\AuthUserRepository;
use App\Repositories\BookingPaymentRepository;
use App\Repositories\BookingRepository;
use App\Repositories\OtpRepository;
use App\Repositories\DeviceRepository;
use App\Repositories\Interfaces\IAuthUserRepository;
use App\Repositories\Interfaces\IBookingPaymentRepository;
use App\Repositories\Interfaces\IBookingRepository;
use App\Repositories\Interfaces\IUserDocumentRepository;
use App\Repositories\Interfaces\ITempUserDocumentRepository;
use App\Repositories\TempUserDocumentRepository;
use App\Repositories\UserDocumentRepository;
use App\Repositories\Interfaces\IOtpRepository;
use App\Repositories\Interfaces\IDeviceRepository;
use App\Repositories\Interfaces\INotificationRepository;
use App\Repositories\Interfaces\IPackageRepository;
use App\Repositories\Interfaces\IReferralPriceRepository;
use App\Repositories\Interfaces\IServiceCategoryRepository;
use App\Repositories\Interfaces\IServiceRepository;
use App\Repositories\Interfaces\ITempUserAddressRepository;
use App\Repositories\Interfaces\ITempUserRepository;
use App\Repositories\Interfaces\IUserServiceRepository;
use App\Repositories\Interfaces\IUserVehicleRepository;
use App\Repositories\Interfaces\IVehicleRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\PackageRepository;
use App\Repositories\ReferralPriceRepository;
use App\Repositories\ServiceCategoryRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\TempUserAddressRepository;
use App\Repositories\TempUserRepository;
use App\Repositories\UserServiceRepository;
use App\Repositories\UserVehicleRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\IPackageMaintenanceRepository;
use App\Repositories\PackageMaintenanceRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IAuthUserRepository::class, AuthUserRepository::class);
        $this->app->bind(IUserDocumentRepository::class, UserDocumentRepository::class);
        $this->app->bind(IOtpRepository::class, OtpRepository::class);
        $this->app->bind(IDeviceRepository::class, DeviceRepository::class);
        $this->app->bind(ITempUserDocumentRepository::class, TempUserDocumentRepository::class);
        $this->app->bind(ITempUserRepository::class, TempUserRepository::class);
        $this->app->bind(ITempUserAddressRepository::class, TempUserAddressRepository::class);
        $this->app->bind(IServiceRepository::class, ServiceRepository::class);
        $this->app->bind(IUserServiceRepository::class, UserServiceRepository::class);
        $this->app->bind(INotificationRepository::class, NotificationRepository::class);
        $this->app->bind(IVehicleRepository::class, VehicleRepository::class);
        $this->app->bind(IUserVehicleRepository::class, UserVehicleRepository::class);
        $this->app->bind(IBookingRepository::class, BookingRepository::class);
        $this->app->bind(IBookingPaymentRepository::class, BookingPaymentRepository::class);
        $this->app->bind(IServiceCategoryRepository::class, ServiceCategoryRepository::class);
        $this->app->bind(IReferralPriceRepository::class, ReferralPriceRepository::class);
        $this->app->bind(IPackageRepository::class, PackageRepository::class);
        $this->app->bind(IPackageMaintenanceRepository::class,PackageMaintenanceRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
