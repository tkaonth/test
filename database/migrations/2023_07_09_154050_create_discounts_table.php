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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('cus_id')->nullable();
            $table->string('ins_type')->nullable();
            $table->string('ins_id')->nullable();
            $table->string('sub_ins_id')->nullable();
            $table->string('date')->nullable();
            $table->string('bill_number')->nullable();
            $table->string('discount')->nullable();
            $table->string('balance')->nullable();
            $table->string('uploadbill')->nullable();
            $table->string('create_by')->nullable();
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
        Schema::dropIfExists('discounts');
    }
};
