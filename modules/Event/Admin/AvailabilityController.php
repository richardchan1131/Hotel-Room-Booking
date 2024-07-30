<?php
namespace Modules\Event\Admin;

use Modules\Booking\Models\Booking;
use Modules\Event\Models\Event;
use Modules\Event\Models\EventDate;

class AvailabilityController extends \Modules\Event\Controllers\AvailabilityController
{
    protected $eventClass;
    protected $eventDateClass;
    protected $bookingClass;
    protected $indexView = 'Event::admin.availability';

    public function __construct(Event $eventClass, EventDate $eventDateClass,Booking $bookingClass)
    {
        $this->setActiveMenu(route('event.admin.index'));
        $this->middleware('dashboard');
        $this->eventDateClass = $eventDateClass;
        $this->bookingClass = $bookingClass;
        $this->eventClass = $eventClass;
    }

}
