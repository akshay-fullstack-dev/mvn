<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDeliveryChargeTableDefaultValueNullToZero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_payments', function (Blueprint $table) {
            $table->decimal('delivery_charges', 10, 4)->default(0)->change();
            $table->decimal('basic_service_charge', 10, 4)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.

     * @return void
     */
    public function down()
    {
        Schema::table('booking_payments', function (Blueprint $table) {
            //
        });
    }
}
