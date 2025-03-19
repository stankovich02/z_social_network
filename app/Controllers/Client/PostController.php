<?php

namespace App\Controllers\Client;

use App\Models\ImagePost;
use App\Models\LikedPost;
use App\Models\Notification;
use App\Models\Post;
use App\Traits\CalculateDate;
use DateTime;
use NovaLite\Database\Database;
use NovaLite\Http\Controller;
use NovaLite\Http\RedirectResponse;
use NovaLite\Http\Request;
use NovaLite\Http\Response;

class PostController extends Controller
{
    use CalculateDate;
	public function index()
	{
		//
	}

	public function create()
	{
		//
	}

	public function store(Request $request)
	{
		$newPost = $request->getAll();
        $newPost['user_id'] = session()->get('user')->id;
        Post::create($newPost);
        $post = Post::where('id', '>', 0)->orderBy('id', 'desc')->first();
        if($request->input('image')){
            $image = $request->input('image');
            $explodedImage = explode('/', $image);
            $imgName = end($explodedImage);
            $newImagePost = [
                'post_id' => $post->id,
                'image' => $imgName
            ];
            ImagePost::create($newImagePost);
        }
        $post = Post::with('user', 'image')->where('id', '=', $post->id)->first();
        $image = null;
        if($post->image){
                $image = asset('assets/img/posts/' .$post->image[0]->image);
        }
        return response()->json([
            'id' => $post->id,
            'content' => $post->content,
            'created_at' => $this->calculatePostedDate($post->created_at),
            'image' => $image,
            'post_link' => route('post', ['username' => $post->user->username, 'id' => $post->id]),
            'user' => [
                'id' => $post->user->id,
                'photo' => asset('assets/img/users/' . $post->user->photo),
                'username' => $post->user->username,
                'full_name' => $post->user->full_name,
            ]
        ]);
	}

	public function show(string $username, string $id)
	{
        $post = Post::with('user', 'image')->where('id', '=', $id)->first();
        $post->number_of_likes = $post->likesCount($post->id);
        $post->user_liked = LikedPost::where('user_id', '=', session()->get('user')->id)
            ->where('post_id', '=', $post->id)
            ->count();
        $date = new DateTime($post->created_at);
        $postedOn = $date->format("g:i A - M j, Y");
        $splitDate = explode('-', $postedOn);
        $postedOnTime = $splitDate[0];
        $postedOnDate = $splitDate[1];
		return view('pages.client.post', [
            'post' => $post,
            'title' => $post->user->full_name . " on Z: \"" . $post->content . "\" / Z",
            'postedDate'=> [
                'time' => $postedOnTime,
                'date' => $postedOnDate
            ],
            'returnBackLink' => $_SERVER['HTTP_REFERER']
        ]);
	}

	public function edit(string $id)
	{
		//
	}

	public function update(Request $request, string $id)
	{
		//
	}

	public function destroy(string $id)
	{
        $post = Post::with('image')->where('id', '=', $id)->first();
        if($post->image){
            unlink(public_path('assets/img/posts/' . $post->image[0]->image));
        }
		Post::delete($id);
	}
    public function registerView(Request $request) : void
    {
        $postId = $request->input('post_id');
        $post = Post::where('id', '=',$postId)->first();
        if ($post) {
            $post->views += 1;
            $post->save();
        }
    }
    public function likePost(string $id)
    {
        $alreadyLiked = LikedPost::where('user_id', '=', session()->get('user')->id)
            ->where('post_id', '=', $id)
            ->first();
        if($alreadyLiked){
            Database::table('liked_posts')
                     ->where('post_id', '=', $id)
                     ->where('user_id', '=', session()->get('user')->id)
                     ->delete();
        }
        else{
            $likedPost = [
                'user_id' => session()->get('user')->id,
                'post_id' => $id
            ];
            LikedPost::create($likedPost);
            $post = Post::with('user')->where('id', '=', $id)->first();
            if($post->user_id !== session()->get('user')->id){
                $newNotification = [
                    'notification_type_id' => Notification::NOTIFICATION_TYPE_LIKE,
                    'user_id' => session()->get('user')->id,
                    'target_user_id' => $post->user->id,
                    'link' => route('post', ['username' => $post->user->username, 'id' => $post->id])
                ];
                $notificationExist = Notification::where('notification_type_id', '=', $newNotification['notification_type_id'])
                    ->where('user_id', '=', $newNotification['user_id'])
                    ->where('target_user_id', '=', $newNotification['target_user_id'])
                    ->where('link', '=', $newNotification['link'])
                    ->first();
                if(!$notificationExist){
                    Notification::create($newNotification);
                }
            }
        }
        $numOfLikes = LikedPost::where('post_id', '=', $id)->count();
        return response()->json([
            'likes' => $numOfLikes
        ]);
    }
    public function navigateToPost(string $id) : Response
    {
        $post = Post::with('user')->where('id', '=',$id)->first();
        return response()->json([
            'post_link' => route('post', ['username' => $post->user->username, 'id' => $post->id])
        ]);
    }
}
