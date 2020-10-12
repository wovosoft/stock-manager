<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_funds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->double("payment_amount", 2);
            $table->string("type");         //deposit,withdrawn
            $table->string("message")->nullable();
            $table->unsignedBigInteger("purchase_id")->nullable();  //applicable if withdrawn for any sale
            $table->string("payment_method");
            $table->date("date");
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
        Schema::dropIfExists('supplier_funds');
    }
}
