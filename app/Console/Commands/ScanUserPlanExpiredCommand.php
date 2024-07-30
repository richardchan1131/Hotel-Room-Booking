<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Modules\Booking\Models\Service;
use Modules\User\Models\UserPlan;

class ScanUserPlanExpiredCommand extends Command
{
    protected $signature = 'user_plan:expired';

    protected $description = 'Command description';

    public function handle()
    {
        $userActivePlans = UserPlan::selectRaw('* , sum(max_service) as max_service_active , max(end_date) as end_date_expired')
            ->where('status', 1)
            ->where('end_date', '>=', now())
            ->groupBy('user_id')->get();

        if (!empty($userActivePlans)) {
            foreach ($userActivePlans as $userPlan) {
                $serviceActive = Service::where('status', 'publish')
                    ->where('author_id', $userPlan->user_id)
                    ->orderBy('created_at','asc')
                    ->with('service')
                    ->get();
                $totalServiceActive = $serviceActive->count();
                $number = (int)$totalServiceActive - (int)$userPlan->max_service_active;
                if (!empty($number)) {
                    $this->deactivateService($serviceActive, $number);
                }
            }
        }
        else {
            $users = UserPlan::selectRaw("user_id")->groupBy('user_id')->get()->pluck('user_id')->toArray();
            if(!empty($users)) {
                $serviceActive = Service::where('status', 'publish')
                    ->whereIn('author_id', $users)
                    ->orderBy('created_at')
                    ->with('service')
                    ->get();
                $number = $serviceActive->count();
                if (!empty($number)) {
                    $this->deactivateService($serviceActive, $number);
                }
            }else{
                $this->info('No vendor!');
            }
        }
        $this->info('Scan user plan expired completed successfully');


    }

    public function deactivateService($services, $limit)
    {
        $services = $services->take($limit);

        $objectService = $services->mapToGroups(function($item){
            return [$item->object_model=>$item->object_id];;
        });

        $all = get_bookable_services();
        foreach ($objectService as $objectType => $object){
            if(!empty($all[$objectType])){
               $a =  $all[$objectType]::whereIn('id', $object)->update(['status'=> 'draft']);
            }
        }

        foreach ($services->all() as $service) {
            $service->status = 'draft';
            $service->save();
        }

    }
}
