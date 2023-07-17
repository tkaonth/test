<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_manages', function (Blueprint $table) {
            $table->id();
            $table->string('cus_id')->nullable();
            $table->string('car_model');
            $table->string('car_number')->unique();
            $table->string('engine_number');
            $table->string('car_st');
            $table->string('update_date');
            $table->string('car_price');
            $table->string('total_acc_price');
            $table->string('car_expenses');
            $table->string('sum_price');
            $table->string('create_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_manages');
    }
};
