<?php
namespace Modules\Booking\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceTranslation extends Service
{
    use SoftDeletes;
    protected $table = 'bravo_service_translations';
    protected $fillable  = [
        'title',
        'address',
        'content',
        'locale',
    ];
    protected $slugField = false;
}