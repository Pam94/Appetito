<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\IngredientCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     * 
     * @var string
     */
    protected $model = Ingredient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->randomElement(['Plátano', 'Yogur', 'Queso', 
                'Pimienta','Mango', 'Tomate', 'Patata', 'Carne de Ternera',
                'Pollo']),
            'pantry' => fake()->boolean(),
            'shoplist' => fake()->boolean(),
            'user_id' => function () {
                if ($user = User::inRandomOrder()->first()){
                    return $user->id;
                }
                return User::factory()->create()->id;
            },
            'ingredient_category_id' => function () {
                if ($ingredientCategory = 
                        IngredientCategory::inRandomOrder()->first()){
                    return $ingredientCategory->id;
                }
                return IngredientCategory::factory()->create()->id;
            }
        ];
    }
}
