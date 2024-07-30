<?php
namespace Modules\Booking\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Enquiry;
use Modules\Booking\Models\EnquiryReply;

class EnquiryReplySendEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $enquiry;
    public $enquiry_reply;
    public $content;
    protected $email_type;


    public function __construct(EnquiryReply $enquiryReply,Enquiry $enquiry)
    {
        $this->enquiry = $enquiry;
        $this->enquiry_reply = $enquiryReply;
    }

    public function build()
    {
        $subject = __('You got reply from :name',['name'=>$this->enquiry_reply->author->display_name ?? '']);
        return $this->subject($subject)->view('Booking::emails.enquiry_reply')->with([
            'enquiry' => $this->enquiry,
            'enquiry_reply' => $this->enquiry_reply,
            'to'=>$this->email_type
        ]);
    }
}
