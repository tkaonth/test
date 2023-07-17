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
        Schema::create('customer_docs', function (Blueprint $table) {
            $table->id();
            $table->string('cus_id');
            $table->string('doc_name');
            $table->string('doc_status');
            $table->string('update_at');
            $table->string('update_by');
            $table->string('doc_path');
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
        Schema::dropIfExists('customer_docs');
    }
};
