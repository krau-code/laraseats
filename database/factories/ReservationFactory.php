<?php

namespace Database\Factories;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'schedule_id' => Schedule::all()->random()->id,
            'name' => $this->faker->name(), 
            'email' => $this->faker->unique()->safeEmail(),  
            'quantity' => $this->faker->randomDigit(),  
            'total_amount' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
