<?php

use App\Enum\BookingEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangesInBookingPaymenttable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_payments', function (Blueprint $table) {
            $table->tinyInteger('is_refunded')->after('discount_amount')->default(BookingEnum::PaymentNotRefunded)->comment('1-> payment refund back to user, 0-> payment not refunded');
            $table->tinyInteger('payment_settled')->after('is_refunded')->comment('1->settled, 0 -> payment not settled')->default(BookingEnum::PaymentNotRefunded);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_payments', function (Blueprint $table) {
            
        });
    }
}
