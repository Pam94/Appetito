<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\NewRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\CategoryRecipe;
use App\Models\IngredientRecipe;
use App\Models\PlanningRecipe;
use App\Services\StorageService;

class RecipeController extends Controller
{

    public function __construct(private StorageService $storageService)
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $autenticatedUserId = Auth::guard('sanctum')->id();

        return RecipeResource::collection(Recipe::where('user_id', $autenticatedUserId)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewRecipeRequest $request)
    {
        try {

            $autenticatedUserId = Auth::guard('sanctum')->id();

            $validateNewRecipe = Validator::make($request->all(), $request->rules());

            if ($validateNewRecipe->fails()) {

                return response()->json([
                    'message' => 'Invalid new Recipe parameters',
                    'errors' => $validateNewRecipe->errors()
                ], 401);
            }

            $recipe = Recipe::create([
                'name' => $request->name,
                'time' => $request->time,
                'portions' => $request->portions,
                'instructions' => $request->instructions,
                'favorite' => $request->favorite ? $request->favorite : false,
                'url' => $request->url,
                'image' => $request->image,
                'user_id' => $autenticatedUserId
            ]);

            if (!$recipe->id) {

                return response()->json([
                    'message' => "Recipe not created"
                ], 401);
            }
            $recipeId = $recipe->id;

            $this->createIngredientsRecipe($recipeId, $request->ingredients);
            $this->createCategoriesRecipe($recipeId, $request->categories);

            return response()->json([
                'message' => 'Recipe Created Successfully'
            ], 200);
        } catch (\Throwable $throwable) {

            return response()->json([
                'message' => $throwable->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        return new RecipeResource($recipe);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        try {

            $validateUpdateRecipe = Validator::make(
                $request->all(),
                $request->rules()
            );

            if ($validateUpdateRecipe->fails()) {

                return response()->json([
                    'message' => 'Invalid update Recipe parameters',
                    'errors' => $validateUpdateRecipe->errors()
                ], 401);
            }

            if (!$recipe->update($request->all())) {

                return response()->json([
                    'message' => 'Recipe not updated',
                    'data' => $recipe
                ], 401);
            }

            $this->updateIngredientsRecipe($recipe->id, $request->ingredients);
            $this->updateCategoriesRecipe($recipe->id, $request->categories);

            return response()->json([
                'message' => 'Recipe Updated Successfully',
                'data' => $recipe
            ], 200);
        } catch (\Throwable $throwable) {

            return response()->json([
                'message' => $throwable->getMessage()
            ], 204);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        if ($recipe->delete()) {

            $this->storageService->removeImage($recipe->image);
            $this->storageService->removeThumbnail($recipe->image);

            $this->destroyCategoriesRecipe($recipe->id);
            $this->destroyIngredientsRecipe($recipe->id);
            $this->destroyPlanningsRecipe($recipe->id);

            return response()->json([
                'message' => 'Recipe deleted successfully'
            ], 204);
        }

        return response()->json([
            'message' => 'Recipe not found'
        ], 404);
    }

    public function createCategoriesRecipe($recipeId, $categories)
    {

        if ($categories) {

            foreach ($categories as $category) {

                if (!CategoryRecipe::create([
                    'recipe_id' => $recipeId,
                    'category_id' => $category['id']
                ])) {
                    return response()->json([
                        'message' => "Recipe Category not created"
                    ], 401);
                }
            }
        }
    }

    public function updateCategoriesRecipe($recipeId, $categories)
    {

        if ($categories) {
            $this->destroyCategoriesRecipe($recipeId);

            foreach ($categories as $category) {

                if (!CategoryRecipe::create([
                    'recipe_id' => $recipeId,
                    'category_id' => $category['id']
                ])) {
                    return response()->json([
                        'message' => "Recipe Category not created"
                    ], 401);
                }
            }
        }
    }

    public function createIngredientsRecipe($recipeId, $ingredients)
    {
        if ($ingredients) {

            foreach ($ingredients as $ingredient) {

                if (!IngredientRecipe::create([
                    'recipe_id' => $recipeId,
                    'ingredient_id' => $ingredient['id'],
                    'grams' => $ingredient['grams']
                ])) {
                    return response()->json([
                        'message' => "Recipe Ingredient not created"
                    ], 401);
                }
            }
        }
    }

    public function updateIngredientsRecipe($recipeId, $ingredients)
    {
        if ($ingredients) {
            $this->destroyIngredientsRecipe($recipeId);

            foreach ($ingredients as $ingredient) {

                if (!IngredientRecipe::create([
                    'recipe_id' => $recipeId,
                    'ingredient_id' => $ingredient['id'],
                    'grams' => $ingredient['grams']
                ])) {
                    return response()->json([
                        'message' => "Recipe Ingredient not created"
                    ], 401);
                }
            }
        }
    }

    public function destroyCategoriesRecipe($recipeId)
    {
        $categoriesRecipe = CategoryRecipe::where('recipe_id', $recipeId);
        foreach ($categoriesRecipe as $categoryRecipe) {
            CategoryRecipe::destroy($categoryRecipe->id);
        }
    }

    public function destroyIngredientsRecipe($recipeId)
    {
        $ingredientsRecipe = IngredientRecipe::where('recipe_id', $recipeId);
        foreach ($ingredientsRecipe as $ingredientRecipe) {
            IngredientRecipe::destroy($ingredientRecipe->id);
        }
    }

    public function destroyPlanningsRecipe($recipeId)
    {
        $planningsRecipe = PlanningRecipe::where('recipe_id', $recipeId);
        foreach ($planningsRecipe as $planningRecipe) {
            PlanningRecipe::destroy($planningRecipe->id);
        }
    }
}
