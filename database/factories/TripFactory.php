<?php

namespace Database\Factories;

use App\Models\Bus;
use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bus_id' =>  $this->faker->unique()->randomElement(Bus::pluck('id')),
            'start_station_id' =>  $this->faker->randomElement(Station::pluck('id')),
            'end_station_id' =>  $this->faker->randomElement(Station::pluck('id')),
        ];
    }
}
