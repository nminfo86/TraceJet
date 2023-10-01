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
        //     $Procedure_of_code = 'DROP PROCEDURE IF EXISTS `packaged_status`;
        //     CREATE  PROCEDURE `packaged_status` (IN `of_id` INT)
        //     SELECT
        //     COUNT(DISTINCT box_id) as filled_boxes,
        //     COUNT(serial_numbers.id) as packaged_products,
        //     of_number,
        //     ofs.status,
        //     ofs.created_at,
        //     boxes.status as box_status,
        //     box_quantity,
        //     caliber_name,
        //     serial_number,
        //     product_name,
        //     SUBSTRING_INDEX(boxes.box_qr, "-", -1) as box_number,
        //     ofs.quantity as quantity
        //   from
        //     serial_numbers
        //     JOIN ofs on serial_numbers.of_id = ofs.id
        //     JOIN calibers on ofs.id = calibers.id
        //     JOIN products on calibers.product_id = products.id
        //     JOIN boxes on serial_numbers.box_id = boxes.id
        //   WHERE
        //     serial_numbers.of_id=of_id';
        //     DB::unprepared($Procedure_of_code);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('packaged_status');
    }
};
