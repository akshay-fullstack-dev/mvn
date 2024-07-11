<?php

use App\Enum\BookingEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('coupon_id')->nullable();
            $table->tinyInteger('amount_paid')->comment('yes:-' . BookingEnum::BooingAmountPaid . ' no:-' . BookingEnum::BooingAmountNotPaid)->default(BookingEnum::BooingAmountNotPaid);
            $table->double('total_amount', 10, 4);
            $table->double('total_amount_paid', 10, 4);
            $table->double('delivery_charges', 10, 4);
            $table->double('basic_service_charge', 10, 4);
            $table->double('via_wallet', 10, 4);
            $table->double('discount_amount', 10, 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_payments');
    }
}
