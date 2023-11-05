<?php

namespace Database\Factories;

use App\Models\IngredientCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IngredientCategory>
 */
class IngredientCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     * 
     * @var string
     */
    protected $model = IngredientCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->randomElement(['Verdura', 'Tubérculo',
             'Carne Roja', 'Carne Blanca', 'Cereal', 'Fruta', 'Especia', 
             'Lácteo']),
            'icon_name' => fake()->colorName()
        ];
    }
}
