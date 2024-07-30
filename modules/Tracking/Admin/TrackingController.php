<?php


namespace Modules\Tracking\Admin;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\Booking\Models\Service;
use Modules\Tracking\Models\TrackingDevice;
use Modules\Tracking\Models\TrackingEvent;
use Modules\Tracking\Models\TrackingGeoip;
use Modules\Tracking\Models\TrackingLog;
use Modules\Tracking\Models\TrackingUtm;

class TrackingController extends AdminController
{
    public function __construct()
    {
//        parent::__construct();
        $this->setActiveMenu(route('tracking.admin.index'));
    }

    public function index(Request  $request){

        $event = new TrackingEvent();
        $log = new TrackingLog();
        $utm = new TrackingUtm();
        $geoip = new TrackingGeoip();
        $device = new TrackingDevice();
        $service = new Service();

        $select = [$log->getTable().'.*'];
        $select = array_merge($this->getSelect($event,'event'),$select);
        $select = array_merge($this->getSelect($utm,'utm'),$select);
        $select = array_merge($this->getSelect($geoip,'geoip'),$select);
        $select = array_merge($this->getSelect($device,'device'),$select);

        $rows = TrackingLog::query()->select($select)
            ->join($event->getTable(),$event->getTable().'.id','=',$log->getTable().'.event_id')
            ->leftJoin($utm->getTable(),$utm->getTable().'.id','=',$log->getTable().'.utm_id')
            ->leftJoin($geoip->getTable(),$geoip->getTable().'.id','=',$log->getTable().'.geoip_id')
            ->leftJoin($device->getTable(),$device->getTable().'.id','=',$log->getTable().'.device_id');

        if($f = $request->query('object_model')){
            $rows->where($log->getTable().'.object_model',$f);
        }
        if($f = $request->query('object_id')){
            $rows->where($log->getTable().'.object_id',$f);
        }
        if($f = $request->query('event_name')){
            $rows->where($event->getTable().'.name',$f);
        }
        if($f = $request->query('event_sub')){
            $rows->where($log->getTable().'.event_sub_name',"like",'%'.$f.'%');
        }
        if($f = $request->query('vendor_id')){
            $rows->where($log->getTable().'.vendor_id',$f);
        }
        if($f = $request->query('start_date')){
            $rows->where($log->getTable().'.created_at','>=',$f);
        }
        if($f = $request->query('end_date')){
            $rows->where($log->getTable().'.created_at','<=',$f.' 23:59:59');
        }
        $rows->orderByDesc($log->getTable().'.id');
        $data = [
            'rows'=>$rows->paginate(50),
            'page_title'=>__("Tracking Report")
        ];

        return view('Tracking::admin.index',$data);
    }
    public function bulkEdit(Request $request){

        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids))
            return redirect()->back()->with('error', __('Select at leas 1 item!'));
        if (empty($action))
            return redirect()->back()->with('error', __('Select an Action!'));

        switch ($action){
            case "delete":
                TrackingLog::query()->whereIn('id',$ids)->delete();
                    return redirect()->back()->with('success', __('Deleted!'));
                break;
        }

        return redirect()->back()->with('success', __('Updated successfully!'));
    }

    public function getSelect(Model $model,$alias){
        $res = [
            $model->getTable().'.id as '.$alias.'_id'
        ];
        foreach ($model->getFillable() as $k){
            $res[] = $model->getTable().'.'.$k.' as '.$alias.'_'.$k;
        }
        return $res;
    }
}
