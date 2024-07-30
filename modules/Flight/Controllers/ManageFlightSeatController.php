<?php
namespace Modules\Flight\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\FlightSeat;
use Modules\Flight\Models\SeatType;
use Modules\FrontendController;

class ManageFlightSeatController extends FrontendController
{
    protected $flight;
    protected $currentFlight;
    /**
     * @var string
     */
    private $flightSeat;

    public function __construct()
    {
        parent::__construct();
        $this->flight = Flight::class;
        $this->flightSeat = FlightSeat::class;
    }

    protected function hasFlightPermission($flight_id = false){
        if(empty($flight_id)) return false;
        $flight = $this->flight::find($flight_id);
        if(empty($flight)) return false;
        if(!$this->hasPermission('flight_update') and $flight->author_id != Auth::id()){
            return false;
        }
        $this->currentFlight = $flight;
        return true;
    }
    public function index(Request $request,$flight_id)
    {
        $this->checkPermission('flight_view');

        if(!$this->hasFlightPermission($flight_id))
        {
            abort(403);
        }
        $query = $this->flightSeat::query() ;
        $query->orderBy('id', 'desc');
        if (!empty($flight_name = $request->input('s'))) {
            $query->where('title', 'LIKE', '%' . $flight_name . '%');
            $query->orderBy('title', 'asc');
        }
        $query->where('flight_id',$flight_id);
        $data = [
            'rows'               => $query->with(['author'])->paginate(20),
            'breadcrumbs'        => [
                [
                    'name' => __('Flights'),
                    'url'  => route('flight.vendor.index')
                ],
                [
                    'name' => __('Flight: :name',['name'=>$this->currentFlight->title]),
                    'url'  => route('flight.vendor.edit',[$this->currentFlight->id])
                ],
                [
                    'name'  => __('All Flight seats'),
                    'class' => 'active'
                ],
            ],
            'page_title'=>__("Flight seat Management"),
            'currentFlight'=>$this->currentFlight,
            'row'=> new $this->flightSeat(),
        ];
        return view('Flight::frontend.manageFlight.seat.index', $data);
    }

    public function create($flight_id)
    {
        $this->checkPermission('flight_update');

        if(!$this->hasFlightPermission($flight_id))
        {
            abort(403);
        }
        $row = new $this->flightSeat();
        $data = [
            'row'            => $row,
            'translation'    => $row,
            'seatType'=>SeatType::all(),
            'enable_multi_lang'=>true,
            'breadcrumbs'    => [
                [
                    'name' => __('Flights'),
                    'url'  => route('flight.vendor.index')
                ],
                [
                    'name' => __('Flight: :name',['name'=>$this->currentFlight->title]),
                    'url'  => route('flight.vendor.edit',[$this->currentFlight->id])
                ],
                [
                    'name' => __('All Flight seats'),
                    'url'  => route("flight.vendor.seat.index",['flight_id'=>$this->currentFlight->id])
                ],
                [
                    'name'  => __('Create'),
                    'class' => 'active'
                ],
            ],
            'page_title'         => __("Create Flight seat"),
            'currentFlight'=>$this->currentFlight
        ];
        return view('Flight::frontend.manageFlight.seat.detail', $data);
    }

    public function edit(Request $request, $flight_id,$id)
    {
        $this->checkPermission('flight_update');

        if(!$this->hasFlightPermission($flight_id))
        {
            abort(403);
        }

        $row = $this->flightSeat::find($id);
        if (empty($row) or $row->flight_id != $flight_id) {
            return redirect(route('flight.vendor.seat.index',['flight_id'=>$flight_id]));
        }


        $data = [
            'row'            => $row,
            'translation'    => $row,
            'seatType'=>SeatType::all(),
            'enable_multi_lang'=>false,
            'breadcrumbs'    => [
                [
                    'name' => __('Flights'),
                    'url'  => route('flight.vendor.index')
                ],
                [
                    'name' => __('Flight: :name',['name'=>$this->currentFlight->title]),
                    'url'  => route('flight.vendor.edit',[$this->currentFlight->id])
                ],
                [
                    'name' => __('All Flight seats'),
                    'url'  => route("flight.vendor.seat.index",['flight_id'=>$this->currentFlight->id])
                ],
                [
                    'name' => __('Edit  :name',['name'=>$row->title]),
                    'class' => 'active'
                ],
            ],
            'page_title'=>__("Edit: :name",['name'=>$row->title]),
            'currentFlight'=>$this->currentFlight
        ];
        return view('Flight::frontend.manageFlight.seat.detail', $data);
    }

