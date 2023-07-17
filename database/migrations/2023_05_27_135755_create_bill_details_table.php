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
        Schema::create('bill_details', function (Blueprint $table) {
            $table->id();
            $table->string('cus_id');
            $table->string('bill_id');
            $table->string('bill_number');
            $table->string('bill_status');
            $table->string('ins_id');
            $table->string('subins_id')->nullable();
            $table->string('list_type');
            $table->string('list_number');
            $table->string('list_name');
            $table->string('list_payments');
            $table->string('list_fine');
            $table->string('list_tracking');
            $table->string('list_balance');
            $table->string('approve_st')->nullable();
            $table->string('approve_by')->nullable();
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
        Schema::dropIfExists('bill_details');
    }
};
