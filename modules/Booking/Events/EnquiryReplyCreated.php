<?php

namespace Modules\Booking\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Booking\Models\Enquiry;
use Modules\Booking\Models\EnquiryReply;

class EnquiryReplyCreated
{
    use SerializesModels, Dispatchable;

    public $_reply;

    public $_enquiry;

    public function __construct(EnquiryReply $reply, Enquiry $enquiry)
    {

        $this->_enquiry = $enquiry;
        $this->_reply = $reply;
    }

}
