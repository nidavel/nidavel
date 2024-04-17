<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Uploads the given image to directory
     */
    static public function upload(Request $request, string $image): string
    {
        $path = $request->file($image)->store('/images');
 
        return $path;
    }

    /**
     * Stores the uploaded image in post and
     * returns the file path
     */
    public function postImageAcceptor(Request $request): string
    {
        $location = static::upload($request, 'file');

        return json_encode([
            "location" => $location
        ]);
    }

    /**
     * Stores the uploaded image and
     * returns the file path
     */
    static public function store($file): bool
    {
        return Storage::put('file.jpg', $contents);
    }

    /**
     * Returns the image
     */
    static public function get($image): ?string
    {
        $contents = null;

        if (Storage::exists($image)) {
            $contents = Storage::get($image);
        }
        
        return $contents;
    }

    /**
     * Returns all the images in a directory
     */
    static public function getAll($directory): ?array
    {
        $images = Storage::files($directory);
        
        return $images;
    }

    /**
     * Unlinks given image from directory
     */
    static public function delete(...$images): bool
    {
        Storage::delete([$images]);
    }
}
