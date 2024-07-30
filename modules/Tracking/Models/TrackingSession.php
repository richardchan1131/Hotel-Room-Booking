<?php


namespace Modules\Tracking\Models;


use Illuminate\Database\Eloquent\Model;

class TrackingSession extends Model
{

    protected $table = 'tracking_sessions';

    protected $fillable = [
        'user_id',
        'device_id',
        'client_ip',
        'is_robot',
    ];
}
