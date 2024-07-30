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

        $tableAddAuthorId = [
            'bravo_hotels',
            'bravo_tours',
            'bravo_events',
            'bravo_spaces',
            'bravo_cars',
            'bravo_boats',
            'bravo_flight',
            'bravo_airline',
            'bravo_airport',
            'bravo_flight_seat',
            'bravo_seat_type',
        ];
        foreach ($tableAddAuthorId as $tbName){
            Schema::table($tbName,function(Blueprint $blueprint) use ($tbName){
                if(!Schema::hasColumn($tbName,'author_id')){
                    $blueprint->bigInteger('author_id')->nullable();
                }
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
