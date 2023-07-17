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
        Schema::create('billsystems', function (Blueprint $table) {
            $table->id();
            $table->string('cus_id');
            $table->string('bill_number')->unique();
            $table->string('bill_type');
            $table->string('bill_date');
            $table->string('payment_branch');
            $table->string('payment_type');
            $table->string('bill_upload');
            $table->string('bill_status');
            $table->string('note')->nullable();
            $table->string('create_by');
            $table->string('create_at');
            $table->string('approve_st')->nullable();
            $table->string('approve_by')->nullable();
            $table->string('update_by')->nullable();
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
        Schema::dropIfExists('billsystems');
    }
};
