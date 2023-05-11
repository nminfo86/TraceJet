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
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('serial_number_id');
            $table->unsignedBigInteger('movement_post_id');
            // $table->string('movement_post_name');
            $table->text('result');
            $table->text('observation')->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->timestamps();


            $table->foreign('serial_number_id')->references('id')->on('serial_numbers')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('movement_post_id')->references('id')->on('posts')->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movements');
    }
};
