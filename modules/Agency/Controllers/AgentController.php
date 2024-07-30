<?php

namespace Modules\Agency\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use \Themes\Findhouse\User\Models\User;
use Modules\Agency\Models\BravoContactObject;
use Modules\Property\Models\Property;
use Modules\Review\Models\Review;
use Illuminate\Support\Facades\Mail;
use Matrix\Exception;
use Modules\Agency\Emails\AgentNotificationToAdmin;
use Modules\Location\Models\Location;
use Modules\Property\Models\PropertyCategory;

class AgentController extends Controller
{
    protected $userClass;
    protected $propertyClass;
    protected $locationClass;
    protected $propertyCategoryClass;

    public function __construct()
    {
        $this->userClass = new User();
        $this->propertyClass = new Property();
        $this->locationClass         = Location::class;
        $this->propertyCategoryClass = PropertyCategory::class;
    }

    public function index(Request $request) {
        $data = [];
        $category_id = $request->query("category_id");
        $location_id = $request->query("location_id");
        $name        = $request->query("name");
        $order       = $request->query("filter");
        $object = User::query()->where('role_id',2)->with(['property' => function($q) use($category_id, $location_id){
            if(!empty($category_id))
                $q->where('category_id', '=', $category_id);
            if(!empty($location_id))
                $q->where('location_id', '=', $location_id);
        }]);
        if(!empty($name))
            $object->where('name','like','%'.$name.'%');
        switch($order) {
            case 'a-z' :
                $object = $object->orderBy("last_name", "desc");
            default:
                $object = $object->orderBy("last_name", "asc");
        }
        $count = $object->count();
        $object = $object->paginate(6);
        $data['rows'] = $object;
        if( empty(setting_item("property_location_search_style")) or setting_item("property_location_search_style") == "normal" ){
            $limit_location = 1000;
        }
        $data['list_location']   = $this->locationClass::where('status', 'publish')->with(['translation'])->get()->toTree();
        $data['list_category']   = $this->propertyCategoryClass::where('status', 'publish')->get()->toTree();
        $data['order']           = $order;
        $data['count']           = $count;
        $data['page_title'] = __("Find Agents");
        return view('Agency::frontend.agent.list', $data);
    }

    public function detail($id) {
        $row = $this->userClass::where('id', '=', $id)->first();
        if(!$row) {
            abort(404);
        }
        $userProperties = $row->property;

        if ($userProperties) {
            foreach ($userProperties as $property) {
                $property['nameCategory'] = PropertyCategory::select('name')->where('id', '=', $property->category_id)->first()['name'];
            }
        }
        $review_list = Review::where('object_id', $row->id)
                ->where('object_model', 'agent')
                ->where("status", "approved")
                ->orderBy("id", "desc")
                ->with('author')
                ->paginate(setting_item('agent_review_number_per_page', 5));
        $data = [
            'row' => $row,
            'userProperties' => $userProperties,
            'review_list' => $review_list,
            'page_title'=>$row->getDisplayName()
        ];
        return view('Agency::frontend.agent.detail', $data);
    }


    public function submitDetailContact(Request $request)
    {
        $request->validate([
            'email'   => [
                'required',
                'max:255',
                'email'
            ],
            'name'    => ['required'],
            'phone'   => ['required', 'numeric'],
            'message' => ['required']
        ]);
        $row = new BravoContactObject($request->input());
        $row->status = 'sent';
        if ($row->save()) {
            $this->sendEmail($row);
            $data = [
                'status'    => 1,
                'message'    => __('Thank you for contacting us! We will get back to you soon'),
            ];
            return response()->json($data, 200);
        }
    }

    protected function sendEmail($contact){
        if($admin_email = setting_item('admin_email')){
            try {
                Mail::to($admin_email)->send(new AgentNotificationToAdmin($contact));
            }catch (Exception $exception){
                Log::warning("Contact Send Mail: ".$exception->getMessage());
            }
        }
    }

}
