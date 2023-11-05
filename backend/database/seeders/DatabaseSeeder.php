<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\IngredientCategory;
use App\Models\Planning;
use App\Models\Recipe;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call([
        //     UserSeeder::class,
        // ]);

        User::factory()->create();

        IngredientCategory::factory()
            ->hasIngredients(2)
            ->count(8)
            ->create();
        
        Recipe::factory()
                ->count(3)
                ->hasCategories(1)
                ->hasIngredients(5)
                ->hasPlannings(2)
                ->create();
    }
}
