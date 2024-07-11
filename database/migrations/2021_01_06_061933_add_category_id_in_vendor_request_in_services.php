<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdInVendorRequestInServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_requested_services', function (Blueprint $table) {
            $table->unsignedBigInteger('service_category_id')->after('id')->nullable();
            // $table->foreign('service_category_id')->references('id')->on('vendor_requested_services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_requested_services', function (Blueprint $table) {
            $table->dropColumn('service_category_id');
        });
    }
}
