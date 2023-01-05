<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(5),  
            'rating' => $this->faker->word(),  
            'genre' => 'horror, fantasy, action',
            'hour' => $this->faker->randomDigit(),  
            'minute' => $this->faker->randomDigit(),  
            'showing_date' => $this->faker->date(),  
            'end_date' => $this->faker->date(),    
        ];
    }
}
