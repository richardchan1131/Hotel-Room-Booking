<?php
namespace Modules\Booking\Models;

use App\BaseModel;
use App\User;

class EnquiryReply extends BaseModel
{
    protected $table      = 'bravo_enquiry_replies';

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class,'parent_id');
    }
    public function author(){
        return $this->belongsTo(User::class,'user_id')->withDefault();
    }
}
