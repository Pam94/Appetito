<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $autenticatedUserId = Auth::guard('sanctum')->id();

        return ImageResource::collection(Image::where('user_id', $autenticatedUserId)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewImageRequest $request)
    {
        try {

            $autenticatedUserId = Auth::guard('sanctum')->id();

            $validateNewImage = Validator::make(
                $request->all(),
                $request->rules()
            );

            if ($validateNewImage->fails()) {

                return response()->json([
                    'message' => 'Invalid new Image parameters',
                    'errors' => $validateNewImage->errors()
                ], 401);
            }

            if ($request->hasFile('image')) {

                $request->validate([
                    'image' => 'mimes::jpeg,jpg,png'
                ]);

                $imageFile = $request->file('image');

                $imageFile->store('recipes', 'private');

                Image::create([
                    'url' => $request->url,
                    'image_name' => $imageFile->hashName(),
                    'recipe_id' => $request->recipe_id,
                    'user_id' => $autenticatedUserId
                ]);
            }


            return response()->json([
                'message' => 'Image Created Successfully'
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
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        return new ImageResource($image);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        try {

            $validateUpdateImage = Validator::make(
                $request->all(),
                $request->rules()
            );

            if ($validateUpdateImage->fails()) {

                return response()->json([
                    'message' => 'Invalid update Image parameters',
                    'errors' => $validateUpdateImage->errors()
                ], 401);
            } elseif (!$image->update($request->all())) {

                return response()->json([
                    'message' => 'Image not updated',
                    'data' => $image
                ], 401);
            }
            return response()->json([
                'message' => 'Image Updated Successfully',
                'data' => $image
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
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        if ($image->delete()) {

            return response()->json([
                'message' => 'Image deleted successfully'
            ], 200);
        }

        return response()->json([
            'message' => 'Image not found'
        ], 404);
    }
}
