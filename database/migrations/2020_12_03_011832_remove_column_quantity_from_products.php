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
    }
}
