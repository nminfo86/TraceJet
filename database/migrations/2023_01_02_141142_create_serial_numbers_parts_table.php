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
        Schema::create('serial_numbers_parts', function (Blueprint $table) {
            // $table->increments('id')->unsigned();
            $table->unsignedBigInteger('serial_number_id');
            $table->unsignedBigInteger('part_id');
            $table->primary(['serial_number_id', 'part_id']);

            $table->foreign('serial_number_id')->references('id')->on('serial_numbers')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('part_id')->references('id')->on('parts')->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serial_numbers_parts');
    }
};