<?php
namespace Modules\Boat\Admin;

use Modules\Boat\Models\Boat;
use Modules\Boat\Models\BoatDate;
use Modules\Booking\Models\Booking;

class AvailabilityController extends \Modules\Boat\Controllers\AvailabilityController
{
    protected $boatClass;
    protected $boatDateClass;
    protected $bookingClass;
    protected $indexView = 'Boat::admin.availability';

    public function __construct(Boat $boatClass, BoatDate $boatDateClass, Booking $bookingClass)
    {
        $this->setActiveMenu(route('boat.admin.index'));
        $this->middleware('dashboard');
        $this->bookingClass = $bookingClass;
        $this->boatClass = $boatClass;
        $this->boatDateClass = $boatDateClass;
    }

}
