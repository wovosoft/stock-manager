<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("employee_id");
            $table->unsignedBigInteger("year");
            $table->unsignedBigInteger("month");
            $table->date("date");
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
        Schema::dropIfExists('employee_salaries');
    }
}
