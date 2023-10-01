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
        // Schema::table('part_serial_number', function (Blueprint $table) {
        //     $table->dropPrimary();
        //     $table->foreign('serial_number_id')->references('id')->on('serial_numbers')->restrictOnDelete()->cascadeOnUpdate();
        //     $table->foreign('part_id')->references('id')->on('parts')->restrictOnDelete()->cascadeOnUpdate();
        //     $table->primary(['serial_number_id', 'part_id']);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('part_serial_number', function (Blueprint $table) {
        //     $table->dropForeign('test_user_part_id_foreign');
        //     $table->dropForeign('test_user_serial_number_id_foreign');
        //     $table->dropPrimary(['serial_number_id', 'part_id']);
        // });
    }
};
