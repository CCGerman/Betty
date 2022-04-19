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
        Schema::create('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('number');
            $table->string('serie', 10);
            $table->foreign('serie')->references('serie')->on('invoice_series');
            $table->primary(['number', 'serie']);
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->date('date')->default(now());
            $table->double('total_amount')->nullable();
            $table->double('balance')->nullable();
            $table->unsignedBigInteger('deleted_on')->nullable();
            $table->foreign('deleted_on')->references('number')->on('invoices');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
