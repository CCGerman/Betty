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
        Schema::create('invoice_series', function (Blueprint $table) {
            $table->string('serie', 10)->primary();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('last_number')->default(0);
            $table->boolean('simplified');
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
        Schema::dropIfExists('invoice_series');
    }
};
