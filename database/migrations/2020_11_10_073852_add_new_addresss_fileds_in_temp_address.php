<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewAddresssFiledsInTempAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_temp_addresses', function (Blueprint $table) {
            $table->string('house_no', 255)->after('type')->nullable();
            $table->string('state', 255)->after('city')->nullable();
            $table->string('zip_code', 255)->after('state')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_temp_addresses', function (Blueprint $table) {
            $table->dropColumn('house_no');
            $table->dropColumn('state');
            $table->dropColumn('zip_code');
        });
    }
}
