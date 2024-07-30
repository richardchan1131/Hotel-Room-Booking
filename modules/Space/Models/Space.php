<?php

namespace Modules\Space\Models;

use App\BaseModel;
use App\Currency;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Modules\Booking\Models\Bookable;
use Modules\Booking\Models\Booking;
use Modules\Booking\Traits\CapturesService;
use Modules\Core\Models\Attributes;
use Modules\Core\Models\SEO;
use Modules\Core\Models\Terms;
use Modules\Media\Helpers\FileHelper;
use Modules\Review\Models\Review;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Models\UserWishList;
use Modules\Location\Models\Location;

class Space extends Bookable
{
    use Notifiable;
    use SoftDeletes;
    use CapturesService;
    protected $table = 'bravo_spaces';
    public $type = 'space';
    public $checkout_booking_detail_file       = 'Space::frontend/booking/detail';
    public $checkout_booking_detail_modal_file = 'Space::frontend/booking/detail-modal';
    public $set_paid_modal_file                = 'Space::frontend/booking/set-paid-modal';
    public $email_new_booking_file             = 'Space::emails.new_booking_detail';
    public $availabilityClass = SpaceDate::class;
    protected $translation_class = SpaceTranslation::class;

    protected $fillable = [
        'title',
        'content',
        'status',
        'faqs'
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'title';
    protected $seo_type = 'space';

    protected $casts = [
        'faqs'  => 'array',
        'extra_price'  => 'array',
        'service_fee' => 'array',
        'surrounding' => 'array',
    ];
    /**
     * @var Booking
     */
    protected $bookingClass;
    /**
     * @var Review
     */
    protected $reviewClass;

    /**
     * @var SpaceDate
     */
    protected $spaceDateClass;

    /**
     * @var spaceTerm
     */
    protected $spaceTermClass;

    /**
     * @var spaceTerm
     */
    protected $spaceTranslationClass;
    protected $userWishListClass;

    protected $tmp_dates = [];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->bookingClass = Booking::class;
        $this->reviewClass = Review::class;
        $this->spaceDateClass = SpaceDate::class;
        $this->spaceTermClass = SpaceTerm::class;
        $this->spaceTranslationClass = SpaceTranslation::class;
        $this->userWishListClass = UserWishList::class;
    }

    public static function getModelName()
    {
        return __("Space");
    }

    /**
     * Get SEO fop page list
     *
     * @return mixed
     */
    static public function getSeoMetaForPageList()
    {
        $meta['seo_title'] = __("Search for Spaces");
        if (!empty($title = setting_item_with_lang("space_page_list_seo_title",false))) {
            $meta['seo_title'] = $title;
        }else if(!empty($title = setting_item_with_lang("space_page_search_title"))) {
            $meta['seo_title'] = $title;
        }
        $meta['seo_image'] = null;
        if (!empty($title = setting_item("space_page_list_seo_image"))) {
            $meta['seo_image'] = $title;
        }else if(!empty($title = setting_item("space_page_search_banner"))) {
            $meta['seo_image'] = $title;
        }
        $meta['seo_desc'] = setting_item_with_lang("space_page_list_seo_desc");
        $meta['seo_share'] = setting_item_with_lang("space_page_list_seo_share");
        $meta['full_url'] = url()->current();
        return $meta;
    }


    public function terms(){
        return $this->hasMany($this->spaceTermClass, "target_id");
    }

    public function getDetailUrl($include_param = true)
    {
        $param = [];
        if($include_param){
            if(!empty($date =  request()->input('date'))){
                $dates = explode(" - ",$date);
                if(!empty($dates)){
                    $param['start'] = $dates[0] ?? "";
                    $param['end'] = $dates[1] ?? "";
                }
            }
            if(!empty($adults =  request()->input('adults'))){
                $param['adults'] = $adults;
            }
            if(!empty($children =  request()->input('children'))){
                $param['children'] = $children;
            }
        }
        $urlDetail = app_get_locale(false, false, '/') . config('space.space_route_prefix') . "/" . $this->slug;
        if(!empty($param)){
            $urlDetail .= "?".http_build_query($param);
        }
        return url($urlDetail);
    }

    public static function getLinkForPageSearch( $locale = false , $param = [] ){

        return url(app_get_locale(false , false , '/'). config('space.space_route_prefix')."?".http_build_query($param));
    }

    public function getEditUrl()
    {
        return url(route('space.admin.edit',['id'=>$this->id]));
    }

    public function getDiscountPercentAttribute()
    {
        if (    !empty($this->price) and $this->price > 0
            and !empty($this->sale_price) and $this->sale_price > 0
            and $this->price > $this->sale_price
        ) {
            $percent = 100 - ceil($this->sale_price / ($this->price / 100));
            return $percent . "%";
        }
    }

