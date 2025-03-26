<?php

namespace App\Controllers\Client;

use App\Models\BlockedUser;
use App\Models\User;
use NovaLite\Http\Controller;
use NovaLite\Http\Request;
use NovaLite\Http\Response;

class UserController extends Controller
{
    public function blockUser(Request $request) : void
    {
        $blockedUserId = $request->input('user_id');
        $userId = session()->get('user')->id;
        BlockedUser::create([
            'blocked_by_user_id' => $userId,
            'blocked_user_id' => $blockedUserId
        ]);
    }

    public function uploadProfileImage(Request $request) : Response
    {
        $image = $request->file('image');
        $tmpName = $image->tmpName();
        $ext = $image->extension();
        $newName = uniqid() . '.' . $ext;
        $path = public_path('/assets/img/users/' . $newName);
        move_uploaded_file($tmpName, $path);

        $user = User::where('id', '=',session()->get('user')->id)->first();
        $oldPhoto = $user->photo;
        $user->photo = $newName;
        $user->save();

        return response()->json([
            'newPhoto' => asset('assets/img/users/' . $newName),
            'oldPhoto' => asset('assets/img/users/' . $oldPhoto),
        ]);
    }

    public function deleteProfileImage(Request $request) : void
    {
        $imgPath = $request->query('imgPath');
        $oldImgPath = $request->query('oldImgPath');
        $explodedPath = explode('/', $imgPath);
        $explodedOldPath = explode('/', $oldImgPath);
        $imgName = end($explodedPath);
        $oldImgName = end($explodedOldPath);
        $path = public_path('assets/img/users/' . $imgName);

        $user = User::where('id', '=',session()->get('user')->id)->first();
        $user->photo = $oldImgName;
        $user->save();

        unlink($path);
    }
}
