<?php

namespace Modules\Vendor\Models;

use App\BaseModel;
use App\User;

class VendorTeam extends BaseModel
{

   const STATUS_PUBLISH = 'publish';
   const STATUS_PENDING = 'pending';

   protected $table = 'vendor_team';

   protected $casts = [
       'permissions'=>'array'
   ];

   public function vendor(){
       return $this->belongsTo(User::class,'vendor_id');
   }
   public function member(){
       return $this->belongsTo(User::class,'member_id');
   }
}
