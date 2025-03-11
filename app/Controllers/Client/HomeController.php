<?php

namespace App\Controllers\Client;

use App\Models\Nav;
use App\Models\Post;
use App\Traits\CalculateDate;
use NovaLite\Http\Controller;

class HomeController extends Controller
{
    use CalculateDate;
    public function index()
    {
        $posts = Post::with('user')->orderBy('id', 'desc')->get();
        foreach ($posts as $post) {
            $post->created_at = $this->calculatePostedDate($post->created_at);
        }
        return view('pages.client.home', [
            'posts' => $posts,
        ]);
    }
}
