<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("purchase_id");
            $table->unsignedBigInteger("supplier_id");
            $table->string("payment_method");
            $table->double("payment_amount", 2)->default(0);
            $table->string("bank")->nullable();             //applicable for bank
            $table->string("check")->nullable();            //applicable for bank
            $table->string("transaction_no")->nullable();   //applicable for bank, mobile banking
            $table->unsignedBigInteger("given_by");
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
        Schema::dropIfExists('purchase_payments');
    }
}
