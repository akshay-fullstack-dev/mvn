<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_name', 255);
            $table->string('coupon_code', 50);
            $table->tinyInteger('coupon_type');
            $table->double('coupon_discount');
            $table->unsignedBigInteger('users_id')->nullable();
            $table->double('coupon_min_amount')->nullable();
            $table->double('coupon_max_amount')->nullable();
            $table->integer('maximum_total_use')->nullable();
            $table->integer('maximum_per_customer_use')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('coupons');
    }
}
