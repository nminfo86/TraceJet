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
        /* -------------------------------------------------------------------------- */
        /*                     serial_numbers table  triggers                    */
        /* -------------------------------------------------------------------------- */

        $AFTER_UPDATE = "DROP TRIGGER IF EXISTS AFTER_UPDATE_CREATE_FIRST_MOVEMENT;
                        CREATE TRIGGER CREATE_FIRST_MOVEMENT AFTER UPDATE ON serial_numbers
                        FOR EACH ROW BEGIN
                        IF (NEW.valid = 1 AND (SELECT COUNT(*) FROM movements WHERE serial_number_id=new.id)<1) THEN
                                insert into `movements` (`serial_number_id`,`movement_post_id`,`result`,`created_at`,`created_by`) values (new.id,1, 'OK',CURRENT_TIMESTAMP,new.created_by);
                        END IF;
                        IF ((SELECT COUNT(*) FROM `movements` JOIN serial_numbers ON movements.serial_number_id=serial_numbers.id
                            WHERE serial_numbers.of_id=new.of_id) = 1) THEN
                                UPDATE ofs SET status='inProd',release_date=CURRENT_TIMESTAMP WHERE id=new.of_id;
                        END IF;
                        END";
        DB::unprepared($AFTER_UPDATE);
    }

    // /**
    //  * Reverse the migrations.
    //  *
    //  * @return void
    //  */
    // public function down()
    // {
    //     Schema::dropIfExists('triggers');
    // }
};
