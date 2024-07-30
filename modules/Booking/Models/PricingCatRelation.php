<?php

namespace Modules\Booking\Models;

use App\BaseModel;

class PricingCatRelation extends BaseModel
{
    protected $table = 'bravo_pricing_cat_relation';
    protected $fillable = [
        'object_id',
        'object_model',
        'pricing_cat_id',
        'is_default',
    ];
}
