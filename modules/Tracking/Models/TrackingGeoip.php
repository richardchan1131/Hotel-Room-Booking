<?php


namespace Modules\Tracking\Models;


use Illuminate\Database\Eloquent\Model;

class TrackingGeoip extends Model
{

    protected $table = 'tracking_geoip';

    protected $fillable = [
        'lat',
        'lng',
        'country_code',
        'country_name',
        'city',
        'region',
        'postal_code',
        'area_code',
        'continent_code'
    ];

}
