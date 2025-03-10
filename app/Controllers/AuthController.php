<?php

namespace App\Controllers;

use App\Mail\MailSender;
use App\Mail\VerificationEmail;
use App\Models\Nav;
use App\Models\User;
use App\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Mail;
use NovaLite\Database\Database;
use NovaLite\Http\Controller;
use NovaLite\Http\RedirectResponse;
use NovaLite\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.start');
    }
    public function register(RegisterUserRequest $request)
    {
        $newUser = $request->getAll();
        $newUser['password'] = password_hash($request->input('password'), PASSWORD_DEFAULT);
        $roleUserId = Database::table('roles')->where('name', '=', 'user')->value('id');
        $newUser['role_id'] = $roleUserId;
        $newUser['photo'] = 'default.jpg';
        $newUser['cover_photo'] = 'default-cover.jpg';
        $verificationToken = bin2hex(random_bytes(15));
        $exists = User::where('token','=', $verificationToken)->first();
        while ($exists) {
            $verificationToken = bin2hex(random_bytes(15));
            $exists = User::where('token','=', $verificationToken)->first();
        }
        $newUser['token'] = $verificationToken;
        User::create($newUser);
        $mail = new VerificationEmail($verificationToken);
        $mail->sendEmail($newUser['email']);
        return redirect()->back()->with('success-message', 'You have successfully registered. Please check your email to activate your account.');
    }
    public function login(Request $request) : RedirectResponse
    {
        $_SESSION['old']['username'] = $request->input('username');
        $_SESSION['old']['password'] = $request->input('password');
        if(!$request->input('username') || !$request->input('password')) {
            return redirect()->back()->with('error-message', 'Username and password are required');
        }

        $user = Database::table('users')->where('username', '=', $request->input('username'))->first();;
        if (!$user) {
            return redirect()->back()->with('error-message', 'Wrong credentials.');
        }

        if(password_verify($request->input('password'), $user->password)) {
            if(!$user->is_active){
                return redirect()->back()->with('error-message', 'Your account is not activated.');
            }
            session()->set('user', $user);
            $_SESSION['old'] = null;
            return redirect('/home')->with('success-message', 'You have successfully logged in.');
        }
        return redirect()->back()->with('error-message', 'Wrong credentials.');
    }
    public function logout() : RedirectResponse
    {
        session()->remove('user');
        return redirect()->to('start');
    }
    public function verification(string $token) : RedirectResponse
    {
        $user = User::where('token', '=', $token)->first();
        if ($user) {
            $user->is_active = true;
            $user->token = null;
            $user->save();
            return redirect()->to('start')->with('verification-message', 'Your account has been activated. You can now login.');
        }
        return redirect()->to('start')->with('error-verification-message', 'Your token is invalid.');
    }
}
