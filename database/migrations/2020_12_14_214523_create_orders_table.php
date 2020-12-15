<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sale_id')->nullable();  //created when order is confirmed
            $table->unsignedBigInteger("customer_id");
            $table->double("total", null, 2)->default(0);
            $table->string("status"); //returned, processed, cancelled
            $table->text("note")->nullable();
            $table->double('paid', null, 2)->default(0);  //if any amount is paid during creation.
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
        Schema::dropIfExists('orders');
    }
}
