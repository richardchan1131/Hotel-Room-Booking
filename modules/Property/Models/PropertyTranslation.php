<?php

namespace Modules\Property\Models;

use App\BaseModel;

class PropertyTranslation extends Property
{
    protected $table = 'bc_property_translations';

    protected $fillable = [
        'title',
        'content',
        'faqs',
        'address',
        'extra_price'
    ];

    protected $slugField     = false;
    protected $seo_type = 'property_translation';

    protected $cleanFields = [
        'content'
    ];
    protected $casts = [
        'faqs'  => 'array',
        'extra_price'  => 'array',
    ];

    public function getSeoType(){
        return $this->seo_type;
    }
	public static function boot() {
		parent::boot();
		static::saving(function($table)  {
			unset($table->extra_price);
			unset($table->price);
			unset($table->sale_price);
		});
	}
}
