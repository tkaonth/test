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
        Schema::create('ins', function (Blueprint $table) {
            $table->id();
            $table->string('cus_id');
            $table->string('cus_code');
            $table->string('ins_number');
            $table->string('appoint_date');
            $table->string('appoint_pay');
            $table->string('principle')->nullable()->default("-");
            $table->string('interest')->nullable()->default("-");
            $table->string('payment')->default(0);
            $table->string('payment_date')->nullable();
            $table->string('bill_number')->nullable();
            $table->string('status');
            $table->string('fine')->nullable()->default(0);
            $table->string('tracking_fee')->nullable()->default(0);
            $table->string('balance')->default(0);
            $table->string('uploadbill')->nullable();
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
        Schema::dropIfExists('ins');
    }
};
