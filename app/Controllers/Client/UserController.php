<?php

namespace App\Controllers\Client;

use App\Models\BlockedUser;
use App\Models\User;
use NovaLite\Http\Controller;
use NovaLite\Http\Request;
use NovaLite\Http\Response;

class UserController extends Controller
{
    public function update(int $id, Request $request) : Response
    {
       if($id !== session()->get('user')->id){
         return response()->setStatusCode(Response::HTTP_FORBIDDEN)->json([
            'editError' => 'You are not allowed to update other users information.'
         ]);
       }
       $fullName = $request->input('fullName');
       if(preg_match('/(^[A-Za-z]{3,16})([ ]{0,1})([A-Za-z]{3,16})?([ ]{0,1})?([A-Za-z]{3,16})?([ ]{0,1})?([A-Za-z]{3,16})/', $fullName) === 0){
         return response()->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)->json([
            'fullNameError' => 'Full name is in invalid format. Example: John Doe'
         ]);
       }
       $biography = $request->input('biography');
       $coverImageFullPath = $request->input('coverImage');
       $profileImageFullPath = $request->input('profileImage');
       $explodedCoverImage = explode('/', $coverImageFullPath);
       $explodedProfileImage = explode('/', $profileImageFullPath);
       $coverImage = end($explodedCoverImage);
       $profileImage = end($explodedProfileImage);

       $user = User::where('id', '=', $id)->first();
       $sessionUser = session()->get('user');

       $user->full_name = $fullName;
       $sessionUser->full_name = $fullName;
       $user->biography = $biography;
       if($coverImage !== $user->cover_photo){
         if($user->cover_photo !== 'default-cover.jpg'){
           $coverPicturePath = public_path('assets/img/users-covers/' . $user->cover_photo);
           unlink($coverPicturePath);
         }
         $user->cover_photo = $coverImage;
       }
       if($profileImage !== $user->photo){
         if($user->photo !== 'default.jpg'){
           $profilePicturePath = public_path('assets/img/users/' . $user->photo);
           unlink($profilePicturePath);
         }
         $user->photo = $profileImage;
         $sessionUser->photo = $profileImage;
       }
       $user->save();
       session()->set('user', $sessionUser);

       return response()->json([
            'coverImage' => asset('assets/img/users-covers/' . $coverImage),
            'profileImage' => asset('assets/img/users/' . $profileImage),
            'fullName' => $fullName,
            'biography' => $biography
       ]);
    }
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
        if(!$request->input("edit")) {
            $user->photo = $newName;
            $user->save();
            $sessionUser = session()->get('user');
            $sessionUser->photo = $newName;
            session()->set('user', $sessionUser);
        }

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

        if(!$request->query("edit")){
            $user = User::where('id', '=',session()->get('user')->id)->first();
            $sessionUser = session()->get('user');
            $user->photo = $oldImgName;
            $sessionUser->photo = $oldImgName;
            session()->set('user', $sessionUser);
            $user->save();
        }

        unlink($path);
    }
    public function uploadCoverImage(Request $request) : Response
    {
        $image = $request->file('image');
        $tmpName = $image->tmpName();
        $ext = $image->extension();
        $newName = uniqid() . '.' . $ext;
        $path = public_path('/assets/img/users-covers/' . $newName);
        move_uploaded_file($tmpName, $path);

        $user = User::where('id', '=',session()->get('user')->id)->first();

        $oldPhoto = $user->cover_photo;
        if(!$request->input("edit")){
            $user->cover_photo = $newName;
            $user->save();
            $sessionUser = session()->get('user');
            $sessionUser->cover_photo = $newName;
            session()->set('user', $sessionUser);
        }

        return response()->json([
            'newPhoto' => asset('assets/img/users-covers/' . $newName),
            'oldPhoto' => asset('assets/img/users-covers/' . $oldPhoto),
        ]);
    }
    public function deleteCoverImage(Request $request) : void
    {
        $imgPath = $request->query('imgPath');
        $oldImgPath = $request->query('oldImgPath');
        $explodedPath = explode('/', $imgPath);
        $explodedOldPath = explode('/', $oldImgPath);
        $imgName = end($explodedPath);
        $oldImgName = end($explodedOldPath);
        $path = public_path('assets/img/users-covers/' . $imgName);

        if(!$request->query("edit")){
            $user = User::where('id', '=',session()->get('user')->id)->first();
            $sessionUser = session()->get('user');
            $user->cover_photo = $oldImgName;
            $sessionUser->cover_photo = $oldImgName;
            session()->set('user', $sessionUser);
            $user->save();
        }

        unlink($path);
    }
    public function addBiography(Request $request) : Response
    {
        $biography = $request->input('biography');
        if(strlen($biography) > 160){
            return response()->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)->json([
                'error' => 'Biography must be less than 160 characters'
            ]);
        }
        $user = User::where('id', '=',session()->get('user')->id)->first();
        $sessionUser = session()->get('user');
        $user->biography = $biography;
        $sessionUser->biography = $biography;
        session()->set('user', $sessionUser);
        $user->save();

        return response()->json([]);
    }
}