    public function fill(array $attributes)
    {
        if(!empty($attributes)){
            foreach ( $this->fillable as $item ){
                $attributes[$item] = $attributes[$item] ?? null;
            }
        }
        return parent::fill($attributes); // TODO: Change the autogenerated stub
    }

    public function isBookable()
    {
        if ($this->status != 'publish')
            return false;
        return parent::isBookable();
    }

    public function addToCart(Request $request)
    {

        $res = $this->addToCartValidate($request);
        if($res !== true) return $res;

        // Add Booking
        $total_guests = $request->input('adults') + $request->input('children');
        $discount = 0;
        $start_date = new \DateTime($request->input('start_date'));
        $end_date = new \DateTime($request->input('end_date'));
        if($this->getBookingType() == 'by_night'){
            $end_dateNight  = new \DateTime(date("Y-m-d 23:59:59",strtotime($request->input('end_date')." -1day")));
            $duration_in_hour = max(1,ceil(($end_dateNight->getTimestamp() - $start_date->getTimestamp()) / HOUR_IN_SECONDS )  );
        }else{
            $duration_in_hour = max(1,ceil(($end_date->getTimestamp() - $start_date->getTimestamp()) / HOUR_IN_SECONDS ) + 24 );
        }

        $extra_price_input = $request->input('extra_price');
        $extra_price = [];

        $total = $this->getPriceInRanges($request->input('start_date'),$request->input('end_date'));


        if ($this->enable_extra_price and !empty($this->extra_price)) {
            if (!empty($this->extra_price)) {
                foreach ($this->extra_price as $k => $type) {
                    if (isset($extra_price_input[$k]) and !empty($extra_price_input[$k]['enable'])) {
                        $type_total = 0;
                        switch ($type['type']) {
                            case "one_time":
                                $type_total = $type['price'];
                                break;
                            case "per_hour":
                                $type_total = $type['price'] * $duration_in_hour;
                                break;
                            case "per_day":
                                $type_total = $type['price'] * ceil($duration_in_hour / 24);
                                break;
                        }
                        if (!empty($type['per_person'])) {
                            $type_total *= $total_guests;
                        }
                        $type['total'] = $type_total;
                        $total += $type_total;
                        $extra_price[] = $type;
                    }
                }
            }
        }

        //Buyer Fees for Admin
        $total_before_fees = $total;
        $total_buyer_fee = 0;
        if (!empty($list_buyer_fees = setting_item('space_booking_buyer_fees'))) {
            $list_fees = json_decode($list_buyer_fees, true);
            $total_buyer_fee = $this->calculateServiceFees($list_fees , $total_before_fees , $total_guests);
            $total += $total_buyer_fee;
        }

        //Service Fees for Vendor
        $total_service_fee = 0;
        if(!empty($this->enable_service_fee) and !empty($list_service_fee = $this->service_fee)){
            $total_service_fee = $this->calculateServiceFees($list_service_fee , $total_before_fees , $total_guests);
            $total += $total_service_fee;
        }

        if (empty($start_date) or empty($end_date)) {
            return $this->sendError(__("Your selected dates are not valid"));
        }
        $booking = new $this->bookingClass();
        $booking->status = 'draft';
        $booking->object_id = $request->input('service_id');
        $booking->object_model = $request->input('service_type');
        $booking->vendor_id = $this->author_id;
        $booking->customer_id = Auth::id();
        $booking->total = $total;
        $booking->total_guests = $total_guests;
        $booking->start_date = $start_date->format('Y-m-d H:i:s');
        $booking->end_date = $end_date->format('Y-m-d H:i:s');

        $booking->vendor_service_fee_amount = $total_service_fee ?? '';
        $booking->vendor_service_fee = $list_service_fee ?? '';
        $booking->buyer_fees = $list_buyer_fees ?? '';
        $booking->total_before_fees = $total_before_fees;
        $booking->total_before_discount = $total_before_fees;

        $booking->calculateCommission();

        if($this->isDepositEnable())
        {
            $booking_deposit_fomular = $this->getDepositFomular();
            $tmp_price_total = $booking->total;
            if($booking_deposit_fomular == "deposit_and_fee"){
                $tmp_price_total = $booking->total_before_fees;
            }

            switch ($this->getDepositType()){
                case "percent":
                    $booking->deposit = $tmp_price_total * $this->getDepositAmount() / 100;
                    break;
                default:
                    $booking->deposit = $this->getDepositAmount();
                    break;
            }
            if($booking_deposit_fomular == "deposit_and_fee"){
                $booking->deposit = $booking->deposit + $total_buyer_fee + $total_service_fee;
            }
        }

        $check = $booking->save();
        if ($check) {

            $this->bookingClass::clearDraftBookings();

            $booking->addMeta('duration', $this->duration);
            $booking->addMeta('base_price', $this->price);
            $booking->addMeta('sale_price', $this->sale_price);
            $booking->addMeta('guests', $total_guests);
            $booking->addMeta('adults', $request->input('adults'));
            $booking->addMeta('children', $request->input('children'));
            $booking->addMeta('extra_price', $extra_price);
            $booking->addMeta('tmp_dates', $this->tmp_dates);
            $booking->addMeta('booking_type', $this->getBookingType());
            if($this->isDepositEnable())
            {
                $booking->addMeta('deposit_info',[
                    'type'=>$this->getDepositType(),
                    'amount'=>$this->getDepositAmount(),
                    'fomular'=>$this->getDepositFomular(),
                ]);
            }

            return $this->sendSuccess([
                'url' => $booking->getCheckoutUrl(),
                'booking_code' => $booking->code,
            ]);
        }
        return $this->sendError(__("Can not check availability"));
    }

