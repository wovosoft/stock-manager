<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms', function (Blueprint $table) {
            $table->id();
            $table->string("provider")->nullable(); //MiMSMS
            $table->string("sms_id")->nullable();   //sms id returned by provider.
            $table->string("type")->default("text");
            $table->string("sender")->nullable();   //sms sender number
            $table->text("contacts")->nullable();   //list of contacts
            $table->text("message")->nullable();    //message
            $table->string("delivery")->nullable(); //delivery status
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms');
    }
}
