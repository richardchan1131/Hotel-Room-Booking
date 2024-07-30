<?php

namespace Modules\Booking\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceTime extends BaseModel
{

    protected $table = 'bravo_service_time';

    protected $fillable = [
        'object_id',
        'object_model',
        'label',
        'time',
        'duration',
        'create_user',
        'update_user',
    ];

    protected $casts = [
        'time' => 'datetime',
    ];
}
