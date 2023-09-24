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
        Schema::create('serial_numbers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('of_id');
            $table->unsignedBigInteger('box_id')->nullable()->default(NULL);
            $table->string('serial_number');
            $table->string('qr')->unique()->nullable();
            $table->boolean('valid')->default(0);
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();


            $table->unique(['of_id', 'serial_number']);
            $table->foreign('of_id')->references('id')->on('ofs')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('box_id')->references('id')->on('boxes')->restrictOnDelete()->cascadeOnUpdate();

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
        Schema::dropIfExists('serial_numbers');
    }
};
