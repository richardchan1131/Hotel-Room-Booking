<?php

namespace Custom\Hotel\Controllers;

use Custom\Hotel\Models\OlteanuHotelChild;
use Custom\Hotel\Models\OlteanuHotelRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\FrontendController;
use Modules\Core\Models\Attributes;
use Modules\Hotel\Controllers\VendorRoomController as ControllersVendorRoomController;
use Modules\Hotel\Models\HotelRoom;
use Modules\Hotel\Models\HotelRoomTerm;
use Modules\Hotel\Models\HotelRoomTranslation;
use Modules\Location\Models\Location;
use Modules\Hotel\Models\Hotel;
use Modules\Hotel\Models\HotelTerm;
use Modules\Hotel\Models\HotelTranslation;

class VendorRoomController extends ControllersVendorRoomController
{
    protected $hotelClass;
    protected $roomTermClass;
    protected $attributesClass;
    protected $locationClass;
    /**
     * @var HotelRoom
     */
    protected $roomClass;
    protected $currentHotel;
    protected $roomTranslationClass;

    public function __construct()
    {
        parent::__construct();
        $this->hotelClass = Hotel::class;
        $this->roomTermClass = HotelRoomTerm::class;
        $this->attributesClass = Attributes::class;
        $this->locationClass = Location::class;
        $this->roomClass = HotelRoom::class;
        $this->roomTranslationClass = HotelRoomTranslation::class;
    }

    protected function hasHotelPermission($hotel_id = false)
    {
        if (empty($hotel_id)) return false;
        $hotel = $this->hotelClass::find($hotel_id);
        if (empty($hotel)) return false;
        if (!$this->hasPermission('hotel_update') and $hotel->author_id != Auth::id()) {
            return false;
        }
        $this->currentHotel = $hotel;
        return true;
    }
    
    public function store(Request $request, $hotel_id, $id)
    {
        if (is_demo_mode()) {
            return redirect()->back()->with('danger', __("DEMO MODE: can not add data"));
        }
        if (!$this->hasHotelPermission($hotel_id)) {
            abort(403);
        }
        if ($id > 0) {
            $this->checkPermission('hotel_update');
            $row = $this->roomClass::find($id);
            if (empty($row)) {
                return redirect(route('hotel.vendor.index'));
            }
            if ($row->parent_id != $hotel_id) {
                return redirect(route('hotel.vendor.room.index'));
            }
        } else {
            $this->checkPermission('hotel_create');
            $row = new $this->roomClass();
            $row->status = "publish";
        }


        OlteanuHotelRoom::updateOrCreate([
            'bravo_hotel_room_id' => $id,
        ],
        [
            'sofa' => $request->sofa,
            'single_bed' => $request->single_bed,
            'double_bed' => $request->double_bed,
            'additional_bed_active' => $request->suplimentary_bed ?? false,
            'additional_bed_price' => $request->supplimentary_bed_price,
            'breakfast_active' => $request->breakfast_active ?? false,
            'breakfast_price' => $request->breakfast_price,
            'demipension_active' => $request->demipension_active ?? false,
            'demipension_price' => $request->demipension_price,
            'allinclusive_active' => $request->allinclusive_active ?? false,
            'allinclusive_price' => $request->allinclusive_price,
            'freecancelation_active' => $request->freecancelation_active ?? false,
            'freecancelation_price'=> $request->freecancelation_price,
        ]);

        OlteanuHotelChild::where('bravo_hotel_room_id', $id)->delete();

        foreach($request->kid_price as $key => $price)
        {
            if(!is_null($price))
            OlteanuHotelChild::create([
                'bravo_hotel_room_id' => $id,
                'price' => $price,
                'minimum_age' => $request->kid_age_minimum[$key],
                'maximum_age' => $request->kid_age_maximum[$key]
            ]);
        }

        $dataKeys = [
            'title',
            'content',
            'image_id',
            'gallery',
            'price',
            'number',
            'beds',
            'size',
            'adults',
            'children',
            'min_day_stays',
        ];

        $row->fillByAttr($dataKeys, $request->input());
        $row->ical_import_url  = $request->ical_import_url;

        if (!empty($id) and $id == "-1") {
            $row->parent_id = $hotel_id;
        }

        $res = $row->saveOriginOrTranslation($request->input('lang'), true);

        if ($res) {
            if (!$request->input('lang') or is_default_lang($request->input('lang'))) {
                $this->saveTerms($row, $request);
            }

            if ($id > 0) {
                return redirect()->back()->with('success',  __('Room updated'));
            } else {
                return redirect(route('hotel.vendor.room.edit', ['hotel_id' => $hotel_id, 'id' => $row->id]))->with('success', __('Room created'));
            }
        }
    }
}
