<?php

namespace Modules\User\Models;

use App\User;
use Modules\Booking\Models\Payment;

class PlanPayment extends Payment
{

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'object_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
