<?php

use App\Enum\DocumentEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('document_name', 255);
            $table->string('document_number', 255)->nullable();
            $table->string('front_image', 1000);
            $table->string('back_image', 1000)->nullable();
            $table->tinyInteger('document_type')->comment(DocumentEnum::DRIVING_LICENCE . ":- FOR DRIVING LICENCE" . DocumentEnum::HIGH_SCHOOL_DIPLOMA . ":- HIGH SCHOOL DIPLOMA " .
                DocumentEnum::OTHER_DOCUMENT_TYPE . ":- OTHER DOCUMENT TYPE");
            $table->tinyInteger('document_status')->comment(DocumentEnum::NOT_APPROVED . ":- NOT APPROVED" . DocumentEnum::APPROVED . ":- APPROVED " .
                DocumentEnum::UNDER_REVIEW . ":- UNDER REVIEW");
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
        Schema::dropIfExists('user_documents');
    }
}
