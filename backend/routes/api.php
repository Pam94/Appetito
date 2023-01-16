<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController as Auth;

use App\Http\Controllers\IngredientController as IngredientV1;
use App\Http\Controllers\IngredientCategoryController as IngredientCategoryV1;
use App\Http\Controllers\CategoryController as CategoryV1;
use App\Http\Controllers\RecipeController as RecipeV1;
use App\Http\Controllers\PlanningController as PlanningV1;
use App\Http\Controllers\StorageController;
use App\Services\StorageService;

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

Route::middleware('auth:sanctum')->group(function () {
    // api/v1/ingredients GET
    // api/v1/ingredients/{id} GET
    // api/v1/ingredients POST
    // api/v1/ingredients/{id} PUT
    // api/v1/ingredients/{id} DELETE
    Route::apiResource('v1/ingredients', IngredientV1::class);

    // api/v1/ingredientCategories GET
    // api/v1/ingredientCategories/{id} GET
    // api/v1/ingredientCategories POST
    // api/v1/ingredientCategories/{id} PUT
    // api/v1/ingredientCategories/{id} DELETE
    Route::apiResource('v1/ingredientCategories', IngredientCategoryV1::class);

    // api/v1/categories GET
    // api/v1/categories/{id} GET
    // api/v1/categories POST
    // api/v1/categories/{id} PUT
    // api/v1/categories/{id} DELETE
    Route::apiResource('v1/categories', CategoryV1::class);

    // api/v1/recipes GET
    // api/v1/recipes/{id} GET
    // api/v1/recipes POST
    // api/v1/recipes/{id} PUT
    // api/v1/recipes/{id} DELETE
    Route::apiResource('v1/recipes', RecipeV1::class);

    // api/v1/plannings GET
    // api/v1/plannings/{id} GET
    // api/v1/plannings POST
    // api/v1/plannings/{id} PUT
    // api/v1/plannings/{id} DELETE
    Route::apiResource('v1/plannings', PlanningV1::class);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('v1/uploadImage', [StorageController::class, 'uploadImage']);
    Route::post('v1/updateImage', [StorageController::class, 'updateImage']);
});

Route::post('register', [Auth::class, 'register']);
Route::post('login', [Auth::class, 'login']);
Route::post('logout', [Auth::class, 'logout']);

Route::get('images/{filename}', [StorageService::class, 'getImage']);
Route::get('thumbnails/{filename}', [StorageService::class, 'getThumbnail']);

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found'
    ], 404);
});
