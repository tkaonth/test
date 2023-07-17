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
        Schema::create('car_accessorys', function (Blueprint $table) {
            $table->id();
            $table->string('car_id')->nullable();
            $table->string('car_acc_type')->nullable();
            $table->string('acc_brand')->nullable();
            $table->string('acc_model')->nullable();
            $table->string('acc_code')->nullable();
            $table->string('acc_price')->nullable()->default(0);
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
        Schema::dropIfExists('car_accessorys');
    }
};