    public function store( Request $request, $flight_id,$id ){

        if(!$this->hasFlightPermission($flight_id))
        {
            abort(403);
        }
        if($id>0){
            $this->checkPermission('flight_update');
            $row = $this->flightSeat::find($id);
            if (empty($row)) {
                return redirect(route('flight.vendor.index'));
            }
            if($row->flight_id != $flight_id)
            {
                return redirect(route('flight.vendor.seat.index'));
            }
        }else{
            $this->checkPermission('flight_create');
            $row = new $this->flightSeat();
            $row->author_id = Auth::id();
        }
        $validator = Validator::make($request->all(), [
            'seat_type'=>[
                'required',
                Rule::unique(FlightSeat::getTableName())->where(function ($query)use($flight_id){
                    return $query->where('flight_id',$flight_id);
                })->ignore($row)
            ],
            'price'=>'required',
            'max_passengers'=>'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['errors' => $validator->errors()]);
        }
        $dataKeys = [
            'seat_type','price','max_passengers','person','baggage_check_in','baggage_cabin'
        ];

        $row->fillByAttr($dataKeys,$request->input());

        if(!empty($id) and $id == "-1"){
            $row->flight_id = $flight_id;
        }

        $res = $row->save();

        if ($res) {
            if($id > 0 ){
                return redirect()->back()->with('success',  __('Flight seat updated') );
            }else{
                return redirect(route('flight.vendor.seat.edit',['flight_id'=>$flight_id,'id'=>$row->id]))->with('success', __('Flight seat created') );
            }
        }
    }


    public function delete($flight_id,$id )
    {
        $this->checkPermission('flight_delete');
        $user_id = Auth::id();
        $query = $this->flightSeat::where("flight_id", $flight_id)->where("id", $id)->first();
        if(!empty($query)){
            $query->delete();
        }
        return redirect()->back()->with('success', __('Delete room success!'));
    }

    public function bulkEdit(Request $request , $flight_id )
    {
        $ids = $request->input('ids');

        $this->checkPermission('flight_update');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('No items selected!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }
        switch ($action){
            case "delete":
                foreach ($ids as $id) {
                    $query = $this->flightSeat::where("id", $id);
                    $query->where("author_id", Auth::id());
                    $this->checkPermission('flight_delete');
                    $row  =  $query->first();
                    if(!empty($row)){
                        $row->delete();
                    }
                }
                return redirect()->back()->with('success', __('Deleted success!'));
                break;
            case "permanently_delete":
                foreach ($ids as $id) {
                    $query = $this->flightSeat::where("id", $id);
                    if (!$this->hasPermission('flight_manage_others')) {
                        $query->where("author_id", Auth::id());
                        $this->checkPermission('flight_delete');
                    }
                    $row  =  $query->first();
                    if($row){
                        $row->delete();
                    }
                }
                return redirect()->back()->with('success', __('Permanently delete success!'));
                break;

            default:
                // Change status
                foreach ($ids as $id) {
                    $query = $this->flightSeat::where("id", $id);
                    $query->where("author_id", Auth::id());
                    $this->checkPermission('flight_update');
                    $row = $query->first();
                    $row->status  = $action;
                    $row->save();
                }
                return redirect()->back()->with('success', __('Update success!'));
                break;
        }
    }
}
