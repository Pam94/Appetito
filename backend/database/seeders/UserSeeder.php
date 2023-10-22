<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's UsersSeeder database table.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory()
            ->count(5)
            ->has(Recipe::factory()->count(5), 'recipes')
            ->create();
    
    }
}