<?php
namespace Themes\GoTrip\Location\Models;

use App\BaseModel;

class LocationTranslation extends \Modules\Location\Models\LocationTranslation
{
    protected $fillable = ['name', 'content','trip_ideas','general_info'];
    protected $casts         = [
        'trip_ideas' => 'array',
        'general_info' => 'array',
    ];
}
