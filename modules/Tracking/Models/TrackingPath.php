<?php


namespace Modules\Tracking\Models;


use Illuminate\Database\Eloquent\Model;

class TrackingPath extends Model
{

    protected $table = 'tracking_paths';
    protected $fillable = ['path'];
}
