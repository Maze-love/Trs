<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Manager;
use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>fake()->company(),
            'user_id'=>User::factory(),
            'destination_id'=>Destination::factory(),
            'contact_info'=>fake()->word(),
            'description'=>fake()->sentence(),
            'ratings'=>fake()->numberBetween(0,5)
        ];
    }
}
