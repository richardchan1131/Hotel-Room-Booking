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
            $table->integer('sofa')->nullabe();
            $table->integer('single_bed')->nullabe();
            $table->integer('double_bed')->nullabe();
            $table->float('additional_bed_price')->nullable();
            $table->boolean('additional_bed_active')->default(false);
            $table->boolean('breakfast_active')->default(false);
            $table->float('breakfast_price')->nullable();
            $table->boolean('allinclusive_active')->default(false);
            $table->float('allinclusive_price')->nullable();
            $table->boolean('freecancelation_active')->default(false);
            $table->float('freecancelation_price')->nullable();
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
