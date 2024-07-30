<?php
namespace Themes\GoTrip;

use Illuminate\Contracts\Http\Kernel;
use Themes\GoTrip\Database\Seeders\DatabaseSeeder;
use Themes\GoTrip\Database\Seeders\DatabaseSeederForReImport;


class ThemeProvider extends \Themes\Base\ThemeProvider
{
    public static $version = '1.5.0';
    public static $name = 'Go Trip';
    public static $parent = 'base';

    public static $seeder = DatabaseSeeder::class;

    public static $seederForReImport = DatabaseSeederForReImport::class;

    public static function info()
    {
        // TODO: Implement info() method.
    }

    public function boot(Kernel $kernel)
    {
        parent::boot($kernel);
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }

    public function register()
    {
        parent::register();
        $this->app->register(\Themes\GoTrip\User\ModuleProvider::class);
        $this->app->register(\Themes\GoTrip\Boat\ModuleProvider::class);
        $this->app->register(\Themes\GoTrip\Page\ModuleProvider::class);
        $this->app->register(\Themes\GoTrip\Location\ModuleProvider::class);
        $this->app->register(\Themes\GoTrip\Hotel\ModuleProvider::class);
        $this->app->register(\Themes\GoTrip\News\ModuleProvider::class);
        $this->app->register(\Themes\GoTrip\Template\ModuleProvider::class);
        $this->app->register(\Themes\GoTrip\Tour\ModuleProvider::class);
        $this->app->register(\Themes\GoTrip\Car\ModuleProvider::class);
        $this->app->register(\Themes\GoTrip\Contact\ModuleProvider::class);
        $this->app->register(\Themes\GoTrip\Space\ModuleProvider::class);
        $this->app->register(\Themes\GoTrip\Core\ModuleProvider::class);
        $this->app->register(\Themes\GoTrip\Vendor\ModuleProvider::class);
        $this->app->register(\Themes\GoTrip\Event\ModuleProvider::class);
        $this->app->register(\Themes\GoTrip\Flight\ModuleProvider::class);
        $this->app->register(UpdaterProvider::class);
    }

}
