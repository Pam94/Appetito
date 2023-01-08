<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
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

    public function removeImage(string $filename)
    {
        $images_path = 'private/images/' . $filename;

        if (Storage::exists($images_path)) {
            Storage::delete($images_path);

            return response(200);
        }

        return response(404);
    }
}
