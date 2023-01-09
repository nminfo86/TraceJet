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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id');
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->boolean('status')->default(1);
            $table->text('roles_name');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();


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
        Schema::dropIfExists('users');
    }
};