<?php


namespace Modules\Tracking\Models;


use Illuminate\Database\Eloquent\Model;

class TrackingEvent extends Model
{
    protected $table = 'tracking_events';
    protected $fillable = ['name'];
}
