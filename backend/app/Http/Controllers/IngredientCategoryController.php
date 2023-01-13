<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\IngredientCategoryResource;
use App\Models\IngredientCategory;
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
        return IngredientCategoryResource::collection(IngredientCategory::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewCategoryRequest $request)
    {
        try {

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

            if ($request->hasFile('icon')) {

                $request->validate([
                    'icon' => 'mimes::jpeg,jpg,png'
                ]);

                $imageFile = $request->file('icon');

                $imageFile->store('images', 'private');

                IngredientCategory::create([
                    'name' => $request->name,
                    'icon_name' => $imageFile->hashName()
                ]);
            }

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
    public function update(UpdateCategoryRequest $request, IngredientCategory $ingredientCategory)
    {
        try {

            $validateUpdateIngredientCategory = Validator::make(
                $request->all(),
                $request->rules()
            );

            if ($validateUpdateIngredientCategory->fails()) {

                return response()->json([
                    'message' => 'Invalid update Ingredient Category parameters',
                    'errors' => $validateUpdateIngredientCategory->errors()
                ], 401);
            }

            if ($request->hasFile('icon')) {

                $request->validate([
                    'icon' => 'mimes::jpeg,jpg,png'
                ]);

                (new StorageController)->removeImage($ingredientCategory->icon_name);

                $imageFile = $request->file('icon');
                $imageFile->store('images', 'private');

                $request->request->remove('icon');
                $request->request->add(['icon_name' => $imageFile->hashName()]);
            }

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

            (new StorageController)->removeImage($ingredientCategory->icon_name);

            return response()->json([
                'message' => 'Ingredient Category deleted successfully'
            ], 200);
        }

        return response()->json([
            'message' => 'Ingredient Category not found'
        ], 404);
    }
}
