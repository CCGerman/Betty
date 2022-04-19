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
        Schema::create('invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->float('discount');

            //Billable
            $table->unsignedBigInteger('billable_id');
            $table->foreign('billable_id')->references('id')->on('billables');

            //Invoice
            $table->unsignedBigInteger('number');
            $table->string('serie', 10);
            $table->foreign('number')->references('number')->on('invoices');
            $table->foreign('serie')->references('serie')->on('invoices');

            $table->double('unity_amount')->nullable();
            $table->double('total_amount')->nullable();
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
        Schema::dropIfExists('invoice_lines');
    }
};
