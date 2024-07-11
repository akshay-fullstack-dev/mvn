<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentServiceAdditionaFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_payments', function (Blueprint $table) {
            $table->double('basic_service_charge_received_by_admin')->after('via_wallet')->default(0);
            $table->double('basic_service_charge_received_by_vendor')->after('basic_service_charge_received_by_admin')->default(0);
            $table->double('delivery_charge_received_by_admin')->after('basic_service_charge_received_by_vendor')->default(0);
            $table->double('delivery_charge_received_by_vendor')->after('delivery_charge_received_by_admin')->default(0);
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
            $table->dropColumn('admin_service_charge');
            $table->dropColumn('vendor_service_charge');
            $table->dropColumn('admin_delivery_charge');
            $table->dropColumn('vendor_delivery_charge');
        });
    }
}
