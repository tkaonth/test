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
        Schema::create('bokers', function (Blueprint $table) {
            $table->id();
            $table->string('cus_id');
            $table->string('name');
            $table->string('boker_money')->default(0);
            $table->string('tel');
            $table->string('address');
            $table->string('group');
            $table->string('village');
            $table->string('city');
            $table->string('district');
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
        Schema::dropIfExists('bokers');
    }
};
