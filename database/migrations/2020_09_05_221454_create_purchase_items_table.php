<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("purchase_id");
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("supplier_id");
            $table->double("quantity")->default(0);
            $table->double("price");
            $table->double("total");    //quantity*price
            $table->double("tax")->default(0);  //percentage
            $table->double("discount")->default(0);  //percentage
            $table->double("payable")->default(0);
            $table->string("status");   //returned, processed, cancelled
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
        Schema::dropIfExists('purchase_items');
    }
}
