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
        Schema::create('car_status_logs', function (Blueprint $table) {
            $table->id();
            $table->string('car_id');
            $table->string('status');
            $table->string('expenses')->nullable()->default(0);
            $table->string('description')->nullable();
            $table->string('update_at');
            $table->string('update_by');
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
        Schema::dropIfExists('car_status_logs');
    }
};
