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
<<<<<<< HEAD
=======
            $table->unsignedBigInteger('section_id');
>>>>>>> 43b24d0671115a2e9a8971c7326d52895dbcb217
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->text('roles_name')->nullable();
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
