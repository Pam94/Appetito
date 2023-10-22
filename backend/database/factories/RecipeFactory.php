<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 * <\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'time' => fake()->numberBetween(10, 60),
            'portions' => fake()->numberBetween(1,4),
            'instructions' => fake()->text(),
            'favorite' => fake()->boolean(),
            'url' => fake()->url(),
            'user_id' => User::factory()

        ];
    }
}
