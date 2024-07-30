<?php

namespace Modules\Vendor\Listeners;

use Modules\Vendor\Emails\VendorTeamRequestCreatedEmail;
use Modules\Vendor\Events\VendorTeamRequestCreatedEvent;

class VendorTeamRequestCreatedListener
{
    public function __construct()
    {
    }

    public function handle(VendorTeamRequestCreatedEvent $event)
    {
        $vendor_team = $event->vendor_team;
        $member = $vendor_team->member;
        \Mail::to($member->email)->send(new VendorTeamRequestCreatedEmail($member,$vendor_team->vendor,$vendor_team));

    }
}
