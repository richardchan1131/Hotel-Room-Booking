<?php

namespace Modules\Vendor\Traits;

use App\User;
use Modules\Vendor\Models\VendorTeam;
use Modules\Vendor\Models\VendorTeamRequest;

trait HasMembers
{
    public function vendorTeams(){
        return $this->hasMany(VendorTeam::class,'vendor_id');
    }
    public function members(){
        return $this->belongsToMany(User::class,'vendor_team','vendor_id','member_id');
    }

    public function managers(){
        return $this->belongsToMany(User::class,'vendor_team','member_id','vendor_id');
    }
}
