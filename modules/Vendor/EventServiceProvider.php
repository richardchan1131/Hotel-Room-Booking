<?php

namespace Modules\Vendor;

use Modules\Vendor\Events\VendorTeamRequestCreatedEvent;
use Modules\Vendor\Listeners\VendorTeamRequestCreatedListener;

class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{
    protected $listen = [
        VendorTeamRequestCreatedEvent::class => [
            VendorTeamRequestCreatedListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
