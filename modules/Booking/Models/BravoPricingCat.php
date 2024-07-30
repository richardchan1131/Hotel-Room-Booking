<?php

namespace Modules\Booking\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class BravoPricingCat extends BaseModel
{
    use SoftDeletes;

    protected $table = 'bravo_pricing_cat';
    protected $fillable = [
        'name',
        'type',
        'age_enabled',
        'min_age',
        'max_age',
        'vendor_id',
        'is_default',
    ];

}
