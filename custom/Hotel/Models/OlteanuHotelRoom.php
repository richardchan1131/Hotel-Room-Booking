<?php

namespace Custom\Hotel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OlteanuHotelRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'bravo_hotel_room_id',
        'sofa',
        'single_bed',
        'double_bed',
        'additional_bed_active',
        'additional_bed_price',
        'breakfast_active',
        'breakfast_price',
        'demipension_active',
        'demipension_price',
        'allinclusive_active',
        'allinclusive_price',
        'freecancelation_active',
        'freecancelation_price'
    ];
}
