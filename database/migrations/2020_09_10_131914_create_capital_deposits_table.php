<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapitalDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capital_deposits', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable();
            $table->double("payment_amount");
            $table->string("payment_method");
            $table->string("bank")->nullable();
            $table->string("check_no")->nullable();
            $table->string("transaction_no")->nullable();
            $table->unsignedBigInteger("deposited_by");
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
        Schema::dropIfExists('capital_deposits');
    }
}
