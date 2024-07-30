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
        Schema::table('bravo_booking_passengers',function(Blueprint $blueprint){
            if(!Schema::hasColumn('bravo_booking_passengers','meta')){
                $blueprint->text('meta')->nullable();
            }
            if(!Schema::hasColumn('bravo_booking_passengers','is_scanned')){
                $blueprint->tinyInteger('is_scanned')->nullable()->default(0);
                $blueprint->bigInteger('scanned_by')->nullable();
                $blueprint->timestamp('scanned_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
