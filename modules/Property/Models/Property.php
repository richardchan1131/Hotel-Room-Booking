<?php

namespace Modules\Property\Models;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Modules\Booking\Traits\CapturesService;
use Modules\AgencyModels\Agencies;
use Modules\AgencyModels\AgenciesAgent;
use Modules\Booking\Models\Bookable;
use Modules\Booking\Models\Booking;
use Modules\Core\Models\SEO;
use Modules\Media\Helpers\FileHelper;
use Modules\Review\Models\Review;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Property\Models\PropertyTranslation;
use Modules\User\Models\UserWishList;
use Modules\Location\Models\Location;

class Property extends Bookable
{
    use SoftDeletes, CapturesService;

    protected $table = 'bc_properties';
    public $type = 'property';
    public $checkout_booking_detail_file       = 'Property::frontend/booking/detail';
    public $checkout_booking_detail_modal_file = 'Property::frontend/booking/detail-modal';
    public $email_new_booking_file             = 'Property::emails.new_booking_detail';
    protected $translation_class = PropertyTranslation::class;

    const FOR_SALE = 1;
    const FOR_RENT = 2;


    protected $fillable = [
        'title',
        'content',
        'status',
        'faqs'
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'title';
    protected $seo_type = 'property';

    protected $casts = [
        'faqs'  => 'array',
        'extra_price'  => 'array',
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
     * @var PropertyDate
     */
    protected $propertyDateClass;

    /**
     * @var propertyTerm
     */
    protected $propertyTermClass;

    /**
     * @var propertyTerm
     */
    protected $propertyTranslationClass;
    protected $userWishListClass;

    /**
     * @var agencies
     */
    protected $agenciesAgentClass;
    protected $agenciesClass;

    protected $tmp_dates = [];

    /**
     * const feature
     */
    const IS_FEATURE = 1;
    const IS_NOT_FEATURE = 0;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->bookingClass = Booking::class;
        $this->reviewClass = Review::class;
        $this->propertyDateClass = PropertyDate::class;
        $this->propertyTermClass = PropertyTerm::class;
        $this->propertyTranslationClass = PropertyTranslation::class;
        $this->userWishListClass = UserWishList::class;
        $this->agenciesAgentClass = AgenciesAgent::class;
        $this->agenciesClass = Agencies::class;
    }

    public static function getModelName()
    {
        return __("Property");
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
        $meta['seo_title'] = __("Search for Properties");
        if (!empty($title = setting_item_with_lang("property_page_list_seo_title",false))) {
            $meta['seo_title'] = $title;
        }else if(!empty($title = setting_item_with_lang("property_page_search_title"))) {
            $meta['seo_title'] = $title;
        }
        $meta['seo_image'] = null;
        if (!empty($title = setting_item("property_page_list_seo_image"))) {
            $meta['seo_image'] = $title;
        }else if(!empty($title = setting_item("property_page_search_banner"))) {
            $meta['seo_image'] = $title;
        }
        $meta['seo_desc'] = setting_item_with_lang("property_page_list_seo_desc");
        $meta['seo_share'] = setting_item_with_lang("property_page_list_seo_share");
        $meta['full_url'] = url(config('property.property_route_prefix'));
        return $meta;
    }


    public function terms(){
        return $this->hasMany($this->propertyTermClass, "target_id");
    }

    public function user()
    {
        return $this->belongsTo(\Modules\User\Models\User::class, 'author_id')->withDefault();
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
        $urlDetail = app_get_locale(false, false, '/') . config('property.property_route_prefix') . "/" . $this->slug;
        if(!empty($param)){
            $urlDetail .= "?".http_build_query($param);
        }
        return url($urlDetail);
    }

    public static function getLinkForPageSearch( $locale = false , $param = [] ){

        return url(app_get_locale(false , false , '/'). config('property.property_route_prefix')."?".http_build_query($param));
    }


    public function getEditUrl()
    {
        return url(route('property.admin.edit',['id'=>$this->id]));
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
        $extra_price_input = $request->input('extra_price');
        $extra_price = [];

        $total = $this->getPriceInRanges($request->input('start_date'),$request->input('end_date'));

        $duration_in_hour = max(1,ceil(($end_date->getTimestamp() - $start_date->getTimestamp()) / HOUR_IN_SECONDS ) + 24 );

        if ($this->enable_extra_price and !empty($this->extra_price)) {
            if (!empty($this->extra_price)) {
                foreach ($this->extra_price as $k => $type) {
                    if (isset($extra_price_input[$k]) and $extra_price_input[$k]['enable'] and $extra_price_input[$k]['enable'] != 'false') {
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

        //Buyer Fees
        $total_before_fees = $total;
        $list_fees = setting_item('property_booking_buyer_fees');
        if (!empty($list_fees)) {
            $total_fee = 0;
            $lists = json_decode($list_fees, true);
            foreach ($lists as $item) {
                //for Fixed
                $fee_price = $item['price'];
                // for Percent
                if(!empty($item['unit']) and $item['unit'] == "percent"){
                    $fee_price = ( $total_before_fees / 100 ) * $item['price'];
                }
                if (!empty($item['per_person']) and $item['per_person'] == "on") {
                    $total_fee += $fee_price * $total_guests;
                } else {
                    $total_fee += $fee_price;
                }
            }
            $total += $total_fee;
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
        $booking->buyer_fees = $list_fees ?? '';
        $booking->total_before_fees = $total_before_fees;
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
                $booking->deposit = $booking->deposit + $total_fee;
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
            if($this->isDepositEnable())
            {
                $booking->addMeta('deposit_info',[
                    'type'=>$this->getDepositType(),
                    'amount'=>$this->getDepositAmount(),
                    'fomular'=>$this->getDepositFomular(),
                ]);
            }

            return $this->sendSuccess([
                'url' => $booking->getCheckoutUrl()
            ]);
        }
        return $this->sendError(__("Can not check availability"));
    }

    public function getPriceInRanges($start_date,$end_date){
        $totalPrice = 0;
        $price = ($this->sale_price and $this->sale_price > 0 and  $this->sale_price < $this->price) ? $this->sale_price : $this->price;

        $datesRaw = $this->propertyDateClass::getDatesInRanges($start_date,$end_date,$this->id);
        $dates = [];
        if(!empty($datesRaw))
        {
            foreach ($datesRaw as $date){
                $dates[date('Y-m-d',strtotime($date['start_date']))] = $date;
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

        for($i = strtotime($start_date); $i <= strtotime($end_date); $i += DAY_IN_SECONDS){
            if(empty($dates[date('Y-m-d',$i)]))
            {
                $totalPrice += $price;
            }else{
                $totalPrice += $dates[date('Y-m-d',$i)]->price;
            }
        }

        $this->tmp_dates = $dates;

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

        // Validate Date and Booking
        if(!$this->isAvailableInRanges($start_date,$end_date)){
            return $this->sendError(__("This property is not available at selected dates"));
        }

	    if(!$this->checkBusyDate($start_date,$end_date)){
            return $this->sendError(__("This property is not available at selected dates"));
	    }

        return true;
    }

    public function isAvailableInRanges($start_date,$end_date){

        $days = max(1,floor((strtotime($end_date) - strtotime($start_date)) / DAY_IN_SECONDS));

        if($this->default_state)
        {
            $notAvailableDates = $this->propertyDateClass::query()->where([
                ['start_date','>=',$start_date],
                ['end_date','<=',$end_date],
                ['active','0'],
                ['target_id','=',$this->id],
            ])->count('id');
            if($notAvailableDates) return false;

        }else{
            $availableDates = $this->propertyDateClass::query()->where([
                ['start_date','>=',$start_date],
                ['end_date','<=',$end_date],
                ['active','=',1],
                ['target_id','=',$this->id],
            ])->count('id');
            if($availableDates <= $days) return false;
        }

        // Check Order
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

        $list_fees = setting_item_array('property_booking_buyer_fees');
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
        return $booking_data;
    }

    public static function searchForMenu($q = false)
    {
        $query = static::select('id', 'title as name');
        if (strlen($q)) {

            $query->where('title', 'like', "%" . $q . "%");
        }
        $a = $query->limit(10)->get();
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
        return setting_item("property_enable_review", 0);
    }

    public function getReviewApproved()
    {
        return setting_item("property_review_approved", 0);
    }

    public function check_enable_review_after_booking()
    {
        $option = setting_item("property_enable_review_after_booking", 0);
        if ($option) {
            $number_review = $this->reviewClass::countReviewByServiceID($this->id, Auth::id()) ?? 0;
            $number_booking = $this->bookingClass::countBookingByServiceID($this->id, Auth::id()) ?? 0;
            if ($number_review >= $number_booking) {
                return false;
            }
        }
        return true;
    }

    public function check_allow_review_after_making_completed_booking()
    {
        $options = setting_item("property_allow_review_after_making_completed_booking", false);
        if (!empty($options)) {
            $status = json_decode($options);
            $booking = $this->bookingClass::select("status")
                ->where("object_id", $this->id)
                ->where("object_model", $this->type)
                ->where("customer_id", Auth::id())
                ->orderBy("id","desc")
                ->first();
            $booking_status = $booking->status ?? false;
            if(!in_array($booking_status , $status)){
                return false;
            }
        }
        return true;
    }

    public static function getReviewStats()
    {
        $reviewStats = [];
        if (!empty($list = setting_item("property_review_stats", []))) {
            $list = json_decode($list, true);
            foreach ($list as $item) {
                $reviewStats[] = $item['title'];
            }
        }
        return $reviewStats;
    }

    public function getNumberReviewsInService($status = false)
    {
        return $this->reviewClass::countReviewByServiceID($this->id, false, $status,$this->type) ?? 0;
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
            return __(":number Properties", ['number' => $number]);
        }
        return __(":number Property", ['number' => $number]);
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
            $this->propertyTermClass::firstOrCreate([
                'term_id' => $term_id,
                'target_id' => $new->id
            ]);
        }
        //Language
        $langs = $this->propertyTranslationClass::where("origin_id",$old->id)->get();
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
        return setting_item('property_disable') == false;
    }

    public function isDepositEnable(){
        return (setting_item('property_deposit_enable') and setting_item('property_deposit_amount'));
    }
    public function getDepositAmount(){
        return setting_item('property_deposit_amount');
    }
    public function getDepositType(){
        return setting_item('property_deposit_type');
    }
    public function getDepositFomular(){
        return setting_item('property_deposit_fomular','default');
    }

    public function detailBookingEachDate($booking)
    {
	    $startDate = $booking->start_date;
	    $endDate = $booking->end_date;
        $rowDates= json_decode($booking->getMeta('tmp_dates'));
	    $allDates=[];
	    $service = $booking->service;
		    for($i = strtotime($startDate); $i <= strtotime($endDate); $i+= DAY_IN_SECONDS)
		    {
		    	$price = (!empty($service->sale_price) and $service->sale_price > 0 and $service->sale_price < $service->price) ? $service->sale_price : $service->price;
			    $date['price'] =$price;
			    $date['price_html'] = format_money($price);
			    $date['from'] = $i;
			    $date['from_html'] = date('d/m/Y',$i);
			    $date['to'] = $i;
			    $date['to_html'] = date('d/m/Y',($i));
			    $allDates[date('Y-m-d',$i)] = $date;
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
        if(!empty(setting_item('booking_enquiry_for_property'))){
            return true;
        }
        return false;
    }

    public static function isFormEnquiryAndBook(){
        $check = setting_item('booking_enquiry_for_property');
        if(!empty($check) and setting_item('booking_enquiry_type') == "booking_and_enquiry" ){
            return true;
        }
        return false;
    }
    public static function getBookingEnquiryType(){
        $check = setting_item('booking_enquiry_for_property');
        if(!empty($check)){
            if( setting_item('booking_enquiry_type') == "only_enquiry" ) {
                return "enquiry";
            }
        }
        return "book";
    }

    public function search(Request $request)
    {
        $query = parent::query()->select("bc_properties.*");
        $query->where("bc_properties.status", "publish");
        if(!empty($agent_id  = $request->query('agent_id'))){
            $query->where('author_id',$agent_id);
        }
        if($s  = $request->query('s')){
            $query->where(function($query) use ($s){
                $query->where('title','like','%'.$s.'%');
                $query->orWhere('address','like','%'.$s.'%');
                return $query;
            });
        }
        if (!empty($location_id = $request->query('location_id'))) {
            $location = Location::query()->where('id', $location_id)->where("status","publish")->first();
            if(!empty($location)){
                $query->join('bc_locations', function ($join) use ($location) {
                    $join->on('bc_locations.id', '=', 'bc_properties.location_id')
                        ->where('bc_locations._lft', '>=', $location->_lft)
                        ->where('bc_locations._rgt', '<=', $location->_rgt);
                });
            }
        }
        if (!empty($price_range = $request->query('price_range'))) {
            $pri_from = (int)$price_range[0];
            $pri_to = (int)$price_range[1];
            if($pri_to > $pri_from && $pri_from > 0) {
                $raw_sql_min_max = "( (IFNULL(bc_properties.sale_price,0) > 0 and bc_properties.sale_price >= ? ) OR (IFNULL(bc_properties.sale_price,0) <= 0 and bc_properties.price >= ? ) )
                                AND ( (IFNULL(bc_properties.sale_price,0) > 0 and bc_properties.sale_price <= ? ) OR (IFNULL(bc_properties.sale_price,0) <= 0 and bc_properties.price <= ? ) )";
                $query->WhereRaw($raw_sql_min_max,[$pri_from,$pri_from,$pri_to,$pri_to]);
            }
        }

        $terms = $request->query('terms');
        if($term_id = $request->query('term_id'))
        {
            $terms[] = $term_id;
        }

        if (is_array($terms) && !empty($terms)) {
            $query->join('bc_property_term as tt', 'tt.target_id', "bc_properties.id")->whereIn('tt.term_id', $terms);
        }

        $review_scores = $request->query('review_score');
        if (is_array($review_scores) && !empty($review_scores)) {
            $where_review_score = [];
            foreach ($review_scores as $number){
                $where_review_score[] = " ( bc_properties.review_score >= {$number} AND bc_properties.review_score <= {$number}.9 ) ";
            }
            $sql_where_review_score = " ( " . implode("OR", $where_review_score) . " )  ";
            $query->WhereRaw($sql_where_review_score);
        }
        if(!empty($property_type = $request->query("property_type"))) {
            $query->where("bc_properties.property_type",$property_type);
        }
        if(!empty($garage = $request->query("garage"))) {
            $query->where("bc_properties.garages",$garage);
        }
        if(!empty($bathroom = $request->query("bathroom")) && $bathroom > 0) {
            $query->where("bc_properties.bathroom",$bathroom);
        }
        if(!empty($bedroom = $request->query("bedroom")) && $bedroom > 0) {
            $query->where("bc_properties.bed",$bedroom);
        }
        if(!empty($cat = $request->query("category_id")) && $cat > 0) {
            $query->where("bc_properties.category_id",$cat);
        }
        if(!empty($year_built = $request->query("year_built")) && $year_built > 0) {
            // dd($year_built);
            $query->where("bc_properties.year_built",$year_built);
        }
        if(!empty( $service_name = $request->query("service_name") )){
            if( setting_item('site_enable_multi_lang') && setting_item('site_locale') != app()->getLocale() ){
                $query->leftJoin('bc_property_translations', function ($join) {
                    $join->on('bc_properties.id', '=', 'bc_property_translations.origin_id');
                });
                $query->where('bc_property_translations.title', 'LIKE', '%' . $service_name . '%');

            }else{
                $query->where('bc_properties.title', 'LIKE', '%' . $service_name . '%');
            }
        }
        $filter = $request->query("filter",$request->query('orderby'));
        if($filter) {
            switch($filter) {
                case"new":
                    $query->orderBy("id", "desc");
                    break;
                case"old":
                    $query->orderBy("id");
                    break;
                case"price_high":
                    $query->orderBy("price", "desc");
                    break;
                case"price_low":
                    $query->orderBy("price", "asc");
                    break;
                case"name_high":
                    $query->orderBy("title", "asc");
                    break;
                case"name_low":
                    $query->orderBy("title", "desc");
                    break;
                case "rate_high_low":
                    $query->orderBy("review_score", "desc");
                    break;
                default:
                    $query->orderBy("is_featured", "desc");
                    $query->orderBy("id", "desc");
                    break;
            }

        }
        $query->groupBy("bc_properties.id");

        $max_guests = (int)($request->query('adults') + $request->query('children'));
        if($max_guests){
            $query->where('max_guests','>=',$max_guests);
        }

        return $query->with(['location','hasWishList','translation','user','Category']);
    }

    /**
     * Get list feature properties
     *
     * @return mixed
     */
    public function getFeatureProperties()
    {
        return self::where('is_featured', self::IS_FEATURE)
            ->where('status', 'publish')
            ->select('title', 'is_featured', 'image_id', 'price', 'bed', 'bathroom', 'square')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getRecentlyViewProperties()
    {
        return self::where('status', 'publish')
            ->select('title', 'is_featured', 'image_id', 'price', 'bed', 'bathroom', 'square')
            ->orderBy('last_time_viewed', 'desc')
            ->limit(3)
            ->get();
    }

    public function getUserProperty($id) {
        return self::select('*')
            ->where('author_id', $id)
            ->where('is_featured', self::IS_FEATURE)
            ->get();
    }

    public function Category(){
        return $this->belongsTo(PropertyCategory::class,'category_id','id');
     }

    public function getNamePropertyById($id) {
        return self::select('name')
                ->where('id', $id)
                ->first();
    }

    public function getPrefixPriceAttribute(){
        if(setting_item('property_prefix_price_listing')){
            return __('From ');
        }
        return '';
    }

    public function count_remain_review(){
        return true;
    }

}
