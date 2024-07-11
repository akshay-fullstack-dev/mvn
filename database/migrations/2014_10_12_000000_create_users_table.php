	<?php

	//use App\Enum\UserEnum;

use App\Enum\UserEnum;
use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	class CreateUsersTable extends Migration
	{
	    /**
	     * Run the migrations.
	     *
	     * @return void
	     */
	    public function up()
	    {
	        Schema::create('users', function (Blueprint $table) {
	            $table->id();
	            $table->string('first_name', 100);
	            $table->string('last_name', 100)->nullable();
	            $table->string('email', 100);
	            $table->timestamp('email_verified_at')->nullable();
	            $table->string('phone_number', 25);
	            $table->string('country_iso_code', 10);
	            $table->boolean('is_blocked')->comment('0 no 1 yes')->default(0);
	            $table->boolean('account_status')->comment(UserEnum::not_approved . 'not approved ' . UserEnum::user_verified . '  verified ' . UserEnum::verification_progress . 'under review' . UserEnum::no_action . 'under review')->default(0);
	            $table->string('country_code', 10);
	            $table->rememberToken();
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
	        Schema::dropIfExists('users');
	    }
	}
