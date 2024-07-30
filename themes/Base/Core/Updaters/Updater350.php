<?php

namespace Themes\Base\Core\Updaters;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Modules\User\Helpers\PermissionHelper;
use Modules\User\Models\Role;

class Updater350
{

    public static function run(){
        $version = '1.1';
        if (version_compare(setting_item('update_to_350'), $version, '>=')) return;

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        // Run Update

        Artisan::call('cache:clear');

        setting_update_item('update_to_350',$version);
    }
}
