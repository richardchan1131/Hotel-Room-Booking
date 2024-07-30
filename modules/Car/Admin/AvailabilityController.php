<?php
namespace Modules\Car\Admin;

use Modules\Booking\Models\Booking;
use Modules\Car\Models\Car;
use Modules\Car\Models\CarDate;

class AvailabilityController extends \Modules\Car\Controllers\AvailabilityController
{
    protected $carClass;
    protected $carDateClass;
    protected $bookingClass;
    protected $indexView = 'Car::admin.availability';

    public function __construct(Car $carClass, CarDate $carDateClass, Booking $bookingClass)
    {
        $this->setActiveMenu(route('car.admin.index'));
        $this->middleware('dashboard');
        $this->carClass = $carClass;
        $this->carDateClass = $carDateClass;
        $this->bookingClass = $bookingClass;
    }

}
