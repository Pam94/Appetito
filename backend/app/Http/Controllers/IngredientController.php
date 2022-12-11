<?php

namespace App\Http\Controllers;

use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {

        try {

            $autenticatedUserId = Auth::guard('sanctum')->id();

            $validateNewIngredient = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'ingredientCategory_id' => 'required'
                ]
            );

            if ($validateNewIngredient->fails()) {

                return response()->json([
                    'message' => 'Invalid new Ingredient parameters',
                    'errors' => $validateNewIngredient->errors()
                ], 401);
            }

            Ingredient::create([
                'name' => $request->name,
                'icon' => $request->icon,
                'pantry' => $request->pantry ? $request->pantry : false,
                'shoplist' => $request->shoplist ? $request->shoplist : false,
                'user_id' => $autenticatedUserId,
                'ingredientCategory_id' => $request->ingredientCategory_id
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
        try {

            if (!$ingredient->update($request->all())) {

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
            ], 200);
        }

        return response()->json([
            'message' => 'Ingredient not found'
        ], 404);
    }
}
