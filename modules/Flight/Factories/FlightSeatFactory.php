<?php

namespace Modules\Flight\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\FlightSeat;
use Modules\Flight\Models\SeatType;

class FlightSeatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FlightSeat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    private $seatType = 0;
    public function definition()
    {
        $persons=['adult','child'];
        return [
            'seat_type'=>"",
            'flight_id'=>"",
            'price'=>$this->faker->numberBetween(10,99),
            'max_passengers'=>$this->faker->numberBetween(1,20),
            'person'=>$this->faker->randomElement($persons),
            'baggage_check_in'=>$this->faker->numberBetween(10,15),
            'baggage_cabin'=>$this->faker->numberBetween(3,7),
        ];
    }
}
