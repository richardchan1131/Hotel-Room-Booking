<?php
namespace Modules\Agency\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class BravoContactObject extends BaseModel
{
    use SoftDeletes;
    protected $table = 'bc_contact_object';
    protected $fillable = [
        'name',
        'email',
        'message',
        'phone',
        'object_id',
        'object_model',
        'vendor_id'
    ];

//    protected $cleanFields = ['message'];
}
