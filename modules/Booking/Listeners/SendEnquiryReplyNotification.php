<?php

namespace Modules\Booking\Listeners;

use App\User;
use Illuminate\Support\Facades\Mail;
use Modules\Booking\Emails\EnquiryReplySendEmail;
use Modules\Booking\Events\EnquiryReplyCreated;

class SendEnquiryReplyNotification
{

    /**
     * Handle the event.
     *
     * @param EnquiryReplyCreated $event
     * @return void
     */
    public function handle(EnquiryReplyCreated $event)
    {
        $reply = $event->_reply;
        $enquiry = $event->_enquiry;

        Mail::to($enquiry->email)->send(new EnquiryReplySendEmail($reply,$enquiry));
    }
}
