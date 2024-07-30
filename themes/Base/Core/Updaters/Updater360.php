<?php

namespace Themes\Base\Core\Updaters;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Modules\User\Helpers\PermissionHelper;
use Modules\User\Models\Role;

class Updater360
{

    public static function run()
    {
        $version = '1.4';
        if (version_compare(setting_item('update_to_360'), $version, '>=')) return;

        Schema::table('bravo_coupons', function (Blueprint $table) {
            if(!Schema::hasColumn('bravo_coupons','author_id')){
                $table->bigInteger('author_id')->nullable();
            }
            if(!Schema::hasColumn('bravo_coupons','is_vendor')){
                $table->smallInteger('is_vendor')->nullable();
            }
        });

        $vendor = Role::firstOrCreate(['name'=>'vendor','code'=>'vendor']);

        $vendor->givePermission('coupon_view');
        $vendor->givePermission('coupon_create');
        $vendor->givePermission('coupon_update');
        $vendor->givePermission('coupon_delete');

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        // Run Update
        Artisan::call('cache:clear');

        setting_update_item('update_to_360', $version);
    }
}
