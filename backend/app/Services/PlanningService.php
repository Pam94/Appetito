<?php

namespace App\Services;

use App\Models\Ingredient;
use App\Models\IngredientRecipe;

class PlanningService
{

    public function checkIngredients($recipeId)
    {
        $ingredientsIds = IngredientRecipe::where('recipe_id', $recipeId)->pluck('ingredient_id')->toArray();

        foreach ($ingredientsIds as $ingredientId) {
            $ingredient = Ingredient::find($ingredientId);

            if ($ingredient && !$ingredient->pantry) {
                $ingredient->shoplist = 1;
                $ingredient->save();
            }
        }
    }
}
