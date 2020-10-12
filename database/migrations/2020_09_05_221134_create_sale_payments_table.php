<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("sale_id");
            $table->unsignedBigInteger("customer_id");
            $table->string("payment_method");
            $table->double("payment_amount", 2)->default(0);
            $table->string("bank")->nullable();             //applicable for bank
            $table->string("check")->nullable();            //applicable for bank
            $table->string("transaction_no")->nullable();   //applicable for bank, mobile banking
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
        Schema::dropIfExists('sale_payments');
    }
}
