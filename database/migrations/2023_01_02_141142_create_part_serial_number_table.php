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
        // Schema::create('part_serial_number', function (Blueprint $table) {
        //     $table->integer("id", true)->unique();
        //     $table->unsignedBigInteger('serial_number_id');
        //     $table->unsignedBigInteger('part_id');
        //     $table->integer('quantity')->nullable()->default(1);

        //     // $table->foreign('serial_number_id')->references('id')->on('serial_numbers')->restrictOnDelete()->cascadeOnUpdate();
        //     // $table->foreign('part_id')->references('id')->on('parts')->restrictOnDelete()->cascadeOnUpdate();
        //     // $table->dropIndex(['id']);
        //     // $table->dropPrimary();
        //     // $table->primary(['serial_number_id', 'part_id']);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('part_serial_number');
    }
};
