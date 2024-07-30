<?php

namespace Themes\Base\Core\Updaters;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Boat\Models\Boat;
use Modules\Booking\Models\Service;
use Modules\Event\Models\Event;
use Modules\Flight\Models\Flight;
use Modules\Hotel\Models\Hotel;
use Modules\Space\Models\Space;
use Modules\Tour\Models\Tour;
use Modules\User\Helpers\PermissionHelper;
use Modules\User\Models\Role;
use Modules\User\Models\User;

class Updater300
{

    public static function run(){
        $version = '1.4';
        if (version_compare(setting_item('update_to_300'), $version, '>=')) return;

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        $admin = Role::query()->where('name','administrator')->first();
        if($admin){
            $admin->givePermission(PermissionHelper::all());
        }
        static::initVendor();

        // Update User Roles
        if(Schema::hasTable('core_model_has_roles'))
        {
            $data = DB::table('core_model_has_roles')->get();
            foreach ($data as $item){
                if($item){
                    User::query()->where('id',$item->model_id)->whereNull('role_id')->update(['role_id'=>$item->role_id]);
                }
            }
        }

        // Update bc_services
        foreach ([Hotel::class,Tour::class,Space::class,Event::class,Boat::class,Flight::class] as $class){

            $tbName = (new $class)->getTable();
            $type = (new $class)->type;

            Service::query()->join($tbName,function($join) use ($tbName,$type){
                $join->on($tbName.'.id','=','bravo_services.object_id');
                $join->where('bravo_services.object_model','=',$type);
            })->update([
                'bravo_services.author_id'=>DB::raw($tbName.'.author_id')
            ]);
        }


        $tableAddAuthorId = [
            'bravo_hotels',
            'bravo_tours',
            'bravo_events',
            'bravo_spaces',
            'bravo_cars',
            'bravo_boats',
            'bravo_flight',
            'bravo_airline',
            'bravo_airport',
            'bravo_flight_seat',
            'bravo_seat_type',
            'media_files',
            'bravo_review',
            'core_news',
            'core_pages',
            'bravo_services',
        ];
        foreach ($tableAddAuthorId as $tbName){
            \Illuminate\Support\Facades\DB::update("update {$tbName} set author_id = create_user where author_id is null");
        }

        //-----------------------------------------------------------------------

        $tableAddUserId = [
            'bravo_user_plan',
            'bravo_booking_payments'
        ];
        foreach ($tableAddUserId as $tbName){
            \Illuminate\Support\Facades\DB::update("update {$tbName} set user_id = create_user where user_id is null");
        }


        Artisan::call('cache:clear');

        setting_update_item('update_to_300',$version);
    }

    public static function initVendor(){
        $vendor = Role::query()->where('name','vendor')->first();
        if(!$vendor){
            return;
        }

        $vendor->givePermission('media_upload');
        $vendor->givePermission('tour_view');
        $vendor->givePermission('tour_create');
        $vendor->givePermission('tour_update');
        $vendor->givePermission('tour_delete');
        $vendor->givePermission('dashboard_vendor_access');

        $vendor->givePermission('space_view');
        $vendor->givePermission('space_create');
        $vendor->givePermission('space_update');
        $vendor->givePermission('space_delete');

        $vendor->givePermission('hotel_view');
        $vendor->givePermission('hotel_create');
        $vendor->givePermission('hotel_update');
        $vendor->givePermission('hotel_delete');

        $vendor->givePermission('car_view');
        $vendor->givePermission('car_create');
        $vendor->givePermission('car_update');
        $vendor->givePermission('car_delete');

        $vendor->givePermission('event_view');
        $vendor->givePermission('event_create');
        $vendor->givePermission('event_update');
        $vendor->givePermission('event_delete');

        $vendor->givePermission('news_view');
        $vendor->givePermission('news_create');
        $vendor->givePermission('news_update');
        $vendor->givePermission('news_delete');

        $vendor->givePermission([
            'boat_view',
            'boat_create',
            'boat_update',
            'boat_delete',
            'boat_manage_others',
            'boat_manage_attributes',
            'flight_view',
            'flight_create',
            'flight_update',
            'flight_delete',
        ]);
    }
}
