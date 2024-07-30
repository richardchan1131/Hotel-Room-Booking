<?php
namespace Modules\Space\Admin;

use Modules\Booking\Models\Booking;
use Modules\Space\Models\Space;
use Modules\Space\Models\SpaceDate;

class AvailabilityController extends \Modules\Space\Controllers\AvailabilityController
{
    protected $indexView = 'Space::admin.availability';

    public function __construct(Space $spaceClass,SpaceDate $spaceDateClass,Booking $bookingClass)
    {
        parent::__construct($spaceClass,$spaceDateClass,$bookingClass);
        $this->setActiveMenu(route('space.admin.index'));
        $this->middleware('dashboard');
    }

}
