<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController as Auth;

use App\Http\Controllers\IngredientController as IngredientV1;
use App\Http\Controllers\IngredientCategoryController as IngredientCategoryV1;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    // api/v1/ingredients
    Route::apiResource('v1/ingredients', IngredientV1::class)
        ->only(['index', 'store', 'show']);

    // api/v1/ingredientCategories
    Route::apiResource('v1/ingredientCategories', IngredientCategoryV1::class)->only(['index', 'store', 'show']);
});

Route::post('register', [Auth::class, 'register']);
Route::post('login', [Auth::class, 'login']);
