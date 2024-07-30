<?php
namespace Modules\Booking\Models;

use App\BaseModel;
use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Component\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;
use Modules\Booking\Emails\NewBookingEmail;
use Modules\Booking\Emails\StatusUpdatedEmail;
use Modules\Booking\Events\BookingUpdatedEvent;
use Modules\Hotel\Models\HotelRoomBooking;
use Modules\Space\Models\Space;
use Modules\Tour\Models\Tour;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Models\Wallet\Transaction;

class BookingTimeSlots extends BaseModel
{
    protected $table      = 'bravo_booking_time_slots';
}
