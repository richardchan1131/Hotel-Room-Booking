<?php

namespace Modules\Booking\Traits;

use Modules\Booking\Models\BookingPassenger;

trait HasPassenger
{

    public function passengers(){
        return $this->hasMany(BookingPassenger::class,'booking_id');
    }
}
