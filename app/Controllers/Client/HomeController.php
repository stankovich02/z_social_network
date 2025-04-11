<?php

namespace App\Controllers\Client;

use App\Models\LikedPost;
use App\Models\Post;
use App\Models\RepostedPost;
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
        $viewedPosts = array_column(
            Database::table('viewed_posts')
                ->where('user_id', '=', session()->get('user')->id)
                ->get(),
            'post_id'
        );
        $followedUsers = array_column(
            Database::table(UserFollower::TABLE)
                ->where('user_id', '=', session()->get('user')->id)
                ->get(),
            'follower_id'
        );
        $posts = Post::with('user','image')
                     ->where('user_id', '!=', session()->get('user')->id);
        if (count($followedUsers) > 0) {
            $posts = $posts->whereNotIn('user_id', $followedUsers);
        }
        if(count($viewedPosts) > 0){
            $posts = $posts->whereNotIn('id', $viewedPosts);
        }
        if (count($blockedUsers) > 0) {
            $posts = $posts->whereNotIn('user_id', $blockedUsers);
        }
        if (count($usersWhoBlockLoggedInUser) > 0) {
            $posts = $posts->whereNotIn('user_id', $usersWhoBlockLoggedInUser);
        }
        $posts = $posts->orderBy('id', 'desc')->take(10)
              ->get();
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
            $post->user->loggedInUserFollowing = in_array($post->user->id, $followedUsers);
        }

        return view('pages.client.home', [
            'posts' => $posts,
            'blockedUsers' => $blockedUsers,
            'usersWhoBlockLoggedInUser' => $usersWhoBlockLoggedInUser,
        ]);
    }
}
