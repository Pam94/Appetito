<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Services\StorageService;
use Illuminate\Support\Facades\Validator;

class StorageController extends Controller
{
    public function __construct(private StorageService $storageService)
    {
    }

    public function uploadImage(NewImageRequest $request)
    {
        try {

            $validateUploadImage = Validator::make(
                $request->all(),
                $request->rules()
            );

            if ($validateUploadImage->fails()) {

                return response()->json([
                    'message' => 'Invalid image',
                    'errors' => $validateUploadImage->errors()
                ], 401);
            }

            if ($request->hasFile('image')) {

                $request->validate([
                    'image' => 'mimes::jpeg,jpg,png'
                ]);

                $imageFile = $request->file('image');
                $imageHashName = $imageFile->hashName();

                $this->storageService->saveImage($imageFile, $imageHashName);
            }
            return response()->json([
                'message' => 'Image Upload Successfully',
                'data' => $imageHashName
            ], 200);
        } catch (\Throwable $throwable) {

            return response()->json([
                'message' => $throwable->getMessage(),
                'data' => $imageHashName
            ], 500);
        }
    }
    public function updateImage(UpdateImageRequest $request)
    {
        try {

            $validateUpdateImage = Validator::make(
                $request->all(),
                $request->rules()
            );

            if ($validateUpdateImage->fails()) {

                return response()->json([
                    'message' => 'Invalid image update parameters',
                    'errors' => $validateUpdateImage->errors()
                ], 401);
            }

            if ($request->hasFile('image')) {

                $request->validate([
                    'image' => 'mimes::jpeg,jpg,png'
                ]);


                $this->storageService->removeImage($request->recipe_image);

                $imageFile = $request->file('image');
                $imageHashName = $imageFile->hashName();
                $this->storageService->saveImage($imageFile, $imageHashName);
            }
            return response()->json([
                'message' => 'Image Updated Successfully',
                'data' => $imageHashName
            ], 200);
        } catch (\Throwable $throwable) {

            return response()->json([
                'message' => $throwable->getMessage()
            ], 500);
        }
    }
}
