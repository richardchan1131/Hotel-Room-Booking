<?php


namespace Modules\Tracking\Models;


use Illuminate\Database\Eloquent\Model;

class TrackingDevice extends Model
{

    protected $table = 'tracking_devices';

    protected $fillable = [
        'model',
        'platform',
        'platform_version',
        'is_mobile',
        'browser',
        'browser_version',
    ];

}
