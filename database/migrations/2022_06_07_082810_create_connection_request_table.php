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
        Schema::create('connection_request', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger($column = 'user_id');
            $table->unsignedBigInteger($column = 'suggestion_id');
            $table->string($column = 'status');
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
        Schema::dropIfExists('connection_request');
    }
};
