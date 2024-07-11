<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAppVersionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_versions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('app_package_id');
            $table->boolean('force_update')->default(false);
            $table->string('message', 1000);
            $table->double('version', 15, 5);
            $table->string('code', 255);
            $table->tinyInteger('platform');
            $table->timestamps();
            // $table->foreign('app_package_id')->references('id')->on('app_packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_versions');
    }
}
