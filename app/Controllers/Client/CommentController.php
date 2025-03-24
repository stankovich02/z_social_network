<?php

namespace App\Controllers\Client;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\Post;
use App\Models\PostCommentNotification;
use App\Models\PostNotification;
use NovaLite\Http\Controller;
use NovaLite\Http\Request;

class CommentController extends Controller
{
    public function store(string $id, Request $request)
    {
        $comment = $request->input('comment');
        $newComment = [
            'post_id' => $id,
            'user_id' => session()->get('user')->id,
            'content' => $comment
        ];
        Comment::create($newComment);
        $insertedId = Comment::where('user_id', '=', $newComment['user_id'])->where('content', '=', $newComment['content'])->first()->id;
        $post = Post::with('user')->where('id', '=', $id)->first();
        if($post->user_id !== session()->get('user')->id){
            $newNotification = [
                'notification_type_id' => Notification::NOTIFICATION_TYPE_COMMENT,
                'user_id' => session()->get('user')->id,
                'target_user_id' => $post->user->id,
                'link' => route('post', ['username' => $post->user->username, 'id' => $post->id])
            ];
            Notification::create($newNotification);
            $notificationId = Notification::where('notification_type_id', '=', $newNotification['notification_type_id'])
                ->where('user_id', '=', $newNotification['user_id'])
                ->where('target_user_id', '=', $newNotification['target_user_id'])
                ->where('link', '=', $newNotification['link'])
                ->first()->id;
            PostCommentNotification::create([
                'comment_id' => $insertedId,
                'notification_id' => $notificationId
            ]);
        }
        return response()->json([
            'comment_id' => $insertedId,
            'post_link' => route('post', ['username' => $post->user->username, 'id' => $post->id]),
        ]);

    }
}
