<?php

namespace App\Controllers\Client;

use App\Models\BlockedUser;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\RepostedPost;
use App\Models\User;
use App\Models\UserFollower;
use App\Traits\Calculate;
use NovaLite\Database\Database;
use NovaLite\Http\Controller;
use NovaLite\Http\RedirectResponse;
use NovaLite\Views\View;

class ProfileController extends Controller
{
    use Calculate;
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
        $matchedFollowers = [];

        $user->joinedDate = date('F Y', strtotime($user->created_at));
        foreach ($user->posts as $post) {
            $post->type = Post::ORIGINAL_POST;
            $post->content = preg_replace('/#(\w+)/', '<span class="hashtag">#$1</span>', $post->content);
            $post->views = $this->calculateStatNumber($post->views);
        }

        foreach ($user->repostedPosts as $repostedPost) {
            $repostedPost->type = Post::REPOSTED_POST;
            $repostedPost->post->content = preg_replace('/#(\w+)/', '<span class="hashtag">#$1</span>', $repostedPost->post->content);
            $repostedPost->views = $this->calculateStatNumber($repostedPost->views);
        }
        if($username !== session()->get('user')->username) {
            $loggedInUserFollowing = array_column(
                Database::table(UserFollower::TABLE)
                    ->where('user_id', '=', session()->get('user')->id)
                    ->get(),
                'follower_id'
            );
            $profileUserFollowers = array_column(
                Database::table(UserFollower::TABLE)
                    ->where('follower_id', '=', $user->id)
                    ->get(),
                'user_id'
            );
            $matched = array_intersect($loggedInUserFollowing, $profileUserFollowers);
            foreach ($matched as $id) {
                $matchedUser = User::where('id', '=', $id)->first();
                $matchedFollowers[] = [
                    'full_name' => $matchedUser->full_name,
                    'photo' => asset('assets/img/users/' . $matchedUser->photo),
                ];
            }
            $matchedText = '';
            $numOfRemaining = count($matchedFollowers) - 2;
            $others = $numOfRemaining != 1 ? "$numOfRemaining others" : "$numOfRemaining other";
            switch (count($matchedFollowers)) {
                case 0:
                    $matchedText = "Not followed by anyone you’re following";
                    break;
                case 1:
                    $matchedText = 'Followed by ' . $matchedFollowers[0]['full_name'];
                    break;
                case 2:
                    $matchedText = 'Followed by ' . $matchedFollowers[0]['full_name'] . ' and ' . $matchedFollowers[1]['full_name'];
                    break;
                default:
                    $matchedText = 'Followed by ' . $matchedFollowers[0]['full_name'] . ', ' . $matchedFollowers[1]['full_name'] . ' and ' . $others . ' you follow';
            }
        }
        if($user->posts && $user->repostedPosts) {
            $mergedPosts = array_merge($user->posts, $user->repostedPosts);
        }
        else if($user->posts) {
            $mergedPosts = $user->posts;
        }
        else if($user->repostedPosts) {
            $mergedPosts = $user->repostedPosts;
        }
        else {
            $mergedPosts = [];
        }
        usort($mergedPosts, function ($a, $b) {
            return strtotime($b->created_at) <=> strtotime($a->created_at);
        });
        foreach ($mergedPosts as $mergedPost) {
            if($mergedPost->type == Post::ORIGINAL_POST) {
                $mergedPost->created_at = $this->calculatePostedDate($mergedPost->created_at);
                $mergedPost->number_of_likes = $this->calculateStatNumber($mergedPost->likesCount($mergedPost->id));
                $mergedPost->user_liked = LikedPost::where('user_id', '=', session()->get('user')->id)
                    ->where('post_id', '=', $mergedPost->id)
                    ->count();
                $mergedPost->number_of_reposts = $this->calculateStatNumber($mergedPost->repostsCount($mergedPost->id));

                $mergedPost->user_reposted = RepostedPost::where('user_id', '=', session()->get('user')->id)
                    ->where('post_id', '=', $mergedPost->id)
                    ->count();
                $mergedPost->number_of_comments = $this->calculateStatNumber($mergedPost->commentsCount($mergedPost->id));
            }
            if($mergedPost->type == Post::REPOSTED_POST) {
                $mergedPost->post = Post::with('user','image')->where('id', '=', $mergedPost->post_id)->first();
                $mergedPost->post->created_at = $this->calculatePostedDate($mergedPost->post->created_at);
                $mergedPost->post->number_of_likes = $this->calculateStatNumber($mergedPost->post->likesCount($mergedPost->post->id));
                $mergedPost->post->user_liked = LikedPost::where('user_id', '=', session()->get('user')->id)
                    ->where('post_id', '=', $mergedPost->post->id)
                    ->count();
                $mergedPost->post->number_of_reposts = $this->calculateStatNumber($mergedPost->post->repostsCount($mergedPost->post->id));
                $mergedPost->post->user_reposted = RepostedPost::where('user_id', '=', session()->get('user')->id)
                    ->where('post_id', '=', $mergedPost->post->id)
                    ->count();
                $mergedPost->post->number_of_comments = $this->calculateStatNumber($mergedPost->post->commentsCount($mergedPost->post->id));
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
            'user' => $user,
            'matchedText' => $matchedText ?? '',
            'matchedFollowers' => $matchedFollowers ?? [],
            'userBlockedLoggedInUser' => $userBlockedLoggedInUser,
            'loggedInUserBlockedUser' => in_array($user->id, $blockedUsers),
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
        $loggedInUserFollowers = array_column(
            Database::table(UserFollower::TABLE)
                ->where('follower_id', '=', session()->get('user')->id)
                ->get(),
            'user_id'
        );
        if($username !== session()->get('user')->username) {
            $profileUserFollowers = array_column(
                Database::table(UserFollower::TABLE)
                    ->where('follower_id', '=', $user->id)
                    ->get(),
                'user_id'
            );
            $matched = array_intersect($userFollowing, $profileUserFollowers);
        }
        foreach ($user->followers as $follower) {
            $follower->user->loggedInUserFollowsFollower = in_array($follower->user->id, $userFollowing);
        }
        return view('pages.client.profile.followers', [
            'user' => $user,
            'matchedFollowers' => $matched ?? [],
            'loggedInUserFollowers' => $loggedInUserFollowers,
        ]);
    }
    public function following(string $username) : View
    {
        $userFollowing = array_column(
            Database::table(UserFollower::TABLE)
                ->where('user_id', '=', session()->get('user')->id)
                ->get(),
            'follower_id'
        );
        $user = User::with('following', 'following.follower')
                    ->where('username', '=', $username)
                    ->first();
        $loggedInUserFollowers = array_column(
            Database::table(UserFollower::TABLE)
                ->where('follower_id', '=', session()->get('user')->id)
                ->get(),
            'user_id'
        );
        if($username !== session()->get('user')->username) {
            $profileUserFollowers = array_column(
                Database::table(UserFollower::TABLE)
                    ->where('follower_id', '=', $user->id)
                    ->get(),
                'user_id'
            );
            $matched = array_intersect($userFollowing, $profileUserFollowers);
        }
        foreach ($user->following as $following) {
            $following->follower->loggedInUserFollowsUser = in_array($following->follower->id, $userFollowing);
        }
        return view('pages.client.profile.following', [
            'user' => $user,
            'matchedFollowers' => $matched ?? [],
            'loggedInUserFollowers' => $loggedInUserFollowers,
        ]);
    }

    public function followersYouFollow(string $username) : View
    {
        $user = User::with('following', 'following.follower')
            ->where('username', '=', $username)
            ->first();
        $userFollowing = array_column(
            Database::table(UserFollower::TABLE)
                ->where('user_id', '=', session()->get('user')->id)
                ->get(),
            'follower_id'
        );
        $loggedInUserFollowers = array_column(
            Database::table(UserFollower::TABLE)
                ->where('follower_id', '=', session()->get('user')->id)
                ->get(),
            'user_id'
        );
        if($username !== session()->get('user')->username) {
            $profileUserFollowers = array_column(
                Database::table(UserFollower::TABLE)
                    ->where('follower_id', '=', $user->id)
                    ->get(),
                'user_id'
            );
            $matched = array_intersect($userFollowing, $profileUserFollowers);
            if(count($matched) > 0) {
                $matchedFollowers = User::with('role')
                    ->whereIn('id', $matched)
                    ->get();
            }
        }

        return view('pages.client.profile.followers-you-follow', [
            'user' => $user,
            'matchedFollowers' => $matchedFollowers ?? [],
            'loggedInUserFollowers' => $loggedInUserFollowers,
        ]);
    }
}
