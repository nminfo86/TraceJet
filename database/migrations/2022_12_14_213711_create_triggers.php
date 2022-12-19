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
                        CREATE TRIGGER AFTER_UPDATE_CREATE_FIRST_MOVEMENT AFTER UPDATE ON serial_numbers
                        FOR EACH ROW BEGIN
                            IF (NEW.valid = 1 AND (select count(*) from movements WHERE serial_number_id=new.id)<1) THEN
                                insert into `movements` (`serial_number_id`,`previous_post_id`,`result`,`created_at`) values (new.id,1 , 'ok',CURRENT_TIMESTAMP);

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