<?php

namespace App\Controllers;

use App\Models\User;
use App\Requests\RegisterUserRequest;
use NovaLite\Database\Database;
use NovaLite\Http\Controller;
use NovaLite\Http\RedirectResponse;
use NovaLite\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        session_start();
        return view('pages.start');
    }
    public function register(RegisterUserRequest $request)
    {
        $newUser = $request->getAll();
        $newUser['password'] = password_hash($request->input('password'), PASSWORD_DEFAULT);
        $roleUserId = Database::table('roles')->where('name', '=', 'user')->value('id');
        $newUser['role_id'] = $roleUserId;
        User::create($newUser);
        return redirect()->back()->with('success-message', 'You have successfully registered.');
    }
    public function login(Request $request) : RedirectResponse
    {
        if(!$request->input('username') || !$request->input('password')) {
            return redirect()->back()->with('error-message', 'Username and password are required');
        }

        $user = Database::table('users')->where('username', '=', $request->input('username'))->first();;
        if (!$user) {
            return redirect()->back()->with('error-message', 'Wrong credentials.');
        }

        if(password_verify($request->input('password'), $user->password)) {
            session()->set('user', $user);
            return redirect('/home')->with('success-message', 'You have successfully logged in.');
        }
        return redirect()->back()->with('error-message', 'Wrong credentials.');
    }
    public function logout() : RedirectResponse
    {
        session()->remove('user');
        return redirect()->to('start');
    }
}
