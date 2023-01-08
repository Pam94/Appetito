<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $autenticatedUserId = Auth::guard('sanctum')->id();

        return IngredientResource::collection(Ingredient::where('user_id', $autenticatedUserId)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewIngredientRequest $request)
    {
        try {

            $autenticatedUserId = Auth::guard('sanctum')->id();

            $validateNewIngredient = Validator::make(
                $request->all(),
                $request->rules()
            );

            if ($validateNewIngredient->fails()) {

                return response()->json([
                    'message' => 'Invalid new Ingredient parameters',
                    'errors' => $validateNewIngredient->errors()
                ], 401);
            }

            Ingredient::create([
                'name' => $request->name,
                'pantry' => $request->pantry ? $request->pantry : false,
                'shoplist' => $request->shoplist ? $request->shoplist : false,
                'user_id' => $autenticatedUserId,
                'ingredient_category_id' => $request->ingredient_category_id
            ]);

            return response()->json([
                'message' => 'Ingredient Created Successfully'
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
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function show(Ingredient $ingredient)
    {
        return new IngredientResource($ingredient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIngredientRequest $request, Ingredient $ingredient)
    {
        try {

            $validateUpdateIngredient = Validator::make(
                $request->all(),
                $request->rules()
            );

            if ($validateUpdateIngredient->fails()) {

                return response()->json([
                    'message' => 'Invalid update Ingredient parameters',
                    'errors' => $validateUpdateIngredient->errors()
                ], 401);
            } elseif (!$ingredient->update($request->all())) {

                return response()->json([
                    'message' => 'Ingredient not updated',
                    'data' => $ingredient
                ], 401);
            }

            return response()->json([
                'message' => 'Ingredient Updated Successfully',
                'data' => $ingredient
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
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ingredient $ingredient)
    {
        if ($ingredient->delete()) {

            return response()->json([
                'message' => 'Ingredient deleted successfully'
            ], 204);
        }

        return response()->json([
            'message' => 'Ingredient not found'
        ], 404);
    }
}
