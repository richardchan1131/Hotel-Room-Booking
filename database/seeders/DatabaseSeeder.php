<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Modules\Theme\ThemeManager;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $active_theme = ThemeManager::current();
        $theme_seeder = '\\Themes\\'.ucfirst($active_theme)."\\Database\\Seeders\\DatabaseSeeder";
        if(class_exists($theme_seeder)){
            $this->call($theme_seeder);
            return;
        }

        Artisan::call('cache:clear');
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(Language::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MediaFileSeeder::class);
        $this->call(General::class);
        $this->call(LocationSeeder::class);
        $this->call(News::class);
        $this->call(Tour::class);
        $this->call(SpaceSeeder::class);
        $this->call(HotelSeeder::class);
        $this->call(CarSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(SocialSeeder::class);
        $this->call(DemoSeeder::class);
        $this->call(FlightSeeder::class);
        $this->call(BoatSeeder::class);
    }
}
