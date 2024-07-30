<?php


namespace Modules\Tracking\Models;


use Illuminate\Database\Eloquent\Model;

class TrackingUtm extends Model
{

    protected $table = 'tracking_utms';

    protected $fillable = [
        'utm_campaign',
        'utm_source',
        'utm_medium',
        'utm_content',
        'utm_term',
    ];

}
