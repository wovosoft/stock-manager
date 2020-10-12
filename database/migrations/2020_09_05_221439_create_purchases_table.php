<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("supplier_id");
            $table->double("total", 2)->default(0);
            $table->double("tax", 2)->default(0);           //percentage
            $table->double("discount", 2)->default(0);      //percentage
            $table->double("payable", 2)->default(0);
            $table->double("paid", 2)->default(0);
            $table->double("balance", 2)->default(0);
            $table->date("date");       //default current timestamp
            $table->string("status"); //returned, processed, cancelled
            $table->text("note")->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
