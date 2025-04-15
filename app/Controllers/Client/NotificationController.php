<?php

namespace App\Controllers\Client;

use App\Models\ImagePost;
use App\Models\Notification;
use App\Traits\Calculate;
use NovaLite\Http\Controller;
use NovaLite\Views\View;

class NotificationController extends Controller
{
    use Calculate;
    public function index() : View
    {
        $userNotifications = Notification::with('user', 'notificationType','post_notification','post_comment_notification','post_notification.post','post_comment_notification.comment')->where('target_user_id', '=', session()->get('user')->id)->orderBy('id', 'desc')->get();
        foreach ($userNotifications as $notification) {
            if($notification->notification_type_id === Notification::NOTIFICATION_TYPE_COMMENT && $notification->post_comment_notification) {
                $notification->post_comment_notification->comment->created_at = $this->calculatePostedDate($notification->post_comment_notification->comment->created_at);
            }
            if(($notification->notification_type_id === Notification::NOTIFICATION_TYPE_LIKE || $notification->notification_type_id === Notification::NOTIFICATION_TYPE_REPOST) && $notification->post_notification) {
                $notification->post_notification->post->image = ImagePost::where('post_id', '=',$notification->post_notification->post->id)->count();
            }
        }
        return view('pages.client.notifications',[
            'notifications' => $userNotifications
        ]);
    }
    public function read(int $id) : void
    {
        $notification = Notification::where('id', '=', $id)->first();
        $notification->is_read = 1;
        $notification->save();
    }
}
