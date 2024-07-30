<?php
namespace Modules\Flight\Models;

use App\BaseModel;

class FlightTerm extends BaseModel
{
    protected $table = 'bravo_flight_term';
    protected $fillable = [
        'term_id',
        'target_id'
    ];
}