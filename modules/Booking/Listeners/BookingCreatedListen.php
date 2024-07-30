<?php

    namespace Modules\Booking\Listeners;

    use App\Notifications\AdminChannelServices;
    use App\Notifications\PrivateChannelServices;
    use App\User;
    use Illuminate\Support\Facades\Auth;
    use Modules\Booking\Events\BookingCreatedEvent;

    class BookingCreatedListen
    {
        public function handle(BookingCreatedEvent $event)
        {
            $booking = $event->booking;
            $booking->sendNewBookingEmails();

            //case guest checkout
            if(!Auth::id()){
                $name = 'Guests';
                $avatar = '';
            }else{
                $name = Auth::user()->display_name;
                $avatar = Auth::user()->avatar_url;
            }

            $data = [
                'id'      => $booking->id,
                'event'   => 'BookingCreatedEvent',
                'to'      => 'admin',
                'name'    => $name,
                'avatar'  => $avatar,
                'link'    => route('report.admin.booking'),
                'type'    => $booking->object_model,
                'message' => __(':name has created new Booking', ['name' => $name])
            ];

            $vendor = $booking->vendor()->where('status', 'publish')->first();
            //to Admin
            if(!Auth::id()){
                // case guest checkout use vendor object to push notify
                if($vendor) {
                    $vendor->notify(new AdminChannelServices($data));
                }
            }else{
                Auth::user()->notify(new AdminChannelServices($data));
            }

            //to Vendor
            if (!empty($vendor) and !$vendor->hasPermission('dashboard_access')) {
                $data['link'] = route('vendor.bookingReport');
                $data['to'] = 'vendor';
                $vendor->notify(new PrivateChannelServices($data));
            }
        }
    }
