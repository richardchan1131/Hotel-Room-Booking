<?php


namespace Modules\Booking\Models;


use App\BaseModel;

class PaymentMeta extends BaseModel
{
    protected $table = 'bravo_booking_payment_meta';
    protected $fillable = [
        'name' ,
        'val'  ,
        'payment_id',
    ];
}
