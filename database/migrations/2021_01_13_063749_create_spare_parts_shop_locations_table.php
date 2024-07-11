<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSparePartsShopLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_parts_shop_locations', function (Blueprint $table) {
            $table->id();
            $table->string('shop_name', 255);
            $table->string('additional_shop_information', 1000);
            $table->string('country', 255)->nullable();
            $table->string('formatted_address', 500)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('postal_code', 100)->nullable();
            $table->double('lat', 15, 6)->nullable();
            $table->double('long', 15, 6)->nullable();
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
        Schema::dropIfExists('spare_parts_shop_locations');
    }
}
