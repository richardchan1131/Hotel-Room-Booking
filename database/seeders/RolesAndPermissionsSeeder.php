<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Modules\User\Helpers\PermissionHelper;
use Modules\User\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::firstOrCreate([
            'code'=>'administrator',
            'name'=>'administrator'
        ]);

        $admin->givePermission(PermissionHelper::all());


        // this can be done as separate statements
        $this->initVendor();

        // this can be done as separate statements
        $customer = Role::firstOrCreate(['name'=>'customer','code'=>'customer']);
    }

    public function initVendor(){

        $vendor = Role::firstOrCreate(['name'=>'vendor','code'=>'vendor']);

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
    }
}
