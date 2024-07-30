<?php

namespace Modules\Vendor\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Booking\Events\EnquiryReplyCreated;
use Modules\Booking\Models\Enquiry;
use Modules\Booking\Models\EnquiryReply;
use Modules\FrontendController;

class EnquiryController extends FrontendController
{
    public $enquiryClass;

    public function __construct(Enquiry $enquiryClass)
    {
        parent::__construct();
        $this->enquiryClass = $enquiryClass;
    }

    public function enquiryReport(Request $request){
        $this->checkPermission('enquiry_view');
        $user_id = Auth::id();
        $rows = $this->enquiryClass::where("vendor_id",$user_id)
            ->whereIn('object_model',array_keys(get_bookable_services()))
            ->orderBy('id', 'desc');
        $data = [
            'rows'        => $rows->withCount(['replies'])->paginate(5),
            'statues'     => $this->enquiryClass::$enquiryStatus,
            'has_permission_enquiry_update' => $this->hasPermission('enquiry_update'),
            'breadcrumbs' => [
                [
                    'name'  => __('Enquiry Report'),
                    'class' => 'active'
                ],
            ],
            'page_title'  => __("Enquiry Report"),
        ];
        return view('Vendor::frontend.enquiry.index', $data);
    }

    public function enquiryReportBulkEdit($enquiry_id, Request $request)
    {
        $status = $request->input('status');
        if (!empty( $this->hasPermission('enquiry_update') ) and !empty($status) and !empty($enquiry_id)) {
            $query = $this->enquiryClass::where("id", $enquiry_id);
            $query->where("vendor_id", Auth::id());
            $item = $query->first();
            if (!empty($item)) {
                $item->status = $status;
                $item->save();
                return redirect()->back()->with('success', __('Update success'));
            }
            return redirect()->back()->with('error', __('Enquiry not found!'));
        }
        return redirect()->back()->with('error', __('Update fail!'));
    }

    public function reply(Enquiry $enquiry,Request  $request){

        if($enquiry->vendor_id != \auth()->id()){
            abort(404);
        }
        $this->checkPermission('enquiry_view');

        $data = [
            'rows'=>$enquiry->replies()->orderByDesc('id')->paginate(20),

            'breadcrumbs' => [
                [
                    'name' => __('Enquiry'),
                    'url'  => route('vendor.enquiry_report')
                ],
                [
                    'name'  => __('Enquiry :name',['name'=>'#'.$enquiry->id.' - '.($enquiry->service->title ?? '')]),
                    'url'=>'#'
                ],
                [
                    'name'  => __('All Replies'),
                    'class' => 'active'
                ],
            ],
            'page_title'=>__("Replies"),
            'enquiry'=>$enquiry
        ];

        return view("Vendor::frontend.enquiry.reply",$data);
    }

    public function replyStore(Enquiry $enquiry,Request  $request){
        if($enquiry->vendor_id != \auth()->id()){
            abort(404);
        }

        $this->checkPermission('enquiry_view');

        $request->validate([
            'content'=>'required'
        ]);

        $reply = new EnquiryReply();
        $reply->content = $request->input('content');
        $reply->parent_id = $enquiry->id;
        $reply->user_id = auth()->id();

        $reply->save();

        EnquiryReplyCreated::dispatch($reply,$enquiry);

        return back()->with('success',__("Reply added"));
    }

    public function delete($enquiry_id, Request $request)
    {
        $this->checkPermission('enquiry_update');
        $user_id = Auth::id();
        $query = $this->enquiryClass::where("vendor_id", $user_id)->where("id", $enquiry_id)->first();
        if (!empty($query)) {
            $query->delete();
            return back()->with('success',__("Delete success!"));
        }
        return back()->with('error',__("Enquiry not found!"));
    }
}