    public function getPriceInRanges($start_date,$end_date){
        $totalPrice = 0;
        $price = ($this->sale_price and $this->sale_price > 0 and  $this->sale_price < $this->price) ? $this->sale_price : $this->price;

        $datesRaw = $this->spaceDateClass::getDatesInRanges($start_date,$end_date,$this->id);
        $dates = [];
        if(!empty($datesRaw))
        {
            foreach ($datesRaw as $date){
                if($date->price != null){
                    $dates[date('Y-m-d',strtotime($date['start_date']))] = $date;
                }
            }
        }

        if(strtotime($start_date) == strtotime($end_date))
        {
            if(empty($dates[date('Y-m-d',strtotime($start_date))]))
            {
                $totalPrice += $price;
            }else{
                $totalPrice += $dates[date('Y-m-d',strtotime($start_date))]->price;
            }
            return $totalPrice;
        }
        if($this->getBookingType() == 'by_day'){
            $period = periodDate($start_date,$end_date);
        }
        if($this->getBookingType() == 'by_night'){
            $period = periodDate($start_date,$end_date,false);
        }
        $newDates = [];
        foreach ($period as $dt){
            $date = $dt->format('Y-m-d');
            if(empty($dates[$date]))
            {
                $totalPrice += $price;
            }else{
                $totalPrice += $dates[$date]->price;
                $newDates[$date] = $dates[$date];
            }
        }
        $this->tmp_dates = $newDates;
        return $totalPrice;
    }

    public function addToCartValidate(Request $request)
    {
        $rules = [
            'adults'     => 'required|integer|min:1',
            'children'     => 'required|integer|min:0',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d'
        ];

        // Validation
        if (!empty($rules)) {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->sendError('', ['errors' => $validator->errors()]);
            }

        }
        $total_guests = $request->input('adults') + $request->input('children');
        if($total_guests > $this->max_guests){
            return $this->sendError(__("Maximum guests is :count",['count'=>$this->max_guests]));
        }
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        if(strtotime($start_date) < strtotime(date('Y-m-d 00:00:00')) or strtotime($start_date) > strtotime($end_date))
        {
            return $this->sendError(__("Your selected dates are not valid"));
        }

        if($this->getBookingType() == 'by_night' and strtotime($start_date) == strtotime($end_date)){
            return $this->sendError(__("Your selected dates are not valid"));
        }

        // Validate Date and Booking
        if(!$this->isAvailableInRanges($start_date,$end_date)){
            return $this->sendError(__("This space is not available at selected dates"));
        }

	    if(!$this->checkBusyDate($start_date,$end_date)){
            return $this->sendError(__("This space is not available at selected dates"));
	    }

        if($this->getBookingType()!='by_night'){
            $numberDays = ( abs(strtotime($end_date) - strtotime($start_date)) / 86400 ) + 1;
            if(!empty($this->min_day_stays) and  $numberDays < $this->min_day_stays){
                return $this->sendError(__("You must to book a minimum of :number days",['number'=>$this->min_day_stays]));
            }
        }else{
            $numberDays = ( abs(strtotime($end_date) - strtotime($start_date)) / 86400 ) ;
            if(!empty($this->min_day_stays) and  $numberDays < $this->min_day_stays){
                return $this->sendError(__("You must to book a minimum of :number nights",['number'=>$this->min_day_stays]));
            }
        }


        if(!empty($this->min_day_before_booking)){
            $minday_before = strtotime("today +".$this->min_day_before_booking." days");
            if(  strtotime($start_date) < $minday_before){
                return $this->sendError(__("You must book the service for :number days in advance",["number"=>$this->min_day_before_booking]));
            }
        }

