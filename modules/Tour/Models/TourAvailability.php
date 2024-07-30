<?php

namespace Modules\Tour\Models;

use App\BaseModel;

class TourAvailability extends BaseModel
{
    protected $table = 'bravo_tour_availability';

    protected $fillable = [
        'tour_id',
        'date',
        'type',
        'min',
        'max',
        'create_user',
        'update_user',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];
}
