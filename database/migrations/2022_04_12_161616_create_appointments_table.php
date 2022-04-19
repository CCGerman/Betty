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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('time_start');
            $table->dateTime('time_end');
            $table->unsignedBigInteger('worker_id');
            $table->unsignedBigInteger('treatment_id');
            $table->unsignedBigInteger('client_id');
            $table->foreign('worker_id')->references('id')->on('workers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('treatment_id')->references('id')->on('treatments')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('appointments');
    }
};
