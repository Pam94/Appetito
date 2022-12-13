<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $autenticatedUserId = Auth::guard('sanctum')->id();

        return CategoryResource::collection(Category::where('user_id', $autenticatedUserId)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {

            $autenticatedUserId = Auth::guard('sanctum')->id();

            $validateNewCategory = Validator::make(
                $request->all(),
                $request->rules()
            );

            if ($validateNewCategory->fails()) {

                return response()->json([
                    'message' => 'Invalid new Category parameters',
                    'errors' => $validateNewCategory->errors()
                ], 401);
            }

            Category::create([
                'name' => $request->name,
                'icon' => $request->icon,
                'user_id' => $autenticatedUserId,
            ]);

            return response()->json([
                'message' => 'Category Created Successfully'
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        try {

            if (!$category->update($request->all())) {

                return response()->json([
                    'message' => 'Category not updated',
                    'data' => $category
                ], 401);
            }

            return response()->json([
                'message' => 'Category Updated Successfully',
                'data' => $category
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->delete()) {

            return response()->json([
                'message' => 'Category deleted successfully'
            ], 200);
        }

        return response()->json([
            'message' => 'Category not found'
        ], 404);
    }
}