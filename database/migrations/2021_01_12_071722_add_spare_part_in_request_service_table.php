<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSparePartInRequestServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_requested_services', function (Blueprint $table) {
            $table->string('spare_parts', 3000)->after('approx_time')->nullable();
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
            $table->dropColumn('spare_parts');
        });
    }
}
