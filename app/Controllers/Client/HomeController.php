<?php

namespace App\Controllers\Client;

use App\Models\LikedPost;
use App\Models\Nav;
use App\Models\Post;
use App\Models\User;
use App\Traits\CalculateDate;
use NovaLite\Http\Controller;

class HomeController extends Controller
{
    use CalculateDate;
    public function index()
    {
        $posts = Post::with('user','images')->orderBy('id', 'desc')->get();
        foreach ($posts as $post) {
            $post->created_at = $this->calculatePostedDate($post->created_at);
            $post->number_of_likes = $post->likesCount($post->id);
            $post->user_liked = LikedPost::where('user_id', '=', session()->get('user')->id)
                                          ->where('post_id', '=', $post->id)
                                          ->count();
        }
        return view('pages.client.home', [
            'posts' => $posts,
        ]);
    }
}
