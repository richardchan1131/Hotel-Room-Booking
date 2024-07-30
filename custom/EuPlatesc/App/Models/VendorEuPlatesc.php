<?php
namespace Custom\EuPlatesc\App\Models;
// Custom\EuPlatesc\App\Http\Controllers
use App\BaseModel;

class VendorEuPlatesc extends BaseModel
{
    protected $table = 'vendor_euplatesc';

    protected $fillable = [
        'vendor_id',
        'key',
        'mid',
        'active'
    ];
}