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
        Schema::create('olteanu_hotel_children', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bravo_hotel_room_id');
            $table->foreign('bravo_hotel_room_id')->references('id')->on('bravo_hotel_rooms')->onDelete('cascade');
            $table->float('price')->nullable();
            $table->integer('minimum_age');
            $table->integer('maximum_age');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('olteanu_hotel_children');
    }
};
