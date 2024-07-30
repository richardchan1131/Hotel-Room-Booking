<?php
namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Flight\Models\Airline;
use Modules\Flight\Models\Airport;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\FlightSeat;
use Modules\Flight\Models\FlightTerm;
use Modules\Flight\Models\SeatType;
use Modules\Media\Models\MediaFile;
use Modules\User\Models\Role;

class FlightSeeder extends Seeder
{
    public function run()
    {
        //        Flight
        DB::table('media_files')->insertGetId([
            'file_name'      => 'banner-flight',
            'file_path'      => 'demo/flight/banner-flight.jpg',
            'file_type'      => 'image/jpeg',
            'file_extension' => 'jpg'
        ]);
        DB::table('core_settings')->insert([
                [
                    'name'  => 'flight_page_search_title',
                    'val'   => 'Search for flight',
                    'group' => "flight",
                ],
                [
                    'name'  => 'flight_page_limit_item',
                    'val'   => 9,
                    'group' => "flight",
                ],
                [
                    'name'  => 'flight_page_search_banner',
                    'val'   => MediaFile::findMediaByName("banner-flight")->id,
                    'group' => "flight",
                ],
                [
                    'name'  => 'flight_layout_search',
                    'val'   => 'normal',
                    'group' => "flight",
                ],
                [
                    'name'  => 'flight_enable_review',
                    'val'   => '0',
                    'group' => "flight",
                ],
                [
                    'name'  => 'flight_review_approved',
                    'val'   => '0',
                    'group' => "flight",
                ],
                [
                    'name'  => 'flight_review_stats',
                    'val'   => '',
                    'group' => "flight",
                ],
                [
                    'name'  => 'flight_booking_buyer_fees',
                    'val'   => '',
                    'group' => "flight",
                ],
                [
                    'name'  => 'flight_map_search_fields',
                    'val'   => '',
                    'group' => 'flight'
                ],
                [
                    'name'  => 'flight_search_fields',
                    'val'   => '[{"title":"From where","title_ja":null,"title_egy":null,"field":"from_where","size":"3","position":"1"},{"title":"To where","title_ja":null,"title_egy":null,"field":"to_where","size":"3","position":"2"},{"title":"Depart","title_ja":null,"title_egy":null,"field":"date","size":"3","position":"3"},{"title":"Travelers","title_ja":null,"title_egy":null,"field":"seat_type","size":"3","position":"4"}]',
                    'group' => 'flight'
                ]
            ]);
        $argvPermission = [
            'flight_manage_others',
            'flight_view',
            'flight_create',
            'flight_update',
            'flight_delete',
            'flight_manage_attributes',
        ];
        $roleAdmin = Role::query()->where('name','administrator')->first();
        if($roleAdmin){
            $roleAdmin->givePermission($argvPermission);
        }
        //            Seat Type
        $argvSeatType = [
            'vip'        => 'Vip',
            'eco'        => 'Economy',
            'premium'    => 'Premium',
            'business'   => 'Business',
            'fist_class' => 'First Class',
        ];
        foreach ($argvSeatType as $item => $value) {
            $row = new SeatType([
                'name' => $value,
                'code' => $item
            ]);
            $row->save();
        }
        $argvAirLineImage = [
            'img1' => 'demo/flight/airline/img1.jpg',
            'img2' => 'demo/flight/airline/img2.jpg',
            'img3' => 'demo/flight/airline/img3.jpg',
        ];
        foreach ($argvAirLineImage as $item => $value) {
            DB::table('media_files')->insertGetId([
                'file_name'      => 'airline-' . $item,
                'file_path'      => $value,
                'file_type'      => 'image/jpeg',
                'file_extension' => 'jpg'
            ]);
        }
        $a = new \Modules\Core\Models\Attributes([
            'name'    => 'Flight Type',
            'service' => 'flight'
        ]);
        $a->save();
        $term_ids = [];
        foreach (
            [
                'Business',
                'First Class',
                'Economy',
                'Premium Economy'
            ] as $term
        ) {
            $t = new \Modules\Core\Models\Terms([
                'name'    => $term,
                'attr_id' => $a->id
            ]);
            $t->save();
            $term_ids[] = $t->id;
        }
        $a = new \Modules\Core\Models\Attributes([
            'name'    => 'Inflight Experience',
            'service' => 'flight'
        ]);
        $a->save();
        foreach (
            [
                'Inflight Dining',
                'Music',
                'Sky Shopping',
                'Seats & Cabin'
            ] as $term
        ) {
            $t = new \Modules\Core\Models\Terms([
                'name'    => $term,
                'attr_id' => $a->id
            ]);
            $t->save();
            $term_ids[] = $t->id;
        }
        Airline::factory()->count(60)->create();
        Airport::factory()->count(60)->create();
        Flight::factory()->count(60)->has(FlightSeat::factory()->count(3)->state(new Sequence(['seat_type' => 'vip'], ['seat_type' => 'eco'], ['seat_type' => 'premium'], ['seat_type' => 'business'], ['seat_type' => 'fist_class'])))->create();
        foreach (Flight::all() as $flight) {
            foreach ($term_ids as $k => $term_id) {
                if (rand(0, count($term_ids)) == $k)
                    continue;
                if (rand(0, count($term_ids)) == $k)
                    continue;
                if (rand(0, count($term_ids)) == $k)
                    continue;
                FlightTerm::firstOrCreate([
                    'term_id'   => $term_id,
                    'target_id' => $flight->id
                ]);
            }
        }
    }
}
