<?php
namespace Modules\Property\Models;

use App\BaseModel;

class PropertyCategoryTranslation extends BaseModel
{
    protected $table = 'bc_property_category_translations';
    protected $fillable = [
        'name',
        'content',
    ];
    protected $cleanFields = [
        'content'
    ];
}
