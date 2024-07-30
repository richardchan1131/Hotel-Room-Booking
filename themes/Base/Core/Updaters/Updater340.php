<?php

namespace Themes\Base\Core\Updaters;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Modules\User\Helpers\PermissionHelper;
use Modules\User\Models\Role;

class Updater340
{

    public static function run(){
        $version = '1.0';
        if (version_compare(setting_item('update_to_340'), $version, '>=')) return;

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        Schema::table('bravo_contact', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_contact', 'phone')) {
                $table->string('phone')->nullable();
            }
        });

        Artisan::call('cache:clear');

        setting_update_item('update_to_340',$version);
    }
}
