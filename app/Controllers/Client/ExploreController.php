<?php

namespace App\Controllers\Client;

use App\Models\LikedPost;
use App\Models\Post;
use App\Models\RepostedPost;
use App\Models\User;
use App\Models\UserFollower;
use App\Traits\Calculate;
use NovaLite\Database\Database;
use NovaLite\Http\Controller;
use NovaLite\Http\Request;
use NovaLite\Http\Response;
use NovaLite\Views\View;

class ExploreController extends Controller
{
    use Calculate;
    public function index(Request $request) : View
    {
        $filter = "top";
        $query = $request->query('q');
        if($request->query('filter')){
            $filter = $request->query('filter');
        }
        $words = explode(" ", $query);
        if($query && ($filter === "top" || $filter === "people")){
            if((str_contains($words[0], '#') && strlen($words[0]) > 3) || (!str_contains($words[0], '#') && strlen
                    ($words[0]) > 2)){
                $users = User::with('followers');
                foreach ($words as $index => $word) {
                    if(str_contains($word, '#')){
                        $word = str_replace('#', '', $word);
                    }
                    if(strlen($word) > 2){
                        if ($index === 0) {
                            $users->whereGroup(function ($q) use ($word) {
                                $q->where('username', 'like', "%{$word}%")
                                    ->orWhere('full_name', 'like', "%{$word}%");
                            });
                        } else {
                            $users->orWhereGroup(function ($q) use ($word) {
                                $q->where('username', 'like', "%{$word}%")
                                    ->orWhere('full_name', 'like', "%{$word}%");
                            });
                        }
                    }
                }
                $users = $users->where('id', '!=', session()->get('user')->id)
                    ->get();
                foreach ($users as $user) {
                    $user->followers_count = count($user->followers);
                }
                usort($users, function ($a, $b) {
                    return $b->followers_count <=> $a->followers_count;
                });
            }
        }
        if($query && ($filter === "top" || $filter === "latest" || $filter === "posts")){
            $posts = Post::with('user', 'image');
            $userIds = [];
            foreach ($words as $index => $word) {
                if(strlen($word) > 1){
                    if ($index === 0) {
                        $posts->where('content', 'like', "%{$word}%");
                    } else {
                        $posts->orWhere('content', 'like', "%{$word}%");
                    }
                }
                if(str_contains($word, '#')){
                    $word = str_replace('#', '', $word);
                }
                if(strlen($word) > 2){
                    $usersWithWord = array_column(
                       Database::table('users')
                               ->where('username', 'like', "%{$word}%")
                               ->orWhere('full_name', 'like', "%{$word}%")
                               ->get(),
                        'id'
                    );
                    if(count($usersWithWord) > 0){
                        foreach ($usersWithWord as $userId) {
                            if(!in_array($userId, $userIds)){
                                $userIds[] = $userId;
                            }
                        }
                    }
                }

            }
            if(count($userIds) > 0){
                $posts = $posts->whereIn('user_id', $userIds);
            }
            if($filter === "latest"){
                $posts = $posts->orderBy('created_at', 'desc');
            }
            else{
                $posts = $posts->orderBy('views', 'desc');
            }
            $posts = $posts->get();
            $followedUsers = array_column(
                Database::table(UserFollower::TABLE)
                    ->where('user_id', '=', session()->get('user')->id)
                    ->get(),
                'follower_id'
            );
            foreach ($posts as $post) {
                $post->created_at = $this->calculatePostedDate($post->created_at);
                $post->number_of_likes = $this->calculateStatNumber($post->likesCount($post->id));
                $post->user_liked = LikedPost::where('user_id', '=', session()->get('user')->id)
                    ->where('post_id', '=', $post->id)
                    ->count();
                $post->number_of_reposts = $this->calculateStatNumber($post->repostsCount($post->id));
                $post->user_reposted = RepostedPost::where('user_id', '=', session()->get('user')->id)
                    ->where('post_id', '=', $post->id)
                    ->count();
                $post->number_of_comments = $this->calculateStatNumber($post->commentsCount($post->id));
                $post->views = $this->calculateStatNumber($post->views);
                $post->content = preg_replace('/#(\w+)/', '<span class="hashtag">#$1</span>', $post->content);
                $post->user->loggedInUserFollowing = in_array($post->user->id, $followedUsers);
            }
        }

        return view('pages.client.explore', [
            'query' => $query,
            'filter' => $filter,
            'users' => $users ?? [],
            'posts' => $posts ?? [],
        ]);
    }
    public function search(Request $request) : Response
    {
        $search = $request->input('search');
        if(strlen($search) > 2){
            $users = User::where('username', 'like', "%{$search}%")
                ->orWhere('full_name', 'like', "%{$search}%")
                ->where('id','!=', session()->get('user')->id)->get();
            $response = [];
            if($users) {
                foreach ($users as $user) {
                    $response[] = [
                        'id' => $user->id,
                        'username' => $user->username,
                        'full_name' => $user->full_name,
                        'photo' => asset('assets/img/users/' . $user->photo),
                        'profile_url' => route('profile', ['username' => $user->username])
                    ];
                }
            }
            return response()->json([
                'users' => $response,
                'searchPage' => route('explore'),
            ]);
        }
        else{
            return response()->json([
                'users' => [],
                'searchPage' => route('explore'),
            ]);
        }
    }
}
