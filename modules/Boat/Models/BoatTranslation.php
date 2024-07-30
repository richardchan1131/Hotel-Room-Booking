<?php

namespace Modules\Boat\Models;

use App\BaseModel;

class BoatTranslation extends Boat
{
    protected $table = 'bravo_boat_translations';

    protected $fillable = [
        'title',
        'content',
        'faqs',
        'specs',
        'address',
        'cancel_policy',
        'terms_information',
    ];

    protected $slugField     = false;
    protected $seo_type = 'boat_translation';

    protected $cleanFields = [
        'content'
    ];
    protected $casts = [
        'faqs'    => 'array',
        'specs'   => 'array',
        'include' => 'array',
        'exclude' => 'array',
    ];

    public function getSeoType(){
        return $this->seo_type;
    }
    public function getRecordRoot(){
        return $this->belongsTo(Boat::class,'origin_id');
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
