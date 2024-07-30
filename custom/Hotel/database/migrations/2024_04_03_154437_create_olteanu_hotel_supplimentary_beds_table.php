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
        Schema::create('olteanu_hotel_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bravo_hotel_room_id');
            $table->foreign('bravo_hotel_room_id')->references('id')->on('bravo_hotel_rooms')->onDelete('cascade');
            $table->tinyInteger('sofa')->nullabe();
            $table->tinyInteger('single_bed')->nullabe();
            $table->tinyInteger('double_bed')->nullabe();
            $table->float('additional_bed_price')->nullable();
            $table->boolean('additional_bed_active')->default(true);
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
        Schema::dropIfExists('olteanu_hotel_rooms');
    }
};
