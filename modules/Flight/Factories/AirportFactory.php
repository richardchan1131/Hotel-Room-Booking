<?php

namespace Modules\Flight\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Modules\Flight\Models\Airline;
use Modules\Flight\Models\Airport;
use Modules\Location\Models\Location;

class AirportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Airport::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $locations = Location::pluck('id')->toArray();

        return [
            'name'=>$this->faker->city,
            'code'=>$this->faker->unique()->randomNumber(3),
            'location_id'=>$this->faker->randomElement($locations),
            'description'=>$this->faker->text,
            'address'=>$this->faker->address,
            'map_lat'=>$this->faker->latitude,
            'map_lng'=>$this->faker->longitude,
            'map_zoom'=>$this->faker->numberBetween(8,10),
        ];
    }
}
