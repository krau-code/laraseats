<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\Cinema;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'movie_id' => Movie::all()->random()->id,
            'cinema_id' => Cinema::all()->random()->id,
            'date' => $this->faker->date(),  
            'amount' => $this->faker->randomNumber(),  
            'seat_left' => $this->faker->randomNumber(),
        ];
    }
}
