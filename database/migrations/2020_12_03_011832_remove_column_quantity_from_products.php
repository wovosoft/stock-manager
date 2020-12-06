<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnQuantityFromProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
        Schema::table('sale_returns', function (Blueprint $table) {
            $table->dropColumn('sale_id');
            $table->dropColumn('sale_item_id');
        });
        Schema::table('purchase_returns', function (Blueprint $table) {
            $table->dropColumn('purchase_id');
            $table->dropColumn('purchase_item_id');
        });
        //because now sales are allowed to be modified. This columns is added to check if it is modified or not.
        Schema::table('sales', function (Blueprint $table) {
            $table->boolean('is_modified')->default(false);
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->boolean('is_modified')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->addColumn('double', 'quantity');
        });
        Schema::table('sale_returns', function (Blueprint $table) {
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('sale_item_id');
        });
        Schema::table('purchase_returns', function (Blueprint $table) {
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('purchase_item_id');
        });
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('is_modified');
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('is_modified');
        });
    }
}
