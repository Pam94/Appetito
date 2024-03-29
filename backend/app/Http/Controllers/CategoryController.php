<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\StorageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function __construct(private StorageService $storageService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
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

            if ($request->hasFile('icon')) {

                $request->validate([
                    'icon' => 'mimes::jpeg,jpg,png'
                ]);

                $imageFile = $request->file('icon');
                $imageHashName = $imageFile->hashName();

                $this->storageService->saveThumbnail($imageFile, $imageHashName);


                Category::create([
                    'name' => $request->name,
                    'icon_name' => $imageHashName
                ]);
            }

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
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {

            $validateUpdateCategory = Validator::make(
                $request->all(),
                $request->rules()
            );

            if ($validateUpdateCategory->fails()) {

                return response()->json([
                    'message' => 'Invalid update Category parameters',
                    'errors' => $validateUpdateCategory->errors()
                ], 401);
            }

            if ($request->hasFile('icon')) {

                $request->validate([
                    'icon' => 'mimes::jpeg,jpg,png'
                ]);

                $this->storageService->removeThumbnail($category->icon_name);

                $imageFile = $request->file('icon');
                $imageHashName = $imageFile->hashName();
                $this->storageService->saveThumbnail($imageFile, $imageHashName);

                $request->request->remove('icon');
                $request->request->add(['icon_name' => $imageHashName]);
            }

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

            $this->storageService->removeThumbnail($category->icon_name);

            return response()->json([
                'message' => 'Category deleted successfully'
            ], 200);
        }

        return response()->json([
            'message' => 'Category not found'
        ], 404);
    }
}
