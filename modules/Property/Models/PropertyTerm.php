<?php
namespace Modules\Property\Models;

use App\BaseModel;

class PropertyTerm extends BaseModel
{
    protected $table = 'bc_property_term';
    protected $fillable = [
        'term_id',
        'target_id'
    ];
}
