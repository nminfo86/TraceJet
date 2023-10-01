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
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id');
            $table->string("name", 50)->unique();
            $table->ipAddress("ip_address")->unique();
            $table->integer("port")->default(9100);
            $table->string("protocol", 6)->default("ESC");
            $table->string("label_size", 10);


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
        Schema::dropIfExists('printers');
    }
};
