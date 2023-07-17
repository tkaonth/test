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
        Schema::create('cus_manages', function (Blueprint $table) {
            $table->id();
            $table->string('cus_type');
            $table->string('cus_st');
            $table->string('cus_code')->unique();
            $table->string('cus_name');
            $table->string('cus_idcard');
            $table->string('cus_tel');
            $table->string('cus_age')->nullable();
            $table->string('cus_bd')->nullable();
            $table->string('cus_address');
            $table->string('cus_group');
            $table->string('cus_village');
            $table->string('cus_city');
            $table->string('cus_district');
            $table->string('cus_branch');
            $table->string('car_id');
            $table->string('deposit')->default(0);
            $table->string('bill_num_deposit')->nullable();
            $table->string('deposit_date')->nullable();
            $table->string('down_pay_deli')->default(0);
            $table->string('bill_num_down_pay_deli')->nullable();
            $table->string('ins_LJT')->nullable();
            $table->string('ins_money')->nullable();
            $table->string('promotion')->nullable();
            $table->string('ins_style');
            $table->string('ins_style_type');
            $table->string('total_price');
            $table->string('discount')->nullable()->default(0);
            $table->string('net_price');
            $table->string('down_pay')->nullable()->default(0);
            $table->string('total_pay_deli')->default(0);
            $table->string('total_pay_deli_date')->nullable();
            $table->string('remaining');
            $table->string('interest_rate');
            $table->string('ins_long')->default(0);
            $table->string('ins_long_type')->nullable();
            $table->string('divid_ins')->default(0);
            $table->string('note')->nullable();
            $table->string('deli_date');
            $table->string('stock');
            $table->string('start_ins');
            $table->string('upload_deposit')->nullable();
            $table->string('upload_deli')->nullable();
            $table->string('create_by');
            $table->string('approve_st');
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
        Schema::dropIfExists('cus_manages');
    }
};
