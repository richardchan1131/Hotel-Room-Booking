<?php
    namespace Modules\Booking\Listeners;
    use App\Notifications\AdminChannelServices;
    use App\Notifications\PrivateChannelServices;
    use App\User;
    use Illuminate\Support\Facades\Auth;
    use Modules\Booking\Events\BookingUpdatedEvent;

    class BookingUpdateListen
    {
        public function handle(BookingUpdatedEvent $event)
        {
            $booking = $event->booking;
            $booking->sendStatusUpdatedEmails();

            //case guest checkout
            if(!Auth::id()){
                $name = 'Guests';
                $avatar = '';
            }else{
                $name = Auth::user()->display_name;
                $avatar = Auth::user()->avatar_url;
            }

            $data = [
                'event'=>'BookingUpdatedEvent',
                'to'=>'admin',
                'id' =>  $booking->id,
                'name'    => $name,
                'avatar'  => $avatar,
                'link' => route('report.admin.booking'),
                'type' => $booking->object_model,
                'message' => __(':name has changed to :status', ['name' => $booking->service->title, 'status' => $booking->status])
            ];

            // notify vendor
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

            if($vendor){
                $data['to']='vendor';
                $data['link'] = route('vendor.bookingReport');
                $vendor->notify(new PrivateChannelServices($data));
            }
            //Always to Customer
            $customer = User::where('id',$booking->customer_id)->where('status', 'publish')->first();

            if($customer){
                $data['to']='customer';
                $data['link'] = route('user.booking_history');
                $customer->notify(new PrivateChannelServices($data));
            }
        }
    }
