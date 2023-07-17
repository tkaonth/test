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
        Schema::create('cus_sts', function (Blueprint $table) {
            $table->id();
            $table->string('keyword')->unique();
            $table->string('thai');
            $table->string('lao');
            $table->string('eng');
            $table->string('create by');
            $table->string('create at');
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
        Schema::dropIfExists('cus_sts');
    }
};
