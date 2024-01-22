<?php

namespace Database\Factories;

use Dotenv\Util\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'nom' => $this->faker->unique()->word,
                // 'nom' => fake()->name(),
                // 'nom' => fake()->randomElement(['AdminSystem', 'Restaurant', 'Client'] ) ,
                // 'nom' => 'Restaurant',
                // 'nom' => 'Client',
    
                // 'remember_token' => Str::random(10),
            ];
    }
}
