<?php

namespace Database\Factories;

use App\Models\Planning;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Planning>
 */
class PlanningFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     * 
     * @var string
     */
    protected $model = Planning::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'date' => fake()->date('d-m-Y'),
            'user_id' => function () {
                if ($user = User::inRandomOrder()->first()){
                    return $user->id;
                }
                return User::factory()->create()->id;
            }
        ];
    }
}
