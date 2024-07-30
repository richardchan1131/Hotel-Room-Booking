<?php
namespace Themes\GoTrip\Database\Seeders;
use Database\Seeders\BoatSeeder;
use Database\Seeders\EventSeeder;
use Database\Seeders\FlightSeeder;
use Database\Seeders\HotelSeeder;
use Database\Seeders\Language;
use Database\Seeders\News;
use Database\Seeders\Tour;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\MediaFileSeeder;
use Database\Seeders\CarSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SocialSeeder;
use Database\Seeders\SpaceSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeederForReImport extends Seeder
{
    public function run(){

        Artisan::call('cache:clear');
        $this->call(MediaFileSeeder::class);
        $this->call(General::class);
        $this->call(\Themes\GoTrip\Database\Seeders\News::class);
        $this->call(\Themes\GoTrip\Database\Seeders\Tour::class);
        $this->call(\Themes\GoTrip\Database\Seeders\SpaceSeeder::class);
        $this->call(\Themes\GoTrip\Database\Seeders\HotelSeeder::class);
        $this->call(CarSeeder::class);
        $this->call(\Themes\GoTrip\Database\Seeders\EventSeeder::class);
        $this->call(SocialSeeder::class);
        $this->call(FlightSeeder::class);
        $this->call(BoatSeeder::class);

        $this->call(\Themes\GoTrip\Database\Seeders\CarSeeder::class);
    }
}
