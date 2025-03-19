<?php

namespace App\Controllers\Client;

use App\Models\LikedPost;
use App\Models\Post;
use App\Models\User;
use App\Traits\CalculateDate;
use NovaLite\Database\Database;
use NovaLite\Http\Controller;
use NovaLite\Http\RedirectResponse;

class ProfileController extends Controller
{
    use CalculateDate;
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
        $posts = Post::with('user','image')->where('user_id', '=',$profileUser->id)->orderBy('id','desc')->get();
        $numOfPosts = (count($posts) == 0 || count($posts) > 1) ? count($posts) . ' posts' : count($posts) . ' post';
        foreach ($posts as $post) {
            $post->created_at = $this->calculatePostedDate($post->created_at);
            $post->number_of_likes = $post->likesCount($post->id);
            $post->user_liked = LikedPost::where('user_id', '=', session()->get('user')->id)
                ->where('post_id', '=', $post->id)
                ->count();
        }
        $joinedDate = date('F Y', strtotime(session()->get('user')->created_at));
        $user = User::where('username', '=', $username)->first();
        return view('pages.client.profile', [
            'posts' => $posts,
            'numOfPosts' => $numOfPosts,
            'joinedDate' => $joinedDate,
            'user' => $user,
        ]);
    }
}
