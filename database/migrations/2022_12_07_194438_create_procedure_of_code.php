<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $Procedure_of_code = 'DROP PROCEDURE IF EXISTS `generate_of_code`;
        CREATE  PROCEDURE `generate_of_code` (IN `of_id` INT)
            SELECT CONCAT_WS("",s.section_code, c.caliber_code,p.product_code,ofs.of_number,YEAR(now())) AS of_code
            FROM `ofs`
            JOIN calibers c on ofs.caliber_id=c.id
            JOIN products p on c.product_id=p.id
            JOIN sections s ON p.section_id=s.id
            where ofs.id=of_id';
        // DB::unprepared($Procedure_of_code);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procedure_of_code');
    }
};
