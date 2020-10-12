<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_funds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->double("payment_amount", 2);
            $table->string("type");         //deposit,withdrawn
            $table->string("message")->nullable();
            $table->unsignedBigInteger("sale_id")->nullable();  //applicable if withdrawn for any sale
            $table->string("payment_method");
            $table->date("date");
            $table->unsignedBigInteger("taken_by");
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
        Schema::dropIfExists('customer_funds');
    }
}
