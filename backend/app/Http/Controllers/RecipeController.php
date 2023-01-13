<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\NewRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\CategoryRecipe;
use App\Models\Image;
use App\Models\IngredientRecipe;

class RecipeController extends Controller
{
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

            $imageHashName = '';

            if ($request->hasFile('image')) {

                $request->validate([
                    'image' => 'mimes::jpeg,jpg,png'
                ]);

                $imageFile = $request->file('image');
                $imageHashName = $imageFile->hashName();

                (new StorageController)->saveImage($imageFile, $imageHashName);
            }

            $recipe = Recipe::create([
                'name' => $request->name,
                'time' => $request->time,
                'portions' => $request->portions,
                'instructions' => $request->instructions,
                'favorite' => $request->favorite ? $request->favorite : false,
                'url' => $request->url,
                'image' => $imageHashName,
                'user_id' => $autenticatedUserId
            ]);

            if (!$recipe->id) {

                return response()->json([
                    'message' => "Recipe not created"
                ], 401);
            }
            $recipeId = $recipe->id;

            foreach ($request->ingredients as $ingredient) {

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

            foreach ($request->categories as $category) {

                if (!CategoryRecipe::create([
                    'recipe_id' => $recipeId,
                    'category_id' => $category['id']
                ])) {
                    return response()->json([
                        'message' => "Recipe Category not created"
                    ], 401);
                }
            }

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

            if ($request->hasFile('image')) {

                $request->validate([
                    'image' => 'mimes::jpeg,jpg,png'
                ]);

                if ($recipe->image !== '') {
                    (new StorageController)->removeImage($recipe->image);
                }

                $imageFile = $request->file('image');
                $imageHashName = $imageFile->hashName();
                (new StorageController)->saveImage($imageFile, $imageHashName);

                $request->request->remove('image');
                $request->request->add(['image_name' => $imageHashName]);
            }

            if (!$recipe->update($request->all())) {

                return response()->json([
                    'message' => 'Recipe not updated',
                    'data' => $recipe
                ], 401);
            }

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

            (new StorageController)->removeImage($recipe->image);

            return response()->json([
                'message' => 'Recipe deleted successfully'
            ], 204);
        }

        return response()->json([
            'message' => 'Recipe not found'
        ], 404);
    }
}
