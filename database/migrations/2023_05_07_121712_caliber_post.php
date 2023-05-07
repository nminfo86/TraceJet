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
        Schema::create('caliber_post', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->integer("id", true)->unique();
            $table->unsignedBigInteger('caliber_id');
            $table->unsignedBigInteger('post_id');

            $table->foreign('caliber_id')->references('id')->on('calibers')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('post_id')->references('id')->on('posts')->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caliber_post');
    }
};
