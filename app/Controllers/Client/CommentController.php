<?php

namespace App\Controllers\Client;

use App\Models\Comment;
use App\Models\LikedComment;
use App\Models\Notification;
use App\Models\Post;
use App\Models\PostCommentNotification;
use App\Models\PostNotification;
use App\Traits\CalculateDate;
use NovaLite\Database\Database;
use NovaLite\Http\Controller;
use NovaLite\Http\Request;
use NovaLite\Http\Response;

class CommentController extends Controller
{
    use CalculateDate;
    public function store(string $id, Request $request)
    {
        $comment = $request->input('comment');
        $newComment = [
            'post_id' => $id,
            'user_id' => session()->get('user')->id,
            'content' => $comment
        ];

        Comment::create($newComment);
        $lastComment = Comment::where('user_id', '=', $newComment['user_id'])->where('content', '=', $newComment['content'])->first();
        $insertedId = $lastComment->id;
        $post = Post::with('user','comments')->where('id', '=', $id)->first();
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
                ->orderBy('id', 'desc')
                ->first()->id;
            PostCommentNotification::create([
                'comment_id' => $insertedId,
                'notification_id' => $notificationId
            ]);
        }
        if($request->input('singlePost')){
            return response()->json([
                'id' => $insertedId,
                'content' => $comment,
                'created_at' => $this->calculatePostedDate($lastComment->created_at),
                'numOfComments' => count($post->comments),
                'user' => [
                    'photo' => asset('assets/img/users/' . session()->get('user')->photo),
                    'username' => session()->get('user')->username,
                    'full_name' => session()->get('user')->full_name,
                ]
            ]);
        }
        return response()->json([
            'comment_id' => $insertedId,
            'post_link' => route('post', ['username' => $post->user->username, 'id' => $post->id]),
        ]);

    }
    public function destroy(string $id) : Response
    {
        $postId = Comment::where('id', '=', $id)->first()->post_id;
        $notificationForDelete = PostCommentNotification::where('comment_id', '=', $id)->get();
        foreach ($notificationForDelete as $notification){
            Notification::delete($notification->notification_id);
        }
        Comment::delete($id);
        $post = Post::with('comments')->where('id', '=', $postId)->first();
        return response()->json([
            'numOfComments' => count($post->comments)
        ]);
    }

    public function like(string $postId,string $commentId)
    {
        $alreadyLiked = LikedComment::where('user_id', '=', session()->get('user')->id)
            ->where('comment_id', '=', $commentId)
            ->first();
        if($alreadyLiked){
            Database::table(LikedComment::TABLE)
                ->where('comment_id', '=', $commentId)
                ->where('user_id', '=', session()->get('user')->id)
                ->delete();
        }
        else{
            $likedComment = [
                'user_id' => session()->get('user')->id,
                'comment_id' => $commentId
            ];
            LikedComment::create($likedComment);
            $comment = Comment::with('user','post')->where('id', '=', $commentId)->first();
            if($comment->user_id !== session()->get('user')->id){
                $newNotification = [
                    'notification_type_id' => Notification::NOTIFICATION_TYPE_LIKED_REPLY,
                    'user_id' => session()->get('user')->id,
                    'target_user_id' => $comment->user->id,
                    'link' => route('post', ['username' => $comment->user->username, 'id' => $comment->post->id])
                ];
                $notificationExist = Notification::where('notification_type_id', '=', $newNotification['notification_type_id'])
                    ->where('user_id', '=', $newNotification['user_id'])
                    ->where('target_user_id', '=', $newNotification['target_user_id'])
                    ->where('link', '=', $newNotification['link'])
                    ->first();
                if(!$notificationExist){
                    Notification::create($newNotification);
                    $insertedId = Notification::where('notification_type_id', '=', $newNotification['notification_type_id'])
                        ->where('user_id', '=', $newNotification['user_id'])
                        ->where('target_user_id', '=', $newNotification['target_user_id'])
                        ->where('link', '=', $newNotification['link'])
                        ->first()->id;
                    PostCommentNotification::create([
                        'comment_id' => $commentId,
                        'notification_id' => $insertedId
                    ]);
                }
            }
        }
        $numOfLikes = LikedComment::where('comment_id', '=', $commentId)->count();
        return response()->json([
            'likes' => $numOfLikes
        ]);
    }
}
