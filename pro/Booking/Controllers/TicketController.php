<?php

namespace Pro\Booking\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\BookingPassenger;
use Modules\FrontendController;

class TicketController extends FrontendController
{
    private Booking $booking;
    private BookingPassenger $ticket;

    public function __construct(Booking $booking, BookingPassenger $ticket)
    {
        parent::__construct();
        $this->booking = $booking;
        $this->ticket = $ticket;
    }

    public function index($code = '')
    {
        $booking = $this->booking->where('code', $code)->first();
        $user_id = Auth::id();

        $allowStatus = [$this->booking::COMPLETED, $this->booking::PAID];

        if (empty($booking) or !in_array($booking->status, $allowStatus)) {
            return redirect('user/booking-history');
        }
        if ($booking->customer_id != $user_id and $booking->vendor_id != $user_id) {
            return redirect('user/booking-history');
        }
        if ($ticket_id = request('ticket_id')) {
            $tickets = $booking->passengers()->where('id', $ticket_id)->get();
        } else {
            $tickets = $booking->passengers;
        }
        $data = [
            'booking'    => $booking,
            'service'    => $booking->service,
            'page_title' => __("Tickets"),
            'tickets'    => $tickets
        ];
        return view('Booking::frontend.user.ticket.tickets', $data);
    }

    /**
     * Vendor only scan QR Code
     *
     * @param $code
     */
    public function scan($booking_id, $ticket_id)
    {
        if (!request('code')) {
            return redirect(route('vendor.dashboard'))->with('error', 'Code empty');
        }
        if (!Hash::check($booking_id . '.' . $ticket_id, request('code'))) {
            return redirect(route('vendor.dashboard'))->with('error', 'Code not found');
        }

        $booking = $this->booking::find($booking_id);
        $ticket = $this->ticket::query()->where([
            'booking_id' => $booking_id,
            'id'         => $ticket_id
        ])->first();

        $user_id = Auth::id();

        $allowStatus = [Booking::COMPLETED, Booking::PAID];

        if (empty($booking) or !in_array($booking->status, $allowStatus)) {
            return redirect(route('vendor.dashboard'))->with('error', __('Booking status not valid'));
        }
        if (empty($ticket)) {
            return redirect(route('vendor.dashboard'))->with('error', __('Ticket not found'));
        }
        if ($booking->vendor_id != $user_id) {
            return redirect(route('vendor.dashboard'))->with('error', __('This ticket does not belong to your events'));
        }
        if ($ticket->is_scanned) {
            return redirect(route('vendor.dashboard'))->with('error', __('Ticket already scanned at :time', display_datetime($ticket->scanned_at)));
        }

        $ticket->is_scanned = 1;
        $ticket->scanned_at = Carbon::now();
        $ticket->scanned_by = $user_id;

        $ticket->save();

        return redirect(route('user.booking.ticket', ['code'      => $booking->code,
                                                      'ticket_id' => $ticket->id]))->with('success', __('Ticket scan success'));
    }

}
