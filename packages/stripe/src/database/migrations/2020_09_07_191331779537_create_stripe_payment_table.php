<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripePaymentTable extends Migration
{
    public function up()
    {
        Schema::create('stripe_payment_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('payment_intent_id');
            $table->string('charge_id');
            $table->string('user_stripe_id');
            $table->string('currency_code');
            $table->string('card_id');
            $table->double('stripe_charge');
            $table->double('paid_amount');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');;
        });
    }

    public function down()
    {
        Schema::dropIfExists('stripe_payment_records');
    }
}
