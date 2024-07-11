<?php

namespace IntersoftNotification;

use Illuminate\Support\ServiceProvider;

class CouponServiceProvider extends ServiceProvider
{
  public function boot()
  {
    // $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
  }
}
