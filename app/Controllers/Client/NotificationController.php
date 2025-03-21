<?php

namespace App\Controllers\Client;

use App\Models\Notification;
use NovaLite\Http\Controller;
use NovaLite\Views\View;

class NotificationController extends Controller
{
    public function index() : View
    {
        $userNotifications = Notification::with('user', 'notificationType', 'post')->where('target_user_id', '=', session()->get('user')->id)->orderBy('id', 'desc')->get();
        return view('pages.client.notifications',[
            'notifications' => $userNotifications
        ]);
    }
    public function read(string $id) : void
    {
        $notification = Notification::where('id', '=', $id)->first();
        $notification->is_read = 1;
        $notification->save();
    }
}
