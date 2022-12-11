<?php

namespace App\Http\Controllers;

use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return IngredientResource::collection(Ingredient::latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $validateNewIngredient = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'user_id' => 'required',
                    //'ingredientCategoryId' => 'required'

                ]
            );

            if ($validateNewIngredient->fails()) {

                return response()->json([
                    'message' => 'Invalid new Ingredient parameters',
                    'errors' => $validateNewIngredient->errors()
                ], 401);
            }

            $ingredient = Ingredient::create([
                'name' => $request->name,
                'icon' => $request->icon,
                'pantry' => $request->pantry ? $request->pantry : false,
                'shoplist' => $request->shoplist ? $request->shoplist : false,
                'user_id' => $request->user_id,
                //'ingredientCategoryId' => $request->ingredientCategoryId
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
    public function update(Request $request, Ingredient $ingredient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ingredient $ingredient)
    {
        //
    }
}
