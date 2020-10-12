<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('district')->nullable();
            $table->string('thana')->nullable();
            $table->string('post_office')->nullable();
            $table->string('village')->nullable();
            $table->boolean("is_active")->default(false);
            $table->date("joining_date");
            $table->date("leaving_date")->nullable();
            $table->string("position")->nullable();
            $table->string("photo")->nullable();
            $table->double('salary', 2)->default(0);
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
        Schema::dropIfExists('employees');
    }
}
