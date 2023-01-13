<?php

namespace App\Services;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageIntervention;

class StorageService
{

    public function saveImage($imageFile, $imageHashName)
    {
        $imageFile->store('images', 'private');

        $imageThumbnail = ImageIntervention::make($imageFile->getRealPath());

        $imageThumbnail->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path('app/private') . '/thumbnails/' . $imageHashName);
    }

    public function saveThumbnail($imageFile, $imageHashName)
    {
        $imageThumbnail = ImageIntervention::make($imageFile->getRealPath());

        $imageThumbnail->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path('app/private') . '/thumbnails/' . $imageHashName);
    }

    public function getImage(string $filename)
    {
        $images_path = 'private/images/' . $filename;

        if (Storage::exists($images_path)) {

            $file = Storage::get($images_path);
            return response($file, 200)
                ->header('Content-Type', 'image/jpeg', 'image/jpg', 'image/png');
        }

        return response(404);
    }

    public function getThumbnail(string $filename)
    {
        $images_path = 'private/thumbnails/' . $filename;

        if (Storage::exists($images_path)) {

            $file = Storage::get($images_path);
            return response($file, 200)
                ->header('Content-Type', 'image/jpeg', 'image/jpg', 'image/png');
        }

        return response(404);
    }

    public function removeImage(string $filename)
    {
        $images_path = 'private/images/' . $filename;

        if (
            Storage::exists($images_path) and
            Storage::delete($images_path)
        ) {

            return response(200);
        }

        return response(404);
    }


    public function removeThumbnail(string $filename)
    {
        $images_path = 'private/thumbnails/' . $filename;

        if (
            Storage::exists($images_path)
            and Storage::delete($images_path)
        ) {

            return response(200);
        }

        return response(404);
    }
}
