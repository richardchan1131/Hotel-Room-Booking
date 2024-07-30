<?php

namespace Custom\Hotel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OlteanuHotelChild extends Model
{
    use HasFactory;

    // $table->unsignedBigInteger('bravo_hotel_room_id');
    //         $table->foreign('bravo_hotel_room_id')->references('id')->on('bravo_hotel_rooms')->onDelete('cascade');
    //         $table->float('price');
    //         $table->integer('minimum_age');
    //         $table->integer('maximum_age');
    //         $table->softDeletes();
    protected $fillable = [
        'bravo_hotel_room_id',
        'price',
        'maximum_age',
        'minimum_age'
    ];
}
