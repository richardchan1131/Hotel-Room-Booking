<?php


namespace Modules\Tracking\Models;


use Illuminate\Database\Eloquent\Model;

class TrackingUser extends Model
{

    protected $table = 'tracking_users';

    protected $fillable = [
        'user_id',
        'device_id',
        'client_ip',
        'is_robot',
    ];
}
