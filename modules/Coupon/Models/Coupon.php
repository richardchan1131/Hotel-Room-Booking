<?php
namespace Modules\Coupon\Models;
use App\BaseModel;
use App\User;
use Illuminate\Support\Facades\Auth;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Service;

class Coupon extends BaseModel
{
    protected $table = 'bravo_coupons';
    protected $casts = [
        'services'      => 'array',
        'only_for_user'      => 'array',
    ];

    protected $bookingClass;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->bookingClass = Booking::class;
    }

    public function applyCoupon($booking,$action = 'add'){
        // Validate Coupon
        $res = $this->applyCouponValidate($booking,$action);
        if ($res !== true)
            return $res;
        switch ($action){
            case"add":
                $this->add($booking);
                break;
            case"remove":
                $this->remove($booking);
                break;
        }
        $booking->reloadCalculateTotalBooking();
        return [
            'status' =>  1,
            'message' => __("Coupon code is applied successfully!")
        ];
    }

    public function applyCouponValidate($booking,$action){
        if($action == 'remove'){
            return true;
        }
        $check_coupon = CouponBookings::where('coupon_code',$this->code)->where("booking_id",$booking->id)->count();
        if(!empty($check_coupon)){
            return [
                'status'=>0,
                'message'=> __("Coupon code is added already!")
            ];
        }
        if(!empty($end_date = $this->end_date)){
            $today = strtotime("today");
            if(  strtotime($end_date) < $today){
                return [
                    'status'=>0,
                    'message'=> __("This coupon code has expired!")
                ];
            }
        }
        if(!empty($min_total = $this->min_total) and $booking->total_before_discount < $min_total){
            return [
                'status'=>0,
                'message'=> __("The order has not reached the minimum value of :amount to apply the coupon code!",['amount'=>format_money($min_total)])
            ];
        }
        if(!empty($max_total = $this->max_total) and $booking->total_before_discount > $max_total){
            return [
                'status'=>0,
                'message'=> __("This order has exceeded the maximum value of :amount to apply coupon code! ",['amount'=>format_money($max_total)])
            ];
        }
        if(!empty($this->services)){
            $check = false;
            $service_booking_object_id = $booking->object_id;
            $service_booking_object_model = $booking->object_model;
            foreach ($this->couponServices as $item){
                if($item->object_id == $service_booking_object_id and $item->object_model == $service_booking_object_model){
                    $check = true;
                }
            }
            if(!$check){
                return [
                    'status'=>0,
                    'message'=> __("Coupon code is not applied to this product!")
                ];
            }
        }
        if(!empty($this->only_for_user)){
            if(empty($user_id = Auth::id())){
                return [
                    'status'=>0,
                    'message'=> __("You need to log in to use the coupon code!")
                ];
            }
            if(!in_array($user_id,$this->only_for_user)){
                return [
                    'status'=>0,
                    'message'=> __("Coupon code is not applied to your account!")
                ];
            }
        }
        if(!empty($quantity_limit = $this->quantity_limit)){
            $count = CouponBookings::where('coupon_code',$this->code)->whereNotIn('booking_status',['draft','unpaid','cancelled'])->count();
            if($quantity_limit <= $count){
                return [
                    'status'=>0,
                    'message'=> __("This coupon code has been used up!")
                ];
            }
        }
        if(!empty($limit_per_user = $this->limit_per_user)){
            if(empty($user_id = Auth::id())){
                return [
                    'status'=>0,
                    'message'=> __("You need to log in to use the coupon code!")
                ];
            }
            $count = CouponBookings::where('coupon_code',$this->code)->where("create_user",$user_id)->whereNotIn('booking_status',['draft','unpaid','cancelled'])->count();
            if($limit_per_user <= $count){
                return [
                    'status'=>0,
                    'message'=> __("This coupon code has been used up!")
                ];
            }
        }
        return true;
    }

    public function remove($booking){
        $couponBooking = CouponBookings::where('coupon_code',$this->code)->where('booking_id',$booking->id)->first();
        if(!empty($couponBooking)){
            $couponBooking->delete();
        }
    }

    public function add($booking)
    {
        //for Type Fixed
        $coupon_amount = $this->amount;
        //for Type Percent
        if($this->discount_type == 'percent'){
            $coupon_amount =  $booking->total_before_discount / 100 * $this->amount;
        }
        $couponBooking = new CouponBookings();
        $couponBooking->fill([
            'booking_id' => $booking->id,
            'booking_status' => $booking->status,
            'object_id' => $booking->object_id,
            'object_model' => $booking->object_model,
            'coupon_code' => $this->code,
            'coupon_amount' => $coupon_amount,
            'coupon_data' => $this->toArray(),
        ]);
        $couponBooking->save();
    }

    public function couponServices(){
        return $this->hasMany( CouponServices::class, 'coupon_id');
    }
    /**
     * Using for select2
     * @return array
     */
    public function getServicesToArray(){
        $data = [];
        if(!empty($this->services)){
            $services = Service::selectRaw('id,object_id,object_model,title')->whereIn('id',$this->services)->get();
            foreach ($services as $item){
                $data[] = [
                    'id'   => $item->id,
                    'text' => strtoupper($item->object_model) . " (#{$item->object_id}): {$item->title}"
                ];
            }
        }
        return $data;
    }
    /**
     * Using for select2
     * @return array
     */
    public function getUsersToArray(){
        $data = [];
        if(!empty($this->only_for_user)){
            $users = User::where('status','publish')->whereIn('id',$this->only_for_user)->get();
            foreach ($users as $item){
                $data[] = [
                    'id'   => $item->id,
                    'text' => "(#{$item->id}): {$item->getDisplayName()}"
                ];
            }
        }
        return $data;
    }
}
