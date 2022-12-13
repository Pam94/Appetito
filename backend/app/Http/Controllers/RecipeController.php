<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Models\RecipeCategory;
use App\Models\RecipeIngredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use APp\Http\Controllers\ImageController;
use App\Models\Image;

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
    public function store(RecipeRequest $request)
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
                'favorite' => $request->favorite,
                'url' => $request->url,
                'video' => $request->video,
                'user_id' => $autenticatedUserId
            ]);

            $recipeId = $recipe->id;

            $request->ingredients->each(function ($ingredient) use ($recipeId) {

                RecipeIngredient::create([
                    'recipe_id' => $recipeId,
                    'ingredient_id' => $ingredient->id,
                    'grams' => $ingredient->grams
                ]);
            });

            $request->categories->each(function ($category) use ($recipeId) {

                RecipeCategory::create([
                    'recipe_id' => $recipeId,
                    'category_id' => $category->id
                ]);
            });

            $request->images->each(function ($image) use ($recipeId) {

                $image = Image::find('image_id', $image->id);

                $image->update([
                    'recipe_id' => $recipeId
                ]);
            });

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
    public function update(Request $request, Recipe $recipe)
    {
        try {

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

            return response()->json([
                'message' => 'Recipe deleted successfully'
            ], 204);
        }

        return response()->json([
            'message' => 'Recipe not found'
        ], 404);
    }
}
