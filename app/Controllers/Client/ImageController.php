<?php

namespace App\Controllers\Client;

use NovaLite\Http\Controller;
use NovaLite\Http\Request;

class ImageController extends Controller
{
    public function uploadPostImage(Request $request) : string
    {
        $image = $request->file('image');
        $tmpName = $image->tmpName();
        $ext = $image->extension();
        $newName = uniqid() . '.' . $ext;
        $path = public_path('/assets/img/posts/' . $newName);
        move_uploaded_file($tmpName, $path);
        return asset('assets/img/posts/' . $newName);
    }
    public function deletePostImage(Request $request) : void
    {
        $imgPath = $request->query('imgPath');
        $explodedPath = explode('/', $imgPath);
        $imgName = end($explodedPath);
        $path = public_path('assets/img/posts/' . $imgName);

        unlink($path);
    }
}
