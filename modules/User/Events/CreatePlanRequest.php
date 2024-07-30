<?php

namespace Modules\User\Events;

use Illuminate\Queue\SerializesModels;

class CreatePlanRequest
{
    use SerializesModels;
    public $user;
    public $payment;

    public function __construct($user)
    {
        $this->user = $user;
    }

}
