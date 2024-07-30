<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RatePricing extends Model
{


    protected $table = 'bravo_rate_pricing';

    protected $fillable = [
        'pricing_cat_id',
        'rate_id',
        'price',
        'is_tier',
        'tier_min',
        'tier_max',
        'schedule_id',
    ];
}
