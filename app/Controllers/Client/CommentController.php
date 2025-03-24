<?php

namespace App\Controllers\Client;

use App\Models\Comment;
use App\Models\Post;
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
        return response()->json([
            'comment_id' => $insertedId,
            'post_link' => route('post', ['username' => $post->user->username, 'id' => $post->id]),
        ]);

    }
}
