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
        Schema::create('other_bills', function (Blueprint $table) {
            $table->id();
            $table->string('cus_id')->nullable();
            $table->string('cus_code')->nullable();
            $table->string('cus_name')->nullable();
            $table->string('cus_address')->nullable();
            $table->string('cus_tel')->nullable();
            $table->string('bill_number')->unique();
            $table->string('bill_type');
            $table->string('bill_status');
            $table->string('note')->nullable();
            $table->string('payment_type');
            $table->string('bill_date');
            $table->string('payment_branch');
            $table->string('payment');
            $table->string('fine');
            $table->string('tracking');
            $table->string('totalpay');
            $table->string('balance');
            $table->string('create_by');
            $table->string('create_at');
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
        Schema::dropIfExists('other_bills');
    }
};
