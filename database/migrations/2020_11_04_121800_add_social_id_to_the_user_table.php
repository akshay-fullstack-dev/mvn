<?php

use App\Enum\UserEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialIdToTheUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('social_id', 255)->nullable()->after('email');
            $table->tinyInteger('login_type')->after('social_id')->default(UserEnum::NORMAL_LOGIN);
            $table->string('email', 150)->nullable()->change();
            $table->string('phone_number', 25)->nullable()->change();
            $table->string('country_iso_code', 10)->nullable()->change();
            $table->string('country_code', 10)->nullable()->change();
            $table->string('password', 500)->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('social_id');
            $table->dropColumn('login_type');
        });
    }
}
