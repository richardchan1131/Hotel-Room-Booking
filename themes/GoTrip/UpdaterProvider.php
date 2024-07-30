<?php
namespace Themes\GoTrip;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class UpdaterProvider extends ServiceProvider
{

    public function boot(){
        if (file_exists(storage_path().'/installed') and !app()->runningInConsole()) {
            $this->runUpdateTo100();
            $this->runUpdateTo120();
        }
    }

    public function runUpdateTo100(){
        $version = '1.0.0';
        if (version_compare(setting_item('GoTrip_update_to_100'), $version, '>=')) return;
        Schema::table('bravo_locations', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_locations', 'general_info')) {
                $table->text('general_info')->nullable();
            }
        });
        Schema::table('bravo_location_translations', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_location_translations', 'general_info')) {
                $table->text('general_info')->nullable();
            }
        });
        Artisan::call('migrate', [
            '--force' => true,
        ]);
        setting_update_item('GoTrip_update_to_100',$version);
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
    }
    public function runUpdateTo120(){
        $version = '1.0.0';
        if (version_compare(setting_item('GoTrip_update_to_120'), $version, '>=')) return;
        Artisan::call('migrate', [
            '--force' => true,
        ]);
        setting_update_item('GoTrip_update_to_120',$version);
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
    }
}
