<?php

namespace App\Controllers\Client;

use NovaLite\Database\Database;
use NovaLite\Http\Controller;
use NovaLite\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function index(string $username) : string|RedirectResponse
    {
        $profileUser = Database::table('users')
            ->select('id')
            ->where('username', '=', $username)
            ->first();
        $blockedUsers = array_column(
            Database::table('blocked_users')
                ->where('blocked_by_user_id', '=', session()->get('user')->id)
                ->get(),
            'blocked_user_id'
        );
        if(in_array($profileUser->id, $blockedUsers)) {
            return redirect()->to('home');
        }
        return view('pages.client.profile');
    }
}
