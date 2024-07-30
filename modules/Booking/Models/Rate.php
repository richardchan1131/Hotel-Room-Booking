<?php

namespace Modules\Booking\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends BaseModel
{
    use SoftDeletes;

    protected $table = 'bravo_rates';

    protected $fillable = [
        'name',
        'description',
        'object_id',
        'object_model',
        'is_per_person',
        'is_all_pricing_category',
        'start_time_ids',
        'min_passengers',
        'max_passengers',
        'tier_pricing_enable',
        'tier_pricing',
    ];
}
