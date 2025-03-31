<?php

namespace App\Controllers\Client;

use App\Models\BlockedUser;
use App\Models\LikedPost;
use App\Models\Nav;
use App\Models\Post;
use App\Models\RepostedPost;
use App\Models\User;
use App\Models\UserFollower;
use App\Traits\CalculateDate;
use NovaLite\Database\Database;
use NovaLite\Http\Controller;
use NovaLite\Views\View;

class HomeController extends Controller
{
    use CalculateDate;
    public function index() : View
    {
        $posts = Post::with('user','image')->orderBy('id', 'desc')->take(7)->get();
        $loggedInUserFollowing =  array_column(
            Database::table(UserFollower::TABLE)
                ->where('user_id', '=', session()->get('user')->id)
                ->get(),
            'follower_id'
        );
        foreach ($posts as $post) {
            $post->created_at = $this->calculatePostedDate($post->created_at);
            $post->number_of_likes = $post->likesCount($post->id);
            $post->user_liked = LikedPost::where('user_id', '=', session()->get('user')->id)
                ->where('post_id', '=', $post->id)
                ->count();
            $post->number_of_reposts = $post->repostsCount($post->id);

            $post->user_reposted = RepostedPost::where('user_id', '=', session()->get('user')->id)
                                      ->where('post_id', '=', $post->id)
                                      ->count();
            $post->number_of_comments = $post->commentsCount($post->id);
            $post->user->loggedInUserFollowing = in_array($post->user->id, $loggedInUserFollowing);
        }
        $blockedUsers = array_column(
            Database::table('blocked_users')
                ->where('blocked_by_user_id', '=', session()->get('user')->id)
                ->get(),
            'blocked_user_id'
        );
        $usersWhoBlockLoggedInUser = array_column(
            Database::table('blocked_users')
                ->where('blocked_user_id', '=', session()->get('user')->id)
                ->get(),
            'blocked_by_user_id'
        );
        return view('pages.client.home', [
            'posts' => $posts,
            'blockedUsers' => $blockedUsers,
            'usersWhoBlockLoggedInUser' => $usersWhoBlockLoggedInUser,
        ]);
    }
}
