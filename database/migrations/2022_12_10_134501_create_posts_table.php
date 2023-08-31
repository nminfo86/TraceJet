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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('posts_type_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('printer_id')->nullable();
            $table->string('code', 6);
            $table->string('post_name')->unique();
            $table->integer('previous_post_id')->nullable();
            $table->ipAddress()->unique()->nullable();

            $table->string('color')->default('primary');

            $table->foreign('posts_type_id')->references('id')->on('posts_types')->restrictOnDelete()->cascadeOnUpdate();

            $table->foreign('printer_id')->references('id')->on('printers')->restrictOnDelete()->cascadeOnUpdate();

            $table->foreign('section_id')->references('id')->on('sections')->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
