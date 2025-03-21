<?php

namespace App\Controllers\Client;

use App\Models\LikedPost;
use App\Models\Post;
use App\Models\RepostedPost;
use App\Models\User;
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
        $repostedPosts = RepostedPost::with('user')->where('user_id', '=',$profileUser->id)->orderBy('created_at', 'desc')->get();
        foreach ($posts as $post) {
            $post->type = Post::ORIGINAL_POST;
        }
        foreach ($repostedPosts as $repostedPost) {
            $repostedPost->type = Post::REPOSTED_POST;
        }
        $mergedPosts = array_merge($posts, $repostedPosts);
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
            }
        }
        $countPosts = count($mergedPosts);
        $numOfPosts = ($countPosts == 0 || $countPosts > 1) ? $countPosts . ' posts' : $countPosts . ' post';

        $joinedDate = date('F Y', strtotime(session()->get('user')->created_at));
        $user = User::where('username', '=', $username)->first();
        return view('pages.client.profile', [
            'posts' => $mergedPosts,
            'numOfPosts' => $numOfPosts,
            'joinedDate' => $joinedDate,
            'user' => $user,
            'returnBackLink' => $_SERVER['HTTP_REFERER']
        ]);
    }
}
