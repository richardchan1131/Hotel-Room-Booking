<?php

namespace Modules\Vendor\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

/**
 * @property $vendor_team
 */
class VendorTeamRequestCreatedEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $member;
    protected $vendor;

    public function __construct($member, $vendor,$vendor_team)
    {
        $this->member = $member;
        $this->vendor = $vendor;
        $this->vendor_team = $vendor_team;
    }

    public function build()
    {
        $subject = __('Request join team');
        return $this->subject($subject)->view('Vendor::emails.vendor-team-request-create', ['content' => $this->body()]);
    }

    public function body()
    {
        $body = '
            <h1>Hello! ' . $this->member->display_name . '</h1>
            <p>You are invited to join the team :<a href="#" target="_blank">' . $this->vendor->display_name . '</a></p>
            <p style="text-align: center">' . $this->button() . '</p>
            <p>Regards,<br>' . setting_item('site_title') . '</p>';
        return $body;
    }

    public function button()
    {
        $link = URL::temporarySignedRoute('team-accept',now()->addMinutes(60),['vendor_team'=>$this->vendor_team->id]);
        $button = '<a style="border-radius: 3px;
                color: #fff;
                display: inline-block;
                text-decoration: none;
                background-color: #3490dc;
                border-top: 10px solid #3490dc;
                border-right: 18px solid #3490dc;
                border-bottom: 10px solid #3490dc;
                border-left: 18px solid #3490dc;" href="' . $link . '">Accept</a>';
        return $button;
    }

}

