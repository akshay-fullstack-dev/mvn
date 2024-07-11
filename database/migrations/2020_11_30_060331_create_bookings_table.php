<?php

use App\Enum\BookingEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id();
            $table->string('order_id', 150);
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('service_id')->index();
            $table->unsignedBigInteger('address_id')->index();
            $table->unsignedBigInteger('payment_id')->index();
            $table->unsignedBigInteger('package_id')->index()->nullable();
            $table->unsignedBigInteger('vehicle_id')->index();
            $table->timestamp('booking_start_time')->nullable();
            $table->timestamp('booking_end_time')->nullable();
            $table->tinyInteger('booking_status')->default(BookingEnum::BookingConfirmed);
            $table->tinyInteger('booking_type')->default(BookingEnum::NormalBooking);
            $table->string('addition_info', 1000)->nullable();
            $table->timestamps();

            // // add the foreign keys
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            // $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            // $table->foreign('payment_id')->references('id')->on('booking_payments')->onDelete('cascade');
            // $table->foreign('address_id')->references('id')->on('user_addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
