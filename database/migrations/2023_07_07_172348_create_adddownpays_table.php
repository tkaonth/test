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
        Schema::create('adddownpays', function (Blueprint $table) {
            $table->id();
            $table->string('cus_id')->nullable();
            $table->string('number')->nullable();
            $table->string('date')->nullable();
            $table->string('bill_id')->nullable();
            $table->string('bill_number')->nullable();
            $table->string('payment')->nullable();
            $table->string('uploadfile')->nullable();
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
        Schema::dropIfExists('adddownpays');
    }
};
