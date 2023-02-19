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
        // TODO:nassim
        Schema::create('ofs', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('caliber_id');
            $table->string('of_number')->unique();
            $table->string('of_name')->unique()->nullable();
            $table->string('of_code', 50)->unique()->nullable();
            $table->string('status')->default('new');
            $table->integer('quantity');
            $table->integer('new_quantity');
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->timestamps();


            // $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('caliber_id')->references('id')->on('calibers')->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ofs');
    }
};