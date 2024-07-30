<?php
namespace Themes\GoTrip\Location\Models;

use App\BaseModel;

class Location extends \Modules\Location\Models\Location
{
    protected $casts         = [
        'trip_ideas' => 'array',
        'general_info' => 'array',
    ];

    protected $translation_class = LocationTranslation::class;
}
