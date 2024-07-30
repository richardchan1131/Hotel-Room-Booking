<?php

namespace Modules\Boat\Models;

use App\Currency;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Modules\Booking\Models\Bookable;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Service;
use Modules\Booking\Traits\CapturesService;
use Modules\Core\Models\Attributes;
use Modules\Core\Models\SEO;
use Modules\Core\Models\Terms;
use Modules\Media\Helpers\FileHelper;
use Modules\Review\Models\Review;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Boat\Models\BoatTranslation;
use Modules\User\Models\UserWishList;
use Modules\Location\Models\Location;

class Boat extends Bookable
{
    use Notifiable;
    use SoftDeletes;
    use CapturesService;

    protected $table = 'bravo_boats';
    public $type = 'boat';
    public $checkout_booking_detail_file       = 'Boat::frontend/booking/detail';
    public $checkout_booking_detail_modal_file = 'Boat::frontend/booking/detail-modal';
    public $set_paid_modal_file                = 'Boat::frontend/booking/set-paid-modal';
    public $email_new_booking_file             = 'Boat::emails.new_booking_detail';
    public $availabilityClass = BoatDate::class;
    protected $translation_class = BoatTranslation::class;

    protected $fillable = [
        'title',
        'content',
        'status',
        'faqs'
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'title';
    protected $seo_type = 'boat';
    protected $casts = [
        'faqs'        => 'array',
        'specs'       => 'array',
        'extra_price' => 'array',
        'service_fee' => 'array',
        'price'       => 'float',
        'sale_price'  => 'float',
        'include'     => 'array',
        'exclude'     => 'array',
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
     * @var BoatDate
     */
    protected $boatDateClass;

    /**
     * @var BoatTerm
     */
    protected $boatTermClass;

    protected $boatTranslationClass;
    protected $userWishListClass;

    protected $tmp_price = 0;
    protected $tmp_dates = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->bookingClass = Booking::class;
        $this->reviewClass = Review::class;
        $this->boatDateClass = BoatDate::class;
        $this->boatTermClass = BoatTerm::class;
        $this->boatTranslationClass = BoatTranslation::class;
        $this->userWishListClass = UserWishList::class;
    }

    public static function getModelName()
    {
        return __("Boat");
    }

    public static function getTableName()
    {
        return with(new static)->table;
    }


    /**
     * Get SEO fop page list
     *
     * @return mixed
     */
    static public function getSeoMetaForPageList()
    {
        $meta['seo_title'] = __("Search for Boats");
        if (!empty($title = setting_item_with_lang("boat_page_list_seo_title",false))) {
            $meta['seo_title'] = $title;
        }else if(!empty($title = setting_item_with_lang("boat_page_search_title"))) {
            $meta['seo_title'] = $title;
        }
        $meta['seo_image'] = null;
        if (!empty($title = setting_item("boat_page_list_seo_image"))) {
            $meta['seo_image'] = $title;
        }else if(!empty($title = setting_item("boat_page_search_banner"))) {
            $meta['seo_image'] = $title;
        }
        $meta['seo_desc'] = setting_item_with_lang("boat_page_list_seo_desc");
        $meta['seo_share'] = setting_item_with_lang("boat_page_list_seo_share");
        $meta['full_url'] = url()->current();
        return $meta;
    }


    public function terms(){
        return $this->hasMany($this->boatTermClass, "target_id");
    }

    public function getDetailUrl($include_param = true)
    {
        $param = [];
        if($include_param){
            if (!empty($date = request()->input('start'))) {
                $param['start'] = $date;
            }
        }
        $urlDetail = app_get_locale(false, false, '/') . config('boat.boat_route_prefix') . "/" . $this->slug;
        if(!empty($param)){
            $urlDetail .= "?".http_build_query($param);
        }
        return url($urlDetail);
    }

    public static function getLinkForPageSearch( $locale = false , $param = [] ){

        return url(app_get_locale(false , false , '/'). config('boat.boat_route_prefix')."?".http_build_query($param));
    }

    public function getEditUrl()
    {
        return url(route('boat.admin.edit',['id'=>$this->id]));
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

        // Get price in range
        $number = $request->input('number',1);
        $total = $this->tmp_price * $number;

        // Extra Price
        $extra_price_input = $request->input('extra_price');
        $extra_price = [];
        if ($this->enable_extra_price and !empty($this->extra_price)) {
            if (!empty($this->extra_price)) {
                foreach ($this->extra_price as $k => $type) {
                    if (isset($extra_price_input[$k]) and !empty($extra_price_input[$k]['enable'])) {
                        $type_total = 0;
                        switch ($type['type']) {
                            case "one_time":
                                $type_total = $type['price'] * $number;
                                break;
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
        if (!empty($list_buyer_fees = setting_item('boat_booking_buyer_fees'))) {
            $list_fees = json_decode($list_buyer_fees, true);
            $total_buyer_fee = $this->calculateServiceFees($list_fees , $total_before_fees , 1);
            $total += $total_buyer_fee;
        }

        //Service Fees for Vendor
        $total_service_fee = 0;
        if(!empty($this->enable_service_fee) and !empty($list_service_fee = $this->service_fee)){
            $total_service_fee = $this->calculateServiceFees($list_service_fee , $total_before_fees , 1);
            $total += $total_service_fee;
        }

        $booking = new $this->bookingClass();
        $booking->status = 'draft';
        $booking->object_id = $request->input('service_id');
        $booking->object_model = $request->input('service_type');
        $booking->vendor_id = $this->author_id;
        $booking->customer_id = Auth::id();
        $booking->total = $total;
        $booking->total_guests = 1;
        $booking->start_date = $this->tmp_start_date;
        $booking->end_date = $this->tmp_end_date;

        $booking->vendor_service_fee_amount = $total_service_fee ?? '';
        $booking->vendor_service_fee = $list_service_fee ?? '';
        $booking->buyer_fees = $list_buyer_fees ?? '';
        $booking->total_before_fees = $total_before_fees;
        $booking->total_before_discount = $total_before_fees;

        $booking->calculateCommission();
        $booking->number = $number;

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

            $booking->addMeta('base_price', $this->tmp_price);
            $booking->addMeta('extra_price', $extra_price);
            $booking->addMeta('type_date', $this->tmp_type_date);
            $booking->addMeta('tmp_dates', $this->tmp_dates);
            $booking->addMeta('start_time', $request->input('start_time'));
            $booking->addMeta('day', $request->input('day'));
            $booking->addMeta('hour', $request->input('hour'));

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

    public function addToCartValidate(Request $request)
    {
        $rules = [
            'start_date' => 'required|date_format:Y-m-d',
        ];

        // Validation
        if (!empty($rules)) {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->sendError('', ['errors' => $validator->errors()]);
            }
        }
        $total_number = $request->input('number',1);

        $start_date = $request->input('start_date');
        if(strtotime($start_date) < strtotime(date('Y-m-d 00:00:00')))
        {
            return $this->sendError(__("Your selected dates are not valid"));
        }

        if(!empty($this->min_day_before_booking)){
            $minday_before = strtotime("today +".$this->min_day_before_booking." days");
            if(  strtotime($start_date) < $minday_before){
                return $this->sendError(__("You must book the service for :number days in advance",["number"=>$this->min_day_before_booking]));
            }
        }

        $hour = $request->input('hour',0);
        $day = $request->input('day',0);
        $start_time = $request->input('start_time');

        if(empty($hour) and empty($day)){
            return $this->sendError(__("You haven't selected return day or hours"));
        }

        if(!empty($this->start_time_booking)){
            if(strtotime($start_time) < strtotime( $this->start_time_booking )){
                return $this->sendError(__("Start time booking: :time",['time'=>$this->start_time_booking]));
            }
        }
        if(!empty($this->end_time_booking)){
            if(strtotime($start_time) > strtotime( $this->end_time_booking )){
                return $this->sendError(__("End time booking: :time",['time'=>$this->end_time_booking]));
            }
        }
        $type = empty($day) ? "per_hour":"per_day";
        $start_date_time = $start_date." ".$start_time;
        if($type == 'per_hour'){
            $end_date_time = date('Y-m-d H:i' , strtotime($start_date_time ." +".$hour."hours"));
            if( strtotime($end_date_time) > strtotime($start_date ." +1day")){
                return $this->sendError(__("You need return boat on same-day"));
            }
        }
        if($type == 'per_day'){
            $end_date_time = date('Y-m-d H:i' , strtotime($start_date_time ." +".$day."days"));
        }

        if(!$this->isAvailableInRanges($start_date_time,$end_date_time,$type,$hour,$total_number)){
            return $this->sendError(__("This boat is not available at selected dates"));
        }
        return true;
    }

    public function beforeCheckout(Request $request, $booking)
    {
        if(!$this->isAvailableInRanges($booking->start_date,$booking->end_date,$booking->getMeta("type_date"),$booking->getMeta("hour"),$booking->number)){
            return $this->sendError(__("This boat is not available at selected dates"));
        }
    }

    public function isAvailableInRanges($start_date_time,$end_date_time,$type,$hour,$number = 1){
        $allDates = [];
        if($type == 'per_hour'){
            $start_date =  date('Y-m-d' , strtotime($start_date_time));
            $base_price = $this->price_per_hour;
            $allDates[$start_date] = [
                'number'=>$this->number,
                'price'=>$base_price * $hour,
                'status'=>$this->default_state
            ];
            $datesData = $this->getDatesInRange($start_date,$start_date);
            if(!empty($datesData)){
                foreach ($datesData as $date)
                {
                    $allDates[$start_date] = [
                        'number'=>$date->number,
                        'price'=>$date->price_per_hour * $hour,
                        'status'=>$date->active
                    ];
                }
            }
            if(empty($allDates[$start_date]['status'])){
                return false;
            }
        }
        if($type == 'per_day'){
            $base_price = $this->price_per_day;
            $period = periodDate($start_date_time,$end_date_time,true);
            foreach ($period as $dt) {
                $allDates[$dt->format('Y-m-d')] = [
                    'number'=>$this->number,
                    'price'=>$base_price,
                    'status'=>$this->default_state
                ];
            }
            $datesData = $this->getDatesInRange($start_date_time,$end_date_time);
            if(!empty($datesData)){
                foreach ($datesData as $date)
                {
                    if(empty($allDates[date('Y-m-d',strtotime($date->start_date))])) continue;
                    $allDates[date('Y-m-d',strtotime($date->start_date))] = [
                        'number'=>$date->number,
                        'price'=>$date->price_per_day,
                        'status'=>$date->active
                    ];
                }
            }
            foreach ($allDates as $date=>$data)
            {
                if(empty($data['status'])){
                    return false;
                }
            }
            // Remove ngay cuoi tra boat
            array_pop($allDates);
        }
        $bookingData = $this->getBookingsInRange($start_date_time,$end_date_time);
        if(!empty($bookingData) and $bookingData->count() > 0){
            return false;
        }

        $this->tmp_price = array_sum(array_column($allDates,'price'));
        $this->tmp_dates = $allDates;

        $this->tmp_start_date = $start_date_time;
        $this->tmp_end_date = $end_date_time;
        $this->tmp_type_date = $type;

        return true;
    }
    public function getDatesInRange($start_date,$end_date)
    {
        $query = $this->boatDateClass::query();
        $query->where('target_id',$this->id);
        $query->where('start_date','>=',date('Y-m-d',strtotime($start_date)));
        $query->where('end_date','<=',date('Y-m-d',strtotime($end_date)));
        return $query->take(100)->get();
    }

    public function getBookingData()
    {
        if (!empty($start = request()->input('start'))) {
            $start = date("Y-m-d",strtotime($start));
        }
        $booking_data = [
            'id'              => $this->id,
            'extra_price'     => [],
            'minDate'         => date('m/d/Y'),
            'max_number'      => $this->number ?? 1,
            'buyer_fees'      => [],
            'start_date'      => $start ?? "",
            'start_date_html' => request()->input('start') ? display_date(request()->input('start')) : __('Please select'),
            'deposit'=>$this->isDepositEnable(),
            'deposit_type'=>$this->getDepositType(),
            'deposit_amount'=>$this->getDepositAmount(),
            'deposit_fomular'=>$this->getDepositFomular(),
            'is_form_enquiry_and_book'=> $this->isFormEnquiryAndBook(),
            'enquiry_type'=> $this->getBookingEnquiryType(),
            'start_time'=> $this->start_time_booking ?? "00:00",
        ];
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

        $list_fees = setting_item_array('boat_booking_buyer_fees');
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
        $model = parent::selectRaw('MIN( min_price ) AS min_price ,
                                    MAX( min_price ) AS max_price ')->where("status", "publish")->first();
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
        return setting_item("boat_enable_review", 0);
    }

    public function getReviewApproved()
    {
        return setting_item("boat_review_approved", 0);
    }

    public function review_after_booking(){
        return setting_item("boat_enable_review_after_booking", 0);
    }

    public function count_remain_review()
    {
        $status_making_completed_booking = [];
        $options = setting_item("boat_allow_review_after_making_completed_booking", false);
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
        if (!empty($list = setting_item("boat_review_stats", []))) {
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
        $boat_id = $this->id;
        $list_score = Cache::rememberForever('review_'.$this->type.'_' . $boat_id, function () use ($boat_id) {
            $dataReview = $this->reviewClass::selectRaw(" AVG(rate_number) as score_total , COUNT(id) as total_review ")->where('object_id', $boat_id)->where('object_model', "boat")->where("status", "approved")->first();
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
        return $this->reviewClass::select(['id','title','content','rate_number','author_ip','status','created_at','vendor_id','author_id'])->where('object_id', $this->id)->where('object_model', 'boat')->where("status", "approved")->orderBy("id", "desc")->with('author')->paginate(setting_item('boat_review_number_per_page', 5));
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
            return __(":number Boats", ['number' => $number]);
        }
        return __(":number Boat", ['number' => $number]);
    }

    /**
     * @param $from
     * @param $to
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getBookingsInRange($from,$to){

        $query = $this->bookingClass::query();
        $query->whereNotIn('status',$this->bookingClass::$notAcceptedStatus);
        $query->where('start_date','<',$to)->where('end_date','>',$from)->take(100);

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
            $this->boatTermClass::firstOrCreate([
                'term_id' => $term_id,
                'target_id' => $new->id
            ]);
        }
        //Language
        $langs = $this->boatTranslationClass::where("origin_id",$old->id)->get();
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
        return "icofont-ship";
    }

    public static function isEnable(){
        return setting_item('boat_disable') == false;
    }


    public function getBookingInRanges($object_id,$object_model,$from,$to,$object_child_id = false){

        $query = $this->bookingClass::selectRaw(" * , SUM( number ) as total_numbers ")->where([
            'object_id'=>$object_id,
            'object_model'=>$object_model,
        ])->whereNotIn('status',$this->bookingClass::$notAcceptedStatus)
            ->where('end_date','>',$from)
            ->where('start_date','<',$to)
            ->groupBy('start_date')
            ->take(200);

        if($object_child_id){
            $query->where('object_child_id',$object_child_id);
        }

        return $query->get();
    }

    public function isDepositEnable(){
        return (setting_item('boat_deposit_enable') and setting_item('boat_deposit_amount'));
    }
    public function getDepositAmount(){
        return setting_item('boat_deposit_amount');
    }
    public function getDepositType(){
        return setting_item('boat_deposit_type');
    }
    public function getDepositFomular(){
        return setting_item('boat_deposit_fomular','default');
    }
	public function detailBookingEachDate($booking){
		$startDate = $booking->start_date;
		$endDate = $booking->end_date;
		$rowDates= json_decode($booking->getMeta('tmp_dates'));

		$allDates=[];
        $period = periodDate($startDate,$endDate,false);
        foreach ($period as $dt) {
			$price = 0;
			$date['price'] =$price;
			$date['price_html'] = format_money($price);
			$date['from'] = $dt->getTimestamp();
			$date['from_html'] = $dt->format('d/m/Y');
			$date['to'] = $dt->getTimestamp();
			$date['to_html'] = $dt->format('d/m/Y');
			$allDates[$dt->format(('Y-m-d'))] = $date;
		}

		if(!empty($rowDates))
		{
			foreach ($rowDates as $item => $row)
			{
				$startDate = strtotime($item);
				$price = $row->price;
				$date['price'] = $price;
				$date['price_html'] = format_money($price);
				$date['from'] = $startDate;
				$date['from_html'] = date('d/m/Y',$startDate);
				$date['to'] = $startDate;
				$date['to_html'] = date('d/m/Y',($startDate));
				$allDates[date('Y-m-d',$startDate)] = $date;
			}
		}
		return $allDates;
	}

    public static function isEnableEnquiry(){
        if(!empty(setting_item('booking_enquiry_for_boat'))){
            return true;
        }
        return false;
    }
    public static function isFormEnquiryAndBook(){
        $check = setting_item('booking_enquiry_for_boat');
        if(!empty($check) and setting_item('booking_enquiry_type_boat') == "booking_and_enquiry" ){
            return true;
        }
        return false;
    }
    public static function getBookingEnquiryType(){
        $check = setting_item('booking_enquiry_for_boat');
        if(!empty($check)){
            if( setting_item('booking_enquiry_type_boat') == "only_enquiry" ) {
                return "enquiry";
            }
        }
        return "book";
    }


    public function search($request)
    {
        $query = parent::query()->select("bravo_boats.*");
        $query->where("bravo_boats.status", "publish");
        if (!empty($location_id = $request["location_id"] ?? "")) {
            $location = Location::query()->where('id', $location_id)->where("status","publish")->first();
            if(!empty($location)){
                $query->join('bravo_locations', function ($join) use ($location) {
                    $join->on('bravo_locations.id', '=', 'bravo_boats.location_id')
                        ->where('bravo_locations._lft', '>=', $location->_lft)
                        ->where('bravo_locations._rgt', '<=', $location->_rgt);
                });
            }
        }
        if (!empty($price_range = $request["price_range"] ?? "")) {
            $pri_from = Currency::convertPriceToMain(explode(";", $price_range)[0]);
            $pri_to =  Currency::convertPriceToMain(explode(";", $price_range)[1]);
            $raw_sql_min_max = "( bravo_boats.min_price >= ? ) AND ( bravo_boats.min_price <= ? )";
            $query->WhereRaw($raw_sql_min_max,[$pri_from,$pri_to]);
        }


        if(!empty($request['attrs'])){
            $this->filterAttrs($query,$request['attrs'],'bravo_boat_term');
        }

        $review_scores = $request['review_score'] ?? "";
        if (is_array($review_scores)) $review_scores = array_filter($review_scores);
        if (!empty($review_scores) && count($review_scores)) {
            $this->filterReviewScore($query,$review_scores);
        }

        if(!empty( $service_name = $request["service_name"] ?? "" )){
            if( setting_item('site_enable_multi_lang') && setting_item('site_locale') != app()->getLocale() ){
                $query->leftJoin('bravo_boat_translations', function ($join) {
                    $join->on('bravo_boats.id', '=', 'bravo_boat_translations.origin_id');
                });
                $query->where('bravo_boat_translations.title', 'LIKE', '%' . $service_name . '%');

            }else{
                $query->where('bravo_boats.title', 'LIKE', '%' . $service_name . '%');
            }
        }
        if(!empty($lat = $request["map_lat"] ?? "") and !empty($lgn = $request["map_lgn"] ?? "") and !empty($request["map_place"] ?? ""))
        {
            $this->filterLatLng($query,$lat,$lgn);
        }
        if(!empty($request['is_featured']))
        {
            $query->where('bravo_boats.is_featured',1);
        }
        if (!empty($request['custom_ids']) and !empty( $ids = array_filter($request['custom_ids']) )) {
            $query->whereIn("bravo_boats.id", $ids);
            $query->orderByRaw('FIELD (id, ' . implode(', ', $ids) . ') ASC');
        }
        $orderby = $request['orderby'] ?? "";
        switch ($orderby){
            case "price_low_high":
                $query->orderBy("min_price", "asc");
                break;
            case "price_high_low":
                $query->orderBy("min_price", "desc");
                break;
            case "rate_high_low":
                $query->orderBy("review_score", "desc");
                break;
            default:
                if(!empty($request['order']) and !empty($request['order_by'])){
                    $query->orderBy("bravo_boats.".$request['order'], $request['order_by']);
                }else{
                    $query->orderBy("is_featured", "desc");
                    $query->orderBy("id", "desc");
                }
        }

        $query->groupBy("bravo_boats.id");

        $max_guests = (int)($request["adults"] ?? 0) + (int)($request["children"] ?? 0);
        if($max_guests){
            $query->where('max_guests','>=',$max_guests);
        }


        return $query->with(['location','hasWishList','translation']);
    }

    public function dataForApi($forSingle = false){
        $data = parent::dataForApi($forSingle);
        $data['max_guest'] = $this->max_guest;
        $data['cabin'] = $this->cabin;
        $data['length'] = $this->length;
        $data['speed'] = $this->speed;
        $data['price'] = $this->min_price;
        if($forSingle){
            $data['review_score'] = $this->getReviewDataAttribute();
            $data['review_stats'] = $this->getReviewStats();
            $data['review_lists'] = $this->getReviewList();

            $data['faqs'] = $this->faqs;
            $data['cancel_policy'] = $this->cancel_policy;
            $data['terms_information'] = $this->terms_information;
            $data['min_day_before_booking'] = $this->min_day_before_booking;
            $data['is_instant'] = $this->is_instant;

            $data['number'] = $this->number;
            $data['price_per_hour'] = $this->price_per_hour;
            $data['price_per_day'] = $this->price_per_day;

            $data['default_state'] = $this->default_state;
            $data['booking_fee'] = setting_item_array('boat_booking_buyer_fees');
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
        return "\Modules\Boat\Controllers\AvailabilityController";
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
                "data" => Attributes::getAllAttributesForApi("boat")
            ]
        ];
    }

    static public function getFormSearch()
    {
        $search_fields = setting_item_array('boat_search_fields');
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
        }
        return $search_fields;
    }

    public function capturesService($event)
    {
        if(in_array($event,['saved','created', 'updated'])){
            $this->price = $this->min_price;
            Service::cloneService($this,$event);
        }
        if($event=='deleted'){
            Service::deleteService($this);
        }
        if($event=='restored'){
            Service::restoreService($this);
        }
    }
}
