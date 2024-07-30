<?php

namespace Modules\Booking;

use Modules\Booking\Events\EnquiryReplyCreated;
use Modules\Booking\Listeners\SendEnquiryReplyNotification;

class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{
    protected $listen = [
        EnquiryReplyCreated::class=>[
            SendEnquiryReplyNotification::class
        ]
    ];

}
