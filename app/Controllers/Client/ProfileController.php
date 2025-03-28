<?php

namespace App\Controllers\Client;

use App\Models\BlockedUser;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\RepostedPost;
use App\Models\User;
use App\Models\UserFollower;
use App\Traits\CalculateDate;
use NovaLite\Database\Database;
use NovaLite\Http\Controller;
use NovaLite\Http\RedirectResponse;
use NovaLite\Views\View;

class ProfileController extends Controller
{
    use CalculateDate;
    public function index(string $username) : View|RedirectResponse
    {
        $blockedUsers = array_column(
            Database::table('blocked_users')
                ->where('blocked_by_user_id', '=', session()->get('user')->id)
                ->get(),
            'blocked_user_id'
        );
        $user = User::with('posts','repostedPosts','posts.image','repostedPosts.user', 'repostedPosts.post', 'following', 'followers')->where('username', '=',
            $username)->first();
        $userBlockedLoggedInUser = BlockedUser::where('blocked_user_id', '=', session()->get('user')->id)
            ->where('blocked_by_user_id', '=', $user->id)
            ->count();
        if(in_array($user->id, $blockedUsers) || $userBlockedLoggedInUser) {
            return redirect()->to('home');
        }
        $joinedDate = date('F Y', strtotime(session()->get('user')->created_at));

        foreach ($user->posts as $post) {
            $post->type = Post::ORIGINAL_POST;
        }
        foreach ($user->repostedPosts as $repostedPost) {
            $repostedPost->type = Post::REPOSTED_POST;
        }
        $mergedPosts = array_merge($user->posts, $user->repostedPosts);
        usort($mergedPosts, function ($a, $b) {
            return strtotime($b->created_at) <=> strtotime($a->created_at);
        });
        foreach ($mergedPosts as $mergedPost) {
            if($mergedPost->type == Post::ORIGINAL_POST) {
                $mergedPost->created_at = $this->calculatePostedDate($mergedPost->created_at);
                $mergedPost->number_of_likes = $mergedPost->likesCount($mergedPost->id);
                $mergedPost->user_liked = LikedPost::where('user_id', '=', session()->get('user')->id)
                    ->where('post_id', '=', $mergedPost->id)
                    ->count();
                $mergedPost->number_of_reposts = $mergedPost->repostsCount($mergedPost->id);

                $mergedPost->user_reposted = RepostedPost::where('user_id', '=', session()->get('user')->id)
                    ->where('post_id', '=', $mergedPost->id)
                    ->count();
                $mergedPost->number_of_comments = $mergedPost->commentsCount($mergedPost->id);
            }
            if($mergedPost->type == Post::REPOSTED_POST) {
                $mergedPost->post = Post::with('user','image')->where('id', '=', $mergedPost->post_id)->first();
                $mergedPost->post->created_at = $this->calculatePostedDate($mergedPost->post->created_at);
                $mergedPost->post->number_of_likes = $mergedPost->post->likesCount($mergedPost->post->id);
                $mergedPost->post->user_liked = LikedPost::where('user_id', '=', session()->get('user')->id)
                    ->where('post_id', '=', $mergedPost->post->id)
                    ->count();
                $mergedPost->post->number_of_reposts = $mergedPost->post->repostsCount($mergedPost->post->id);
                $mergedPost->post->user_reposted = RepostedPost::where('user_id', '=', session()->get('user')->id)
                    ->where('post_id', '=', $mergedPost->post->id)
                    ->count();
                $mergedPost->post->number_of_comments = $mergedPost->post->commentsCount($mergedPost->post->id);
            }
        }
        $countPosts = count($mergedPosts);
        $numOfPosts = ($countPosts == 0 || $countPosts > 1) ? $countPosts . ' posts' : $countPosts . ' post';
        $user->mergedPosts = $mergedPosts;
        if($user->id !== session()->get('user')->id) {
            $userFollowLoggedInUser = UserFollower::where('user_id', '=', $user->id)
                ->where('follower_id', '=', session()->get('user')->id)
                ->count();
            $user->userFollowsLoggedInUser = $userFollowLoggedInUser;
            $loggedInUserFollowsUser = UserFollower::where('user_id', '=', session()->get('user')->id)
                ->where('follower_id', '=', $user->id)
                ->count();
            $user->loggedInUserFollowsUser = $loggedInUserFollowsUser;
        }
        return view('pages.client.profile', [
            'numOfPosts' => $numOfPosts,
            'joinedDate' => $joinedDate,
            'user' => $user
        ]);
    }

    public function followers(string $username) : View
    {
        $user = User::with('followers', 'followers.user')
                    ->where('username', '=', $username)
                    ->first();

        $userFollowing = array_column(
            Database::table(UserFollower::TABLE)
                ->where('user_id', '=', session()->get('user')->id)
                ->get(),
            'follower_id'
        );
        foreach ($user->followers as $follower) {
            $follower->user->loggedInUserFollowsFollower = in_array($follower->user->id, $userFollowing);

        }
        return view('pages.client.profile.followers', [
            'user' => $user
        ]);
    }

    public function following(string $username) : View
    {
        $user = User::with('following', 'following.follower')
                    ->where('username', '=', $username)
                    ->first();

        return view('pages.client.profile.following', [
            'user' => $user
        ]);
    }
}
