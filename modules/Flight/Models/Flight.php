<?php

    namespace Modules\Flight\Models;

    use App\Currency;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Http\Response;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Support\Arr;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Http\Request;
    use League\Flysystem\Adapter\Local;
    use Modules\Booking\Models\Bookable;
    use Modules\Booking\Models\Booking;
    use Modules\Booking\Traits\CapturesService;
    use Modules\Core\Models\Attributes;
    use Modules\Core\Models\SEO;
    use Modules\Core\Models\Terms;
    use Modules\Flight\Factories\FlightFactory;
    use Modules\Media\Helpers\FileHelper;
    use Modules\Review\Models\Review;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Modules\User\Models\UserWishList;
    use Modules\Location\Models\Location;

    class Flight extends Bookable
    {
        use Notifiable;
        use SoftDeletes;
        use CapturesService;
        use HasFactory;

        protected $table                              = 'bravo_flight';
        public    $type                               = 'flight';
        public    $checkout_booking_detail_file       = 'Flight::frontend.booking.detail';
        public    $checkout_booking_detail_modal_file = 'Flight::frontend.booking.detail-modal';
        public    $set_paid_modal_file                = 'Flight::frontend.booking.set-paid-modal';
        public    $email_new_booking_file             = 'Flight::emails.new_booking_detail';
        public    $review_scope                       = false;

        protected $fillable = [
            'title',
            'code',
            'departure_time',
            'arrival_time',
            'duration',
            'airport_from',
            'airport_to',
            'airline_id',
            'status',
            'min_price',
        ];
        protected $seo_type = 'flight';

        protected $casts   = [
            'departure_time' => 'datetime',
            'arrival_time'   => 'datetime',
        ];
        protected $appends = ['can_book'];
        /**
         * @var Booking
         */
        protected $bookingClass;
        /**
         * @var Review
         */
        protected $reviewClass;

        /**
         * @var FlightTerm
         */
        protected $FlightTermClass;

        /**
         * @var FlightTerm
         */
        protected $userWishListClass;

        protected $tmp_dates = [];
        /**
         * @var string
         */
        private $termClass;


        public function __construct(array $attributes = [])
        {
            parent::__construct($attributes);
            $this->bookingClass = Booking::class;
            $this->termClass = FlightTerm::class;
        }

        public static function getModelName()
        {
            return __("Flight");
        }

        /**
         * Get SEO fop page list
         *
         * @return mixed
         */
        static public function getSeoMetaForPageList()
        {
            $meta['seo_title'] = __("Search for Flights");
            if (!empty($title = setting_item_with_lang("flight_page_list_seo_title", false))) {
                $meta['seo_title'] = $title;
            } else {
                if (!empty($title = setting_item_with_lang("flight_page_search_title"))) {
                    $meta['seo_title'] = $title;
                }
            }
            $meta['seo_image'] = null;
            if (!empty($title = setting_item("flight_page_list_seo_image"))) {
                $meta['seo_image'] = $title;
            } else {
                if (!empty($title = setting_item("flight_page_search_banner"))) {
                    $meta['seo_image'] = $title;
                }
            }
            $meta['seo_desc'] = setting_item_with_lang("flight_page_list_seo_desc");
            $meta['seo_share'] = setting_item_with_lang("flight_page_list_seo_share");
            $meta['full_url'] = url()->current();
            return $meta;
        }

        protected static function newFactory()
        {
            return FlightFactory::new();
        }

        public function terms()
        {
            return $this->hasMany($this->termClass, "target_id");
        }

        public function getDetailUrl($include_param = true)
        {
            return "#";
            $param = [];
            $urlDetail = app_get_locale(false, false, '/').config('flight.flight_route_prefix')."/".$this->id;
            if (!empty($param)) {
                $urlDetail .= "?".http_build_query($param);
            }
            return url($urlDetail);
        }

        public static function getLinkForPageSearch($locale = false, $param = [])
        {

            return url(app_get_locale(false, false, '/').config('flight.flight_route_prefix')."?".http_build_query($param));
        }

        public function getEditUrl()
        {
            return url(route('flight.admin.edit', ['id' => $this->id]));
        }

        public function getDiscountPercentAttribute()
        {
            if (!empty($this->price) and $this->price > 0
                and !empty($this->sale_price) and $this->sale_price > 0
                and $this->price > $this->sale_price
            ) {
                $percent = 100 - ceil($this->sale_price / ($this->price / 100));
                return $percent."%";
            }
        }

        public function fill(array $attributes)
        {
            if (!empty($attributes)) {
                foreach ($this->fillable as $item) {
                    $attributes[$item] = $attributes[$item] ?? null;
                }
            }
            return parent::fill($attributes); // TODO: Change the autogenerated stub
        }

        public function isBookable()
        {
            if ($this->status != 'publish') {
                return false;
            }
            return parent::isBookable();
        }

        public function addToCart(Request $request)
        {

            $res = $this->addToCartValidate($request);
            if ($res !== true) {
                return $res;
            }

            // Add Booking
            $total_guests = 0;
            $total = 0;

            $discount = 0;
            if (!empty($request->flight_seat)) {
                foreach ($request->flight_seat as $flight_seat) {
                    $total_guests += $flight_seat['number'] ?? 0;
                    $total += $flight_seat['number'] * $flight_seat['price'];
                }
            }

            //Buyer Fees for Admin
            $total_before_fees = $total;
            $total_buyer_fee = 0;
            if (!empty($list_buyer_fees = setting_item('flight_booking_buyer_fees'))) {
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

            $booking = new $this->bookingClass();
            $booking->status = 'draft';
            $booking->object_id = $request->input('service_id');
            $booking->object_model = $request->input('service_type');
            $booking->vendor_id = $this->author_id;
            $booking->customer_id = Auth::id();
            $booking->total = $total;
            $booking->total_guests = $total_guests;
            $booking->start_date = $this->departure_time->format('Y-m-d H:i:s');
            $booking->end_date = $this->arrival_time->format('Y-m-d H:i:s');

            $booking->vendor_service_fee_amount = $total_service_fee ?? '';
            $booking->vendor_service_fee = $list_service_fee ?? '';
            $booking->buyer_fees = $list_buyer_fees ?? '';
            $booking->total_before_fees = $total_before_fees;
            $booking->total_before_discount = $total_before_fees;

            $booking->calculateCommission();

            if ($this->isDepositEnable()) {
                $booking_deposit_fomular = $this->getDepositFomular();
                $tmp_price_total = $booking->total;
                if ($booking_deposit_fomular == "deposit_and_fee") {
                    $tmp_price_total = $booking->total_before_fees;
                }

                switch ($this->getDepositType()) {
                    case "percent":
                        $booking->deposit = $tmp_price_total * $this->getDepositAmount() / 100;
                        break;
                    default:
                        $booking->deposit = $this->getDepositAmount();
                        break;
                }
                if ($booking_deposit_fomular == "deposit_and_fee") {
                    $booking->deposit = $booking->deposit + $total_buyer_fee + $total_service_fee;
                }
            }

            $check = $booking->save();
            if ($check) {

                $this->bookingClass::clearDraftBookings();

                $booking->addMeta('duration', $this->duration);
                $booking->addMeta('base_price', $this->flightSeat()->min('price'));
                $booking->addMeta('sale_price', $this->flightSeat()->min('price'));
                $booking->addMeta('guests', $total_guests);
                $booking->addMeta('flight_seat', $request->flight_seat);
                if ($this->isDepositEnable()) {
                    $booking->addMeta('deposit_info', [
                        'type'    => $this->getDepositType(),
                        'amount'  => $this->getDepositAmount(),
                        'fomular' => $this->getDepositFomular(),
                    ]);
                }

                // Add Room Booking
                if (!empty($request->flight_seat)) {
                    foreach ($request->flight_seat as $flight_seat) {
                        for ($i = 1; $i <= $flight_seat['number']; $i++) {
                            $bookingPassengers = new BookingPassengers();
                            $bookingPassengers->fillByAttr([
                                'flight_id',
                                'flight_seat_id',
                                'booking_id',
                                'seat_type',
                                'email',
                                'first_name',
                                'last_name',
                                'phone',
                                'dob',
                                'price',
                                'id_card'
                            ], [
                                'flight_id'      => $this->id,
                                'flight_seat_id' => $flight_seat['id'],
                                'booking_id'     => $booking->id,
                                'seat_type'      => $flight_seat['seat_type']['code'],
                                'email'          => $booking->email,
                                'first_name'     => $booking->first_name,
                                'last_name'      => $booking->last_name,
                                'phone'          => $booking->phone,
                                'dob'            => '',
                                'price'          => $flight_seat['price'] ?? 0,
                                'id_card'        => ''
                            ]);
                            $bookingPassengers->save();
                        }

                    }
                }

                return $this->sendSuccess([
                    'url'          => $booking->getCheckoutUrl(),
                    'booking_code' => $booking->code,
                ]);
            }
            return $this->sendError(__("Can not check availability"));
        }

        public function getPriceInRanges($start_date, $end_date)
        {
            $totalPrice = 0;
            $price = ($this->sale_price and $this->sale_price > 0 and $this->sale_price < $this->price) ? $this->sale_price : $this->price;

            $datesRaw = $this->FlightDateClass::getDatesInRanges($start_date, $end_date, $this->id);
            $dates = [];
            if (!empty($datesRaw)) {
                foreach ($datesRaw as $date) {
                    $dates[date('Y-m-d', strtotime($date['start_date']))] = $date;
                }
            }

            if (strtotime($start_date) == strtotime($end_date)) {
                if (empty($dates[date('Y-m-d', strtotime($start_date))])) {
                    $totalPrice += $price;
                } else {
                    $totalPrice += $dates[date('Y-m-d', strtotime($start_date))]->price;
                }
                return $totalPrice;
            }
            if ($this->getBookingType() == 'by_day') {
                $period = periodDate($start_date, $end_date);
            }
            if ($this->getBookingType() == 'by_night') {
                $period = periodDate($start_date, $end_date, false);
            }
            foreach ($period as $dt) {
                $date = $dt->format('Y-m-d');
                if (empty($dates[$date])) {
                    $totalPrice += $price;
                } else {
                    $totalPrice += $dates[$date]->price;
                }
            }
            $this->tmp_dates = $dates;
            return $totalPrice;
        }

        public function addToCartValidate(Request $request)
        {
            $rules = [
                'flight_seat.*.number' => 'required',
            ];
            $messages = [
                'flight_seat.*.number.required' => "Seat type number must be required"
            ];
            // Validation
            if (!empty($rules)) {
                $validator = Validator::make($request->all(), $rules, $messages);
                if ($validator->fails()) {
                    return $this->sendError('', ['errors' => $validator->errors()]);
                }
            }
            return true;
        }


        public function getBookingData()
        {
            if (!empty($start = request()->input('start'))) {
                $start_html = display_date($start);
                $end_html = request()->input('end') ? display_date(request()->input('end')) : "";
                $date_html = $start_html.'<i class="fa fa-long-arrow-right" style="font-size: inherit"></i>'.$end_html;
            }
            $booking_data = [
                'id'                       => $this->id,
                'person_types'             => [],
                'max'                      => 0,
                'open_hours'               => [],
                'extra_price'              => [],
                'minDate'                  => date('m/d/Y'),
                'max_guests'               => $this->max_guests ?? 1,
                'buyer_fees'               => [],
                'start_date'               => request()->input('start') ?? "",
                'start_date_html'          => $date_html ?? __('Please select'),
                'end_date'                 => request()->input('end') ?? "",
                'deposit'                  => $this->isDepositEnable(),
                'deposit_type'             => $this->getDepositType(),
                'deposit_amount'           => $this->getDepositAmount(),
                'deposit_fomular'          => $this->getDepositFomular(),
                'is_form_enquiry_and_book' => $this->isFormEnquiryAndBook(),
                'enquiry_type'             => $this->getBookingEnquiryType(),
                'booking_type'             => $this->getBookingType(),
            ];
            if (!empty($adults = request()->input('adults'))) {
                $booking_data['adults'] = $adults;
            }
            if (!empty($children = request()->input('children'))) {
                $booking_data['children'] = $children;
            }
            $lang = app()->getLocale();
            if ($this->enable_extra_price) {
                $booking_data['extra_price'] = $this->extra_price;
                if (!empty($booking_data['extra_price'])) {
                    foreach ($booking_data['extra_price'] as $k => &$type) {
                        if (!empty($lang) and !empty($type['name_'.$lang])) {
                            $type['name'] = $type['name_'.$lang];
                        }
                        $type['number'] = 0;
                        $type['enable'] = 0;
                        $type['price_html'] = format_money($type['price']);
                        $type['price_type'] = '';
                        switch ($type['type']) {
                            case "per_day":
                                $type['price_type'] .= '/'.__('day');
                                break;
                            case "per_hour":
                                $type['price_type'] .= '/'.__('hour');
                                break;
                        }
                        if (!empty($type['per_person'])) {
                            $type['price_type'] .= '/'.__('guest');
                        }
                    }
                }

                $booking_data['extra_price'] = array_values((array) $booking_data['extra_price']);
            }

            $list_fees = setting_item_array('flight_booking_buyer_fees');
            if (!empty($list_fees)) {
                foreach ($list_fees as $item) {
                    $item['type_name'] = $item['name_'.app()->getLocale()] ?? $item['name'] ?? '';
                    $item['type_desc'] = $item['desc_'.app()->getLocale()] ?? $item['desc'] ?? '';
                    $item['price_type'] = '';
                    if (!empty($item['per_person']) and $item['per_person'] == 'on') {
                        $item['price_type'] .= '/'.__('guest');
                    }
                    $booking_data['buyer_fees'][] = $item;
                }
            }
            if (!empty($this->enable_service_fee) and !empty($service_fee = $this->service_fee)) {
                foreach ($service_fee as $item) {
                    $item['type_name'] = $item['name_'.app()->getLocale()] ?? $item['name'] ?? '';
                    $item['type_desc'] = $item['desc_'.app()->getLocale()] ?? $item['desc'] ?? '';
                    $item['price_type'] = '';
                    if (!empty($item['per_person']) and $item['per_person'] == 'on') {
                        $item['price_type'] .= '/'.__('guest');
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

                $query->where('title', 'like', "%".$q."%");
            }
            $a = $query->orderBy('id', 'desc')->limit(10)->get();
            return $a;
        }

        public static function getMinMaxPrice()
        {
            $min = FlightSeat::select(['price', 'flight_id'])->whereHas('flight', function (Builder $query) {
                $query->where('status', 'publish');
            })->min('price');
            $max = FlightSeat::select(['price', 'flight_id'])->whereHas('flight', function (Builder $query) {
                $query->where('status', 'publish');
            })->max('price');
            return [
                $min ?? 0,
                $max ?? 0
            ];
        }

        public function getReviewEnable()
        {
            return setting_item("flight_enable_review", 0);
        }

        public function getReviewApproved()
        {
            return setting_item("flight_review_approved", 0);
        }

        public function review_after_booking(){
            return setting_item("flight_enable_review_after_booking", 0);
        }

        public function count_remain_review()
        {
            $status_making_completed_booking = [];
            $options = setting_item("flight_allow_review_after_making_completed_booking", false);
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
            if (!empty($list = setting_item("flight_review_stats", []))) {
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
                if (!empty($number = $list_data_rate['rate_'.$rate])) {
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
         * Using for loop Flight
         */
        public function getScoreReview()
        {
            $flight_id = $this->id;
            $list_score = Cache::rememberForever('review_'.$this->type.'_'.$flight_id, function () use ($flight_id) {
                $dataReview = $this->reviewClass::selectRaw(" AVG(rate_number) as score_total , COUNT(id) as total_review ")->where('object_id', $flight_id)->where('object_model', "Flight")->where("status", "approved")->first();
                $score_total = !empty($dataReview->score_total) ? number_format($dataReview->score_total, 1) : 0;
                return [
                    'score_total'  => $score_total,
                    'total_review' => !empty($dataReview->total_review) ? $dataReview->total_review : 0,
                ];
            });
            $list_score['review_text'] = $list_score['score_total'] ? Review::getDisplayTextScoreByLever(round($list_score['score_total'])) : __("Not rated");
            return $list_score;
        }

        public function getNumberReviewsInService($status = false)
        {
            return $this->reviewClass::countReviewByServiceID($this->id, false, $status, $this->type) ?? 0;
        }

        public function getReviewList()
        {
            return $this->reviewClass::select(['id', 'title', 'content', 'rate_number', 'author_ip', 'status', 'created_at', 'vendor_id', 'author_id'])->where('object_id', $this->id)->where('object_model', 'Flight')->where("status", "approved")->orderBy("id", "desc")->with('author')->paginate(setting_item('flight_review_number_per_page', 5));
        }

        public function getNumberServiceInLocation($location)
        {
            $number = 0;
            if (!empty($location)) {
                $number = parent::join('bravo_locations', function ($join) use ($location) {
                    $join->on('bravo_locations.id', '=', $this->table.'.location_id')->where('bravo_locations._lft', '>=', $location->_lft)->where('bravo_locations._rgt', '<=', $location->_rgt);
                })->where($this->table.".status", "publish")->with(['translation'])->count($this->table.".id");
            }
            if (empty($number)) {
                return false;
            }
            if ($number > 1) {
                return __(":number Flights", ['number' => $number]);
            }
            return __(":number Flight", ['number' => $number]);
        }

        /**
         * @param $from
         * @param $to
         * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
         */
        public function getBookingsInRange($from, $to)
        {

            $query = $this->bookingClass::query();
            $query->whereNotIn('status', ['draft']);
            $query->where('start_date', '<=', $to)->where('end_date', '>=', $from)->take(50);

            $query->where('object_id', $this->id);
            $query->where('object_model', $this->type);

            return $query->orderBy('id', 'asc')->get();

        }


        public function hasWishList()
        {
            return $this->hasOne($this->userWishListClass, 'object_id', 'id')->where('object_model', $this->type)->where('user_id', Auth::id() ?? 0);
        }

        public function isWishList()
        {
            if (Auth::check()) {
                if (!empty($this->hasWishList) and !empty($this->hasWishList->id)) {
                    return 'active';
                }
            }
            return '';
        }

        public static function getServiceIconFeatured()
        {
            return "icofont-ui-flight";
        }


        public static function isEnable()
        {
            return setting_item('flight_disable') == false;
        }

        public function isDepositEnable()
        {
            return (setting_item('flight_deposit_enable') and setting_item('flight_deposit_amount'));
        }

        public function getDepositAmount()
        {
            return setting_item('flight_deposit_amount');
        }

        public function getDepositType()
        {
            return setting_item('flight_deposit_type');
        }

        public function getDepositFomular()
        {
            return setting_item('flight_deposit_fomular', 'default');
        }

        public function detailBookingEachDate($booking)
        {
            $startDate = $booking->start_date;
            $endDate = $booking->end_date;
            $rowDates = json_decode($booking->getMeta('tmp_dates'));
            $allDates = [];
            $service = $booking->service;

            if ($this->getBookingType() == 'by_day') {
                $period = periodDate($startDate, $endDate);
            }
            if ($this->getBookingType() == 'by_night') {
                $period = periodDate($startDate, $endDate, false);
            }

            foreach ($period as $dt) {
                $price = (!empty($service->sale_price) and $service->sale_price > 0 and $service->sale_price < $service->price) ? $service->sale_price : $service->price;

                $startDate = clone $dt;

                $endDate = $dt->modify('+1 day');

                $date['price'] = $price;
                $date['price_html'] = format_money($price);

                $date['from'] = $startDate->getTimestamp();
                $date['from_html'] = $startDate->format('d/m/Y');

                $date['to'] = $endDate->getTimestamp();
                $date['to_html'] = $endDate->format('d/m/Y');

                $allDates[$startDate->format('d/m/Y')] = $date;
            }

            if (!empty($rowDates)) {
                foreach ($rowDates as $item => $row) {
                    $startDate = strtotime($item);
                    $endDate = strtotime($item." +1 day");
                    $price = $row->price;
                    $date['price'] = $price;
                    $date['price_html'] = format_money($price);
                    $date['from'] = $startDate;
                    $date['from_html'] = date('d/m/Y', $startDate);
                    $date['to'] = $endDate;
                    $date['to_html'] = date('d/m/Y', ($endDate));
                    $allDates[date('Y-m-d', $startDate)] = $date;
                }
            }
            return $allDates;
        }

        public static function isEnableEnquiry()
        {
            if (!empty(setting_item('booking_enquiry_for_Flight'))) {
                return true;
            }
            return false;
        }

        public static function isFormEnquiryAndBook()
        {
            $check = setting_item('booking_enquiry_for_Flight');
            if (!empty($check) and setting_item('booking_enquiry_type') == "booking_and_enquiry") {
                return true;
            }
            return false;
        }

        public static function getBookingEnquiryType()
        {
            $check = setting_item('booking_enquiry_for_Flight');
            if (!empty($check)) {
                if (setting_item('booking_enquiry_type') == "only_enquiry") {
                    return "enquiry";
                }
            }
            return "book";
        }

        public function search($request)
        {
            $orderBy = $request["orderby"] ?? "";
            $query = self::query()->select(['bravo_flight.*'])->where('status','publish');

//            if (!empty($request['start']) and !empty($request['end'])) {
//                $start = strtotime($request['start']) < time() ? time() : strtotime($request['start']);
//                $end = strtotime($request['end']) < time() ? time() : strtotime($request['end']);
//                $query->where('departure_time', '>=', date('Y-m-d H:i:s ', $start));
//                $query->Where('departure_time', '<=', date('Y-m-d H:i:s ', $end));
//            }

            if (!empty($price_range = $request['price_range'] ?? "")) {
                $pri_from = Currency::convertPriceToMain(explode(";", $price_range)[0]);
                $pri_to =  Currency::convertPriceToMain(explode(";", $price_range)[1]);
                $query->where('min_price','<=',$pri_to)->where('min_price','>=',$pri_from);

            }else{
                $query->whereHas('flightSeat');
            }
            if (!empty($request['from_where'])) {
                $query->whereHas('airportFrom', function (Builder $builder) use ($request) {
                    $builder->where('location_id', $request['from_where']);
                });
            }
            if (!empty($request['to_where'])) {
                $query->whereHas('airportTo', function (Builder $builder) use ($request) {
                    $builder->where('location_id', $request['to_where']);
                });
            }
            if (!empty($request['seat_type'])) {
                $argv = array_filter($request['seat_type'], function ($v) {
                    return $v != 0;
                });
                if (!empty($argv)) {
                    $query->whereHas('flightSeat', function (Builder $builder) use ($argv) {
                        foreach ($argv as $item => $value) {
                            $builder->orWhere(function (Builder $query) use ($value, $item) {
                                $query->where('seat_type', $item)->where('max_passengers', '>=', $value);
                            });
                        }
                    });
                }
            }

            if(!empty($request['attrs'])){
                $this->filterAttrs($query,$request['attrs'],'bravo_flight_term');
            }

            if(!empty($request['is_featured']))
            {
                $query->where($this->table.'.is_featured',1);
            }
            if (!empty($request['custom_ids'])) {
                $query->whereIn($this->table.".id", $request['custom_ids']);
            }

            if (!empty($request['custom_ids']) and !empty( $ids = array_filter($request['custom_ids']) )) {
                $query->whereIn($this->table.".id", $ids);
                $query->orderByRaw('FIELD (id, ' . implode(', ', $ids) . ') ASC');
            }

            switch ($orderBy) {
                case "price_low_high":
                    $query->orderBy($this->table.".min_price", "asc");
                    break;
                case "price_high_low":
                    $query->orderBy($this->table.".min_price", "desc");
                    break;
                default:
                    $query->orderBy($this->table.".id", "desc");
            }

            return $query->with(['flightSeat', 'airportFrom', 'airportTo', 'airline']);
        }


        public static function searchCustom(Request $request)
        {
            $model_Flight = parent::query()->select("bravo_flight.*");
            $model_Flight->where("bravo_flight.status", "publish");
            if (!empty($location_id = $request->query('location_id'))) {
                $location = Location::query()->where('id', $location_id)->where("status", "publish")->first();
                if (!empty($location)) {
                    $model_Flight->join('bravo_locations', function ($join) use ($location) {
                        $join->on('bravo_locations.id', '=', 'bravo_flight.location_id')
                            ->where('bravo_locations._lft', '>=', $location->_lft)
                            ->where('bravo_locations._rgt', '<=', $location->_rgt);
                    });
                }
            }
            if (!empty($price_range = $request->query('price_range'))) {
                $pri_from = explode(";", $price_range)[0];
                $pri_to = explode(";", $price_range)[1];
                $raw_sql_min_max = "( (IFNULL(bravo_flight.sale_price,0) > 0 and bravo_flight.sale_price >= ? ) OR (IFNULL(bravo_flight.sale_price,0) <= 0 and bravo_flight.price >= ? ) )
                            AND ( (IFNULL(bravo_flight.sale_price,0) > 0 and bravo_flight.sale_price <= ? ) OR (IFNULL(bravo_flight.sale_price,0) <= 0 and bravo_flight.price <= ? ) )";
                $model_Flight->WhereRaw($raw_sql_min_max, [$pri_from, $pri_from, $pri_to, $pri_to]);
            }

            $terms = $request->query('terms', []);
            if ($term_id = $request->query('term_id')) {
                $terms[] = $term_id;
            }

            if (is_array($terms) && !empty($terms)) {
                $terms = Arr::where($terms, function ($value, $key) {
                    return !is_null($value);
                });
                if (!empty($terms)) {
                    $model_Flight->join('bravo_flight_term as tt', 'tt.target_id', "bravo_flight.id")->whereIn('tt.term_id', $terms);

                }
            }

            $review_scores = $request->query('review_score');
            if (is_array($review_scores) && !empty($review_scores)) {
                $where_review_score = [];
                $params = [];
                foreach ($review_scores as $number) {
                    $where_review_score[] = " ( bravo_flight.review_score >= ? AND bravo_flight.review_score <= ? ) ";
                    $params[] = $number;
                    $params[] = $number.'.9';
                }
                $sql_where_review_score = " ( ".implode("OR", $where_review_score)." )  ";
                $model_Flight->WhereRaw($sql_where_review_score, $params);
            }
            if (!empty($lat = $request->query('map_lat')) and !empty($lgn = $request->query('map_lgn'))) {
                $model_Flight->orderByRaw("POW((bravo_flight.map_lng-?),2) + POW((bravo_flight.map_lat-?),2)", [$lgn, $lat]);
            }
            $orderby = $request->input("orderby");
            switch ($orderby) {
                case "price_low_high":
                    $raw_sql = "CASE WHEN IFNULL( bravo_flight.sale_price, 0 ) > 0 THEN bravo_flight.sale_price ELSE bravo_flight.price END AS tmp_min_price";
                    $model_Flight->selectRaw($raw_sql);
                    $model_Flight->orderBy("tmp_min_price", "asc");
                    break;
                case "price_high_low":
                    $raw_sql = "CASE WHEN IFNULL( bravo_flight.sale_price, 0 ) > 0 THEN bravo_flight.sale_price ELSE bravo_flight.price END AS tmp_min_price";
                    $model_Flight->selectRaw($raw_sql);
                    $model_Flight->orderBy("tmp_min_price", "desc");
                    break;
                case "rate_high_low":
                    $model_Flight->orderBy("review_score", "desc");
                    break;
                default:
                    $model_Flight->orderBy("id", "desc");
            }

            $model_Flight->groupBy("bravo_flight.id");

            $max_guests = (int) ($request->query('adults') + $request->query('children'));
            if ($max_guests) {
                $model_Flight->where('max_guests', '>=', $max_guests);
            }

            if (!empty($request->query('limit'))) {
                $limit = $request->query('limit');
            } else {
                $limit = !empty(setting_item("flight_page_limit_item")) ? setting_item("flight_page_limit_item") : 9;
            }
            return $model_Flight->with('flightSeat', 'airportFrom', 'airportTo', 'airline')->paginate($limit);
        }

        public function dataForApi($forSingle = false)
        {
            $airline = $this->airline;
            $airport_from = $this->airportFrom;
            $airport_to = $this->airportTo;
            $airline = $this->airline;
            $data = [
                'id'               => $this->id,
                'code'               => $this->code,
                'title'            => $this->title,
                'price'            => $this->price??$this->min_price,
                'sale_price'       => $this->sale_price,
                'discount_percent' => $this->discount_percent ?? null,
                'image'            => get_file_url($airline->image_id),
                'content'          => $this->content,
                'location'         => Location::selectRaw("id,name")->find($this->location_id) ?? null,
                'is_featured'      => $this->is_featured ?? null,
                'airport_form'=> $airport_from->only('id','name')??null,
                'airport_to'=> $airport_to->only('id','name')??null,
                'airline'=> $airline->only('id','name')??null,
                'departure_time'=> $this->departure_time,
                'arrival_time'=> $this->arrival_time,
                'duration'=> $this->duration,
                'terms'=>Terms::getTermsByIdForAPI($this->terms->pluck('term_id'))
            ];
            return $data;
        }

        static public function getClassAvailability()
        {
            return "";
        }

        static public function getFiltersSearch()
        {
            $min_max_price = self::getMinMaxPrice();
            return [
                [
                    "title"     => __("Filter Price"),
                    "field"     => "price_range",
                    "position"  => "1",
                    "min_price" => floor(Currency::convertPrice($min_max_price[0])),
                    "max_price" => ceil(Currency::convertPrice($min_max_price[1])),
                ],
                [
                    "title"    => __("Attributes"),
                    "field"    => "terms",
                    "position" => "3",
                    "data"     => Attributes::getAllAttributesForApi("flight")
                ]
            ];
        }

        static public function getFormSearch()
        {
            $search_fields = setting_item_array('flight_search_fields');
            $search_fields = array_values(\Illuminate\Support\Arr::sort($search_fields, function ($value) {
                return $value['position'] ?? 0;
            }));
            foreach ( $search_fields as &$item){
                if($item['field'] == 'seat_type'){
                    $item['seat_types'] = SeatType::selectRaw('id,name,code')->get()->toArray();
                }
                if($item['field'] == 'to_where'){
                    $item['rows'] = Location::selectRaw('id,name')->get()->toArray();
                }
            }
            return $search_fields;
        }

        public static function getBookingType()
        {
            return setting_item('flight_booking_type', 'by_day');
        }


//    new module flight
        public function airportFrom()
        {
            return $this->hasOne(Airport::class, 'id', 'airport_from')->withDefault();
        }

        public function airportTo()
        {
            return $this->hasOne(Airport::class, 'id', 'airport_to')->withDefault();
        }

        public function airline()
        {
            return $this->hasOne(Airline::class, 'id', 'airline_id')->withDefault();
        }

        public function flightSeat()
        {
            return $this->hasMany(FlightSeat::class, 'flight_id')->orderBy('price');
        }

        public function bookingPassengers()
        {
            return $this->hasMany(BookingPassengers::class, 'flight_id')->whereHas('booking', function (Builder $query) {
                $query->whereNotIn('status', Booking::$notAcceptedStatus);
            });
        }

        public function booking()
        {
            return $this->hasMany(Booking::class, 'flight_id');
        }
        public function getDurationAttribute(){

            if(!empty($this->arrival_time) and !empty($this->departure_time)){
                $interval = $this->arrival_time->diff($this->departure_time);
                return $interval->format('%h');
            }else{
                return 0;
            }

        }
        public function getCanBookAttribute()
        {
            $canBook = [];
            $bookingPassengers = $this->bookingPassengers->countBy('seat_type')->toArray();
            foreach ($this->flightSeat as &$value) {
                if (!empty($bookingPassengers[$value->seat_type])) {
                    $canBook[$value->seat_type] = $value->max_passengers - $bookingPassengers[$value->seat_type];
                }else{
                    $canBook[$value->seat_type]= $value->max_passengers;
                }
            }
            if (array_sum($canBook) > 0) {
                return true;
            } else {
                return false;
            }
            return true;

        }

    }
