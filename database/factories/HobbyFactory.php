<?php

namespace Database\Factories;

use App\Models\Hobby;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Hobby>
 */
class HobbyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_hobi' => fake()->word(),
            'user_id' => User::factory(),
        ];
    }
}