        return true;
    }

    public function beforeCheckout(Request $request, $booking)
    {
        if(!$this->isAvailableInRanges($booking->start_date,$booking->end_date)){
            return $this->sendError(__("This space is not available at selected dates"));
        }
    }

    public function isAvailableInRanges($start_date,$end_date){

        $days = max(1,floor((strtotime($end_date) - strtotime($start_date)) / DAY_IN_SECONDS));

        if($this->getBookingType() == 'by_night'){
            $end_date  = date("Y-m-d 23:59:59",strtotime($end_date." -1day"));
        }

        if($this->default_state)
        {
            $notAvailableDates = $this->spaceDateClass::query()->where([
                ['start_date','>=',$start_date],
                ['end_date','<=',$end_date],
                ['active','0'],
                ['target_id','=',$this->id],
            ])->count('id');
            if($notAvailableDates) return false;

        }else{
            $availableDates = $this->spaceDateClass::query()->where([
                ['start_date','>=',$start_date],
                ['end_date','<=',$end_date],
                ['active','=',1],
                ['target_id','=',$this->id],
            ])->count('id');
            if($availableDates < $days) return false;
        }

        if($this->getBookingType() == 'by_night'){
            $start_date  = date("Y-m-d 00:00:00",strtotime($start_date." +1day"));
        }
        $bookingInRanges = $this->bookingClass::getAcceptedBookingQuery($this->id,$this->type)->where([
            ['end_date','>=',$start_date],
            ['start_date','<=',$end_date],
        ])->count('id');

        if($bookingInRanges){
            return false;
        }

        return true;
    }

    public function getBookingData()
    {
        if (!empty($start = request()->input('start'))) {
            $start_html = display_date($start);
            $end_html = request()->input('end') ? display_date(request()->input('end')) : "";
            $date_html = $start_html . '<i class="fa fa-long-arrow-right" style="font-size: inherit"></i>' . $end_html;
        }
        $booking_data = [
            'id'              => $this->id,
            'person_types'    => [],
            'max'             => 0,
            'open_hours'      => [],
            'extra_price'     => [],
            'minDate'         => date('m/d/Y'),
            'max_guests'      => $this->max_guests ?? 1,
            'buyer_fees'      => [],
            'start_date'      => request()->input('start') ?? "",
            'start_date_html' => $date_html ?? __('Please select'),
            'end_date'        => request()->input('end') ?? "",
            'deposit'=>$this->isDepositEnable(),
            'deposit_type'=>$this->getDepositType(),
            'deposit_amount'=>$this->getDepositAmount(),
            'deposit_fomular'=>$this->getDepositFomular(),
            'is_form_enquiry_and_book'=> $this->isFormEnquiryAndBook(),
            'enquiry_type'=> $this->getBookingEnquiryType(),
            'booking_type'=> $this->getBookingType(),
        ];
        if(!empty( $adults = request()->input('adults') )){
            $booking_data['adults'] = $adults;
        }
        if(!empty( $children = request()->input('children') )){
            $booking_data['children'] = $children;
        }
        $lang = app()->getLocale();
        if ($this->enable_extra_price) {
            $booking_data['extra_price'] = $this->extra_price;
            if (!empty($booking_data['extra_price'])) {
                foreach ($booking_data['extra_price'] as $k => &$type) {
                    if (!empty($lang) and !empty($type['name_' . $lang])) {
                        $type['name'] = $type['name_' . $lang];
                    }
                    $type['number'] = 0;
                    $type['enable'] = 0;
                    $type['price_html'] = format_money($type['price']);
                    $type['price_type'] = '';
                    switch ($type['type']) {
                        case "per_day":
                            $type['price_type'] .= '/' . __('day');
                            break;
                        case "per_hour":
                            $type['price_type'] .= '/' . __('hour');
                            break;
                    }
                    if (!empty($type['per_person'])) {
                        $type['price_type'] .= '/' . __('guest');
                    }
                }
            }

            $booking_data['extra_price'] = array_values((array)$booking_data['extra_price']);
        }

        $list_fees = setting_item_array('space_booking_buyer_fees');
        if(!empty($list_fees)){
            foreach ($list_fees as $item){
                $item['type_name'] = $item['name_'.app()->getLocale()] ?? $item['name'] ?? '';
                $item['type_desc'] = $item['desc_'.app()->getLocale()] ?? $item['desc'] ?? '';
                $item['price_type'] = '';
                if (!empty($item['per_person']) and $item['per_person'] == 'on') {
                    $item['price_type'] .= '/' . __('guest');
                }
                $booking_data['buyer_fees'][] = $item;
            }
        }
        if(!empty($this->enable_service_fee) and !empty($service_fee = $this->service_fee)){
            foreach ($service_fee as $item) {
                $item['type_name'] = $item['name_' . app()->getLocale()] ?? $item['name'] ?? '';
                $item['type_desc'] = $item['desc_' . app()->getLocale()] ?? $item['desc'] ?? '';
                $item['price_type'] = '';
                if (!empty($item['per_person']) and $item['per_person'] == 'on') {
                    $item['price_type'] .= '/' . __('guest');
                }
                $booking_data['buyer_fees'][] = $item;
            }
        }
        return $booking_data;
    }

    public static function searchForMenu($q = false)
    {
        $query = static::select('id', 'title as name');
        if (strlen($q)) {

            $query->where('title', 'like', "%" . $q . "%");
        }
        $a = $query->orderBy('id', 'desc')->limit(10)->get();
        return $a;
    }

    public static function getMinMaxPrice()
    {
        $model = parent::selectRaw('MIN( CASE WHEN sale_price > 0 THEN sale_price ELSE ( price ) END ) AS min_price ,
                                    MAX( CASE WHEN sale_price > 0 THEN sale_price ELSE ( price ) END ) AS max_price ')->where("status", "publish")->first();
        if (empty($model->min_price) and empty($model->max_price)) {
            return [
                0,
                100
            ];
        }
        return [
            $model->min_price,
            $model->max_price
        ];
    }

    public function getReviewEnable()
    {
        return setting_item("space_enable_review", 0);
    }

    public function getReviewApproved()
    {
        return setting_item("space_review_approved", 0);
    }

    public function review_after_booking(){
        return setting_item("space_enable_review_after_booking", 0);
    }

    public function count_remain_review()
    {
        $status_making_completed_booking = [];
        $options = setting_item("space_allow_review_after_making_completed_booking", false);
        if (!empty($options)) {
            $status_making_completed_booking = json_decode($options);
        }
        $number_review = $this->reviewClass::countReviewByServiceID($this->id, Auth::id(), false, $this->type) ?? 0;
        $number_booking = $this->bookingClass::countBookingByServiceID($this->id, Auth::id(),$status_making_completed_booking) ?? 0;
        $number = $number_booking - $number_review;
        if($number < 0) $number = 0;
        return $number;
    }

    public static function getReviewStats()
    {
        $reviewStats = [];
        if (!empty($list = setting_item("space_review_stats", []))) {
            $list = json_decode($list, true);
            foreach ($list as $item) {
                $reviewStats[] = $item['title'];
            }
        }
        return $reviewStats;
    }

    public function getReviewDataAttribute()
    {
        $list_score = [
            'score_total'  => 0,
            'score_text'   => __("Not rated"),
            'total_review' => 0,
            'rate_score'   => [],
        ];
        $dataTotalReview = $this->reviewClass::selectRaw(" AVG(rate_number) as score_total , COUNT(id) as total_review ")->where('object_id', $this->id)->where('object_model', $this->type)->where("status", "approved")->first();
        if (!empty($dataTotalReview->score_total)) {
            $list_score['score_total'] = number_format($dataTotalReview->score_total, 1);
            $list_score['score_text'] = Review::getDisplayTextScoreByLever(round($list_score['score_total']));
        }
        if (!empty($dataTotalReview->total_review)) {
            $list_score['total_review'] = $dataTotalReview->total_review;
        }
        $list_data_rate = $this->reviewClass::selectRaw('COUNT( CASE WHEN rate_number = 5 THEN rate_number ELSE NULL END ) AS rate_5,
                                                            COUNT( CASE WHEN rate_number = 4 THEN rate_number ELSE NULL END ) AS rate_4,
                                                            COUNT( CASE WHEN rate_number = 3 THEN rate_number ELSE NULL END ) AS rate_3,
                                                            COUNT( CASE WHEN rate_number = 2 THEN rate_number ELSE NULL END ) AS rate_2,
                                                            COUNT( CASE WHEN rate_number = 1 THEN rate_number ELSE NULL END ) AS rate_1 ')->where('object_id', $this->id)->where('object_model', $this->type)->where("status", "approved")->first()->toArray();
        for ($rate = 5; $rate >= 1; $rate--) {
            if (!empty($number = $list_data_rate['rate_' . $rate])) {
                $percent = ($number / $list_score['total_review']) * 100;
            } else {
                $percent = 0;
            }
            $list_score['rate_score'][$rate] = [
                'title'   => $this->reviewClass::getDisplayTextScoreByLever($rate),
                'total'   => $number,
                'percent' => round($percent),
            ];
        }
        return $list_score;
    }

    /**
     * Get Score Review
     *
     * Using for loop space
     */
    public function getScoreReview()
    {
        $space_id = $this->id;
        $list_score = Cache::rememberForever('review_'.$this->type.'_' . $space_id, function () use ($space_id) {
            $dataReview = $this->reviewClass::selectRaw(" AVG(rate_number) as score_total , COUNT(id) as total_review ")->where('object_id', $space_id)->where('object_model', "space")->where("status", "approved")->first();
            $score_total = !empty($dataReview->score_total) ? number_format($dataReview->score_total, 1) : 0;
            return [
                'score_total'  => $score_total,
                'total_review' => !empty($dataReview->total_review) ? $dataReview->total_review : 0,
            ];
        });
        $list_score['review_text'] =  $list_score['score_total'] ? Review::getDisplayTextScoreByLever( round( $list_score['score_total'] )) : __("Not rated");
        return $list_score;
    }

    public function getNumberReviewsInService($status = false)
    {
        return $this->reviewClass::countReviewByServiceID($this->id, false, $status,$this->type) ?? 0;
    }

    public function getReviewList(){
        return $this->reviewClass::select(['id','title','content','rate_number','author_ip','status','created_at','vendor_id','author_id'])->where('object_id', $this->id)->where('object_model', 'space')->where("status", "approved")->orderBy("id", "desc")->with('author')->paginate(setting_item('space_review_number_per_page', 5));
    }

    public function getNumberServiceInLocation($location)
    {
        $number = 0;
        if(!empty($location)) {
            $number = parent::join('bravo_locations', function ($join) use ($location) {
                $join->on('bravo_locations.id', '=', $this->table.'.location_id')->where('bravo_locations._lft', '>=', $location->_lft)->where('bravo_locations._rgt', '<=', $location->_rgt);
            })->where($this->table.".status", "publish")->with(['translation'])->count($this->table.".id");
        }
        if(empty($number)) return false;
        if ($number > 1) {
            return __(":number Spaces", ['number' => $number]);
        }
        return __(":number Space", ['number' => $number]);
    }

    /**
     * @param $from
     * @param $to
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getBookingsInRange($from,$to){

        $query = $this->bookingClass::query();
        $query->whereNotIn('status',['draft']);
        $query->where('start_date','<=',$to)->where('end_date','>=',$from)->take(50);

        $query->where('object_id',$this->id);
        $query->where('object_model',$this->type);

        return $query->orderBy('id','asc')->get();

    }

    public function saveCloneByID($clone_id){
        $old = parent::find($clone_id);
        if(empty($old)) return false;
        $selected_terms = $old->terms->pluck('term_id');
        $old->title = $old->title." - Copy";
        $new = $old->replicate();
        $new->save();
        //Terms
        foreach ($selected_terms as $term_id) {
            $this->spaceTermClass::firstOrCreate([
                'term_id' => $term_id,
                'target_id' => $new->id
            ]);
        }
        //Language
        $langs = $this->spaceTranslationClass::where("origin_id",$old->id)->get();
        if(!empty($langs)){
            foreach ($langs as $lang){
                $langNew = $lang->replicate();
                $langNew->origin_id = $new->id;
                $langNew->save();
                $langSeo = SEO::where('object_id', $lang->id)->where('object_model', $lang->getSeoType()."_".$lang->locale)->first();
                if(!empty($langSeo)){
                    $langSeoNew = $langSeo->replicate();
                    $langSeoNew->object_id = $langNew->id;
                    $langSeoNew->save();
                }
            }
        }
        //SEO
        $metaSeo = SEO::where('object_id', $old->id)->where('object_model', $this->seo_type)->first();
        if(!empty($metaSeo)){
            $metaSeoNew = $metaSeo->replicate();
            $metaSeoNew->object_id = $new->id;
            $metaSeoNew->save();
        }
    }

    public function hasWishList(){
        return $this->hasOne($this->userWishListClass, 'object_id','id')->where('object_model' , $this->type)->where('user_id' , Auth::id() ?? 0);
    }

    public function isWishList()
    {
        if(Auth::id()){
            if(!empty($this->hasWishList) and !empty($this->hasWishList->id)){
                return 'active';
            }
        }
        return '';
    }
    public static function getServiceIconFeatured(){
        return "icofont-building-alt";
    }


    public static function isEnable(){
        return setting_item('space_disable') == false;
    }

    public function isDepositEnable(){
        return (setting_item('space_deposit_enable') and setting_item('space_deposit_amount'));
    }
    public function getDepositAmount(){
        return setting_item('space_deposit_amount');
    }
    public function getDepositType(){
        return setting_item('space_deposit_type');
    }
    public function getDepositFomular(){
        return setting_item('space_deposit_fomular','default');
    }

    public function detailBookingEachDate($booking){
	    $startDate = $booking->start_date;
	    $endDate = $booking->end_date;
        $rowDates= json_decode($booking->getMeta('tmp_dates'));
	    $allDates=[];
	    $service = $booking->service;

        if($this->getBookingType() == 'by_day'){
            $period = periodDate($startDate,$endDate);
        }
        if($this->getBookingType() == 'by_night'){
            $period = periodDate($startDate,$endDate,false);
        }

        foreach ($period as $dt){
            $price = (!empty($service->sale_price) and $service->sale_price > 0 and $service->sale_price < $service->price) ? $service->sale_price : $service->price;

            $startDate = clone $dt;

            $endDate = $dt->modify('+1 day');

            $date['price'] =$price;
            $date['price_html'] = format_money($price);

            $date['from'] = $startDate->getTimestamp();
            $date['from_html'] = $startDate->format(get_date_format());

            $date['to'] = $endDate->getTimestamp();
            $date['to_html'] = $endDate->format(get_date_format());

            $allDates[$startDate->format('Y-m-d')] = $date;
        }

	    if(!empty($rowDates))
	    {
		    foreach ($rowDates as $item => $row)
		    {
			    $startDate = strtotime($item);
                $endDate = strtotime($item." +1 day");
			    $price = $row->price;
			    $date['price'] = $price;
			    $date['price_html'] = format_money($price);
			    $date['from'] = $startDate;
			    $date['from_html'] = date('d/m/Y',$startDate);
			    $date['to'] = $endDate;
			    $date['to_html'] = date('d/m/Y',($endDate));
			    $allDates[date('Y-m-d',$startDate)] = $date;
		    }
	    }
	    return $allDates;
    }

    public static function isEnableEnquiry(){
        if(!empty(setting_item('booking_enquiry_for_space'))){
            return true;
        }
        return false;
    }

    public static function isFormEnquiryAndBook(){
        $check = setting_item('booking_enquiry_for_space');
        if(!empty($check) and setting_item('booking_enquiry_type_space') == "booking_and_enquiry" ){
            return true;
        }
        return false;
    }
    public static function getBookingEnquiryType(){
        $check = setting_item('booking_enquiry_for_space');
        if(!empty($check)){
            if( setting_item('booking_enquiry_type_space') == "only_enquiry" ) {
                return "enquiry";
            }
        }
        return "book";
    }

    /**
     * @param $request
     * [location_id] -> number
     * [s] -> keyword
     * @return array|\Illuminate\Database\Eloquent\Builder
     */
    public function search($request)
    {
        $query = parent::query()->select("bravo_spaces.*");
        $query->where("bravo_spaces.status", "publish");
        if (!empty($location_id = $request['location_id'] ?? '')) {
            $location = Location::query()->where('id', $location_id)->where("status","publish")->first();
            if(!empty($location)){
                $query->join('bravo_locations', function ($join) use ($location) {
                    $join->on('bravo_locations.id', '=', 'bravo_spaces.location_id')
                        ->where('bravo_locations._lft', '>=', $location->_lft)
                        ->where('bravo_locations._rgt', '<=', $location->_rgt);
                });
            }
        }
        if (!empty($price_range = $request['price_range'] ?? '')) {
            $pri_from = Currency::convertPriceToMain(explode(";", $price_range)[0]);
            $pri_to =  Currency::convertPriceToMain(explode(";", $price_range)[1]);
            $raw_sql_min_max = "( (IFNULL(bravo_spaces.sale_price,0) > 0 and bravo_spaces.sale_price >= ? ) OR (IFNULL(bravo_spaces.sale_price,0) <= 0 and bravo_spaces.price >= ? ) )
                            AND ( (IFNULL(bravo_spaces.sale_price,0) > 0 and bravo_spaces.sale_price <= ? ) OR (IFNULL(bravo_spaces.sale_price,0) <= 0 and bravo_spaces.price <= ? ) )";
            $query->WhereRaw($raw_sql_min_max,[$pri_from,$pri_from,$pri_to,$pri_to]);
        }


        if(!empty($request['attrs'])){
            $this->filterAttrs($query,$request['attrs'],'bravo_space_term');
        }

        $review_scores = $request['review_score'] ?? "";
        if (is_array($review_scores)) $review_scores = array_filter($review_scores);
        if (!empty($review_scores) && count($review_scores)) {
            $this->filterReviewScore($query,$review_scores);
        }

        if(!empty( $service_name = $request['service_name'] ?? ""  )){
            if( setting_item('site_enable_multi_lang') && setting_item('site_locale') != app()->getLocale() ){
                $query->leftJoin('bravo_space_translations', function ($join) {
                    $join->on('bravo_spaces.id', '=', 'bravo_space_translations.origin_id');
                });
                $query->where('bravo_space_translations.title', 'LIKE', '%' . $service_name . '%');

            }else{
                $query->where('bravo_spaces.title', 'LIKE', '%' . $service_name . '%');
            }
        }

        if(!empty($lat = $request["map_lat"] ?? "") and !empty($lgn = $request["map_lgn"] ?? "") and !empty($request["map_place"] ?? ""))
        {
            $this->filterLatLng($query,$lat,$lgn);
        }

        if(!empty($request['is_featured']))
        {
            $query->where('bravo_spaces.is_featured',1);
        }
        if (!empty($request['custom_ids']) and !empty( $ids = array_filter($request['custom_ids']) )) {
            $query->whereIn("bravo_spaces.id", $ids);
            $query->orderByRaw('FIELD (id, ' . implode(', ', $ids) . ') ASC');
        }
        $orderby = $request['orderby'] ?? "";
        switch ($orderby){
            case "price_low_high":
                $raw_sql = "CASE WHEN IFNULL( bravo_spaces.sale_price, 0 ) > 0 THEN bravo_spaces.sale_price ELSE bravo_spaces.price END AS tmp_min_price";
                $query->selectRaw($raw_sql);
                $query->orderBy("tmp_min_price", "asc");
                break;
            case "price_high_low":
                $raw_sql = "CASE WHEN IFNULL( bravo_spaces.sale_price, 0 ) > 0 THEN bravo_spaces.sale_price ELSE bravo_spaces.price END AS tmp_min_price";
                $query->selectRaw($raw_sql);
                $query->orderBy("tmp_min_price", "desc");
                break;
            case "rate_high_low":
                $query->orderBy("review_score", "desc");
                break;
            default:
                if (!empty($request['order']) and !empty($request['order_by'])){
                    $query->orderBy("bravo_spaces.".$request['order'], $request['order_by']);
                } else {
                    $query->orderBy("is_featured", "desc");
                    $query->orderBy("id", "desc");
                }
        }

        $query->groupBy("bravo_spaces.id");

        $max_guests = (int)( ($request['adults'] ?? 0) + ($request['children'] ?? 0));
        if($max_guests){
            $query->where('max_guests','>=',$max_guests);
        }


        return $query->with(['location','hasWishList','translation']);
    }

    public function dataForApi($forSingle = false){
        $data = parent::dataForApi($forSingle);
        $data['max_guests'] = $this->max_guests;
        $data['bed'] = $this->bed;
        $data['bathroom'] = $this->bathroom;
        $data['square'] = $this->square;
        if($forSingle){
            $data['review_score'] = $this->getReviewDataAttribute();
            $data['review_stats'] = $this->getReviewStats();
            $data['review_lists'] = $this->getReviewList();
            $data['faqs'] = $this->faqs;
            $data['is_instant'] = $this->is_instant;
            $data['allow_children'] = $this->allow_children;
            $data['allow_infant'] = $this->allow_infant;
            $data['discount_by_days'] = $this->discount_by_days;
            $data['default_state'] = $this->default_state;
            $data['booking_fee'] = setting_item_array('space_booking_buyer_fees');
            if (!empty($location_id = $this->location_id)) {
                $related =  parent::query()->where('location_id', $location_id)->where("status", "publish")->take(4)->whereNotIn('id', [$this->id])->with(['location','translation','hasWishList'])->get();
                $data['related'] = $related->map(function ($related) {
                        return $related->dataForApi();
                    }) ?? null;
            }
            $data['terms'] = Terms::getTermsByIdForAPI($this->terms->pluck('term_id'));
        }else{
            $data['review_score'] = $this->getScoreReview();
        }
        return $data;
    }

    static public function getClassAvailability()
    {
        return "\Modules\Space\Controllers\AvailabilityController";
    }

    static public function getFiltersSearch()
    {
        $min_max_price = self::getMinMaxPrice();
        return [
            [
                "title"    => __("Filter Price"),
                "field"    => "price_range",
                "position" => "1",
                "min_price" => floor ( Currency::convertPrice($min_max_price[0]) ),
                "max_price" => ceil (Currency::convertPrice($min_max_price[1]) ),
            ],
            [
                "title"    => __("Review Score"),
                "field"    => "review_score",
                "position" => "2",
                "min" => "1",
                "max" => "5",
            ],
            [
                "title"    => __("Attributes"),
                "field"    => "terms",
                "position" => "3",
                "data" => Attributes::getAllAttributesForApi("space")
            ]
        ];
    }
    public static function getBookingType(){
        return setting_item('space_booking_type','by_day');
    }

    static public function getFormSearch()
    {
        $search_fields = setting_item_array('space_search_fields');
        $search_fields = array_values(\Illuminate\Support\Arr::sort($search_fields, function ($value) {
            return $value['position'] ?? 0;
        }));
        foreach ( $search_fields as &$item){
            if($item['field'] == 'attr' and !empty($item['attr']) ){
                $attr = Attributes::find($item['attr']);
                $item['attr_title'] = $attr->translate()->name;
                foreach($attr->terms as $term)
                {
                    $translate = $term->translate();
                    $item['terms'][] =  [
                        'id' => $term->id,
                        'title' => $translate->name,
                    ];
                }
            }
            if($item['field'] == 'guests'){
                $item['field_guests'] = [
                    [
                        'id'=>'adults',
                        'title'=>__('Adults')
                    ],
                    [
                        'id'=>'children',
                        'title'=>__('Children')
                    ]
                ];
            }
        }
        return $search_fields;
    }
}
