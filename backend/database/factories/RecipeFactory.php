<?php

namespace Database\Factories;

use App\Models\IngredientCategory;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 * <\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     * 
     * @var string
     */
    protected $model = Recipe::class;

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
            'user_id' => function () {
                if ($user = User::inRandomOrder()->first()){
                    return $user->id;
                }
                return User::factory()->create()->id;
            }
        ];
    }
}
