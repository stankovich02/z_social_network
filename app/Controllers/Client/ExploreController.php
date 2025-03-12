<?php

namespace App\Controllers\Client;

use App\Models\User;
use NovaLite\Database\Database;
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
        $blockedUsers = array_column(
            Database::table('blocked_users')
                ->where('blocked_by_user_id', '=', session()->get('user')->id)
                ->get(),
            'blocked_user_id'
        );
        $response = [];
        if($users){
            foreach ($users as $user) {
               if(!in_array($user->id, $blockedUsers)) {
                   $response[] = [
                       'id' => $user->id,
                       'username' => $user->username,
                       'full_name' => $user->full_name,
                       'photo' => asset('assets/img/users/' . $user->photo),
                       'profile_url' => route('profile', ['username' => $user->username])
                   ];
               }
            }
            return response()->json($response);
        }
        return response()->json([]);
    }
}
