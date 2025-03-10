<?php

namespace App\Controllers\Client;

use App\Models\User;
use NovaLite\Http\Controller;
use NovaLite\Http\Request;

class ExploreController extends Controller
{
    public function index() : string
    {
        return view('pages.client.explore');
    }
    public function search(Request $request)
    {
        $users = User::where('username', 'like', "%{$request->input('search')}%")
                     ->orWhere('full_name', 'like', "%{$request->input('search')}%")
                     ->where('id','!=', session()->get('user')->id)->get();
        $response = [];
        if($users){
            foreach ($users as $user) {
                $response[] = [
                    'id' => $user->id,
                    'username' => $user->username,
                    'full_name' => $user->full_name,
                    'photo' => asset('assets/img/users/' . $user->photo),
                    'profile_url' => route('profile', ['username' => $user->username])
                ];
            }
            return response()->json($response);
        }
        return response()->json([]);
    }
}
