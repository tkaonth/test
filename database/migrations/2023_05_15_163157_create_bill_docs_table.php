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
        Schema::create('bill_docs', function (Blueprint $table) {
            $table->id();
            $table->string('cus_id');
            $table->string('bill_id');
            $table->string('bill_name');
            $table->string('bill_filename');
            $table->string('bill_doc_path');
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
        Schema::dropIfExists('bill_docs');
    }
};
