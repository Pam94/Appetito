<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngredientCategoryRequest;
use App\Http\Resources\IngredientCategoryResource;
use App\Models\IngredientCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IngredientCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $autenticatedUserId = Auth::guard('sanctum')->id();

        return IngredientCategoryResource::collection(IngredientCategory::where('user_id', $autenticatedUserId)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IngredientCategoryRequest $request)
    {
        try {

            $autenticatedUserId = Auth::guard('sanctum')->id();

            $validateNewIngredientCategory = Validator::make(
                $request->all(),
                $request->rules()
            );

            if ($validateNewIngredientCategory->fails()) {

                return response()->json([
                    'message' => 'Invalid new Ingredient Category parameters',
                    'errors' => $validateNewIngredientCategory->errors()
                ], 401);
            }

            IngredientCategory::create([
                'name' => $request->name,
                'icon' => $request->icon,
                'user_id' => $autenticatedUserId
            ]);

            return response()->json([
                'message' => 'Ingredient Category Created Successfully'
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
     * @param  \App\Models\IngredientCategory  $ingredientCategory
     * @return \Illuminate\Http\Response
     */
    public function show(IngredientCategory $ingredientCategory)
    {
        return new IngredientCategoryResource($ingredientCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IngredientCategory  $ingredientCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IngredientCategory $ingredientCategory)
    {
        try {

            if (!$ingredientCategory->update($request->all())) {

                return response()->json([
                    'message' => 'Ingredient Category not updated',
                    'data' => $ingredientCategory
                ], 401);
            }

            return response()->json([
                'message' => 'Ingredient Category Updated Successfully',
                'data' => $ingredientCategory
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
     * @param  \App\Models\IngredientCategory  $ingredientCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(IngredientCategory $ingredientCategory)
    {
        if ($ingredientCategory->delete()) {

            return response()->json([
                'message' => 'Ingredient Category deleted successfully'
            ], 200);
        }

        return response()->json([
            'message' => 'Ingredient Category not found'
        ], 404);
    }
}
