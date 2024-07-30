<?php

namespace Themes\Base\Core\Updaters;

use Illuminate\Support\Facades\Artisan;
use Modules\User\Helpers\PermissionHelper;
use Modules\User\Models\Role;

class Updater310
{

    public static function run(){
        $version = '1.1';
        if (version_compare(setting_item('update_to_310'), $version, '>=')) return;

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        $admin = Role::query()->where('name','administrator')->first();
        if($admin){
            $admin->givePermission(PermissionHelper::all());
        }

        Artisan::call('cache:clear');

        setting_update_item('update_to_310',$version);
    }
}
