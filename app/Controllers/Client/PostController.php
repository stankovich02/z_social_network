<?php

namespace App\Controllers\Client;

use App\Models\Comment;
use App\Models\ImagePost;
use App\Models\LikedComment;
use App\Models\LikedPost;
use App\Models\Notification;
use App\Models\Post;
use App\Models\PostNotification;
use App\Models\RepostedPost;
use App\Traits\CalculateDate;
use DateTime;
use NovaLite\Database\Database;
use NovaLite\Http\Controller;
use NovaLite\Http\RedirectResponse;
use NovaLite\Http\Request;
use NovaLite\Http\Response;
use NovaLite\Views\View;

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

	public function store(Request $request) : Response
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
                $image = asset('assets/img/posts/' .$post->image->image);
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

	public function show(string $id,Request $request,string $username = null) : View|Response|RedirectResponse
	{
        $post = Post::with('user', 'image','comments','comments.likes','comments.user')->where('id', '=', $id)->first();
        if($request->isAjax()){
            return response()->json([
                'post' => [
                    'id' => $post->id,
                    'user' => [
                        'id' => $post->user->id,
                        'photo' => asset('assets/img/users/' . $post->user->photo),
                        'username' => $post->user->username,
                        'full_name' => $post->user->full_name,
                    ],
                    'image' => $post->image ? asset('assets/img/posts/' . $post->image->image) : null,
                    'created_at' => $this->calculatePostedDate($post->created_at),
                    'content' => $post->content ?? null,
                ]
            ]);
        }
        $blockedUsers = array_column(
            Database::table('blocked_users')
                ->where('blocked_by_user_id', '=', session()->get('user')->id)
                ->get(),
            'blocked_user_id'
        );
        if(in_array($post->user->id, $blockedUsers)){
            return redirect()->to('home');
        }
        $post->number_of_likes = $post->likesCount($post->id);
        $post->user_liked = LikedPost::where('user_id', '=', session()->get('user')->id)
            ->where('post_id', '=', $post->id)
            ->count();
        $post->number_of_reposts = $post->repostsCount($post->id);
        $post->user_reposted = RepostedPost::where('user_id', '=', session()->get('user')->id)
            ->where('post_id', '=', $post->id)
            ->count();
        $post->number_of_comments = $post->commentsCount($post->id);
        $date = new DateTime($post->created_at);
        $postedOn = $date->format("g:i A - M j, Y");
        $splitDate = explode('-', $postedOn);
        $postedOnTime = $splitDate[0];
        $postedOnDate = $splitDate[1];
        $reposted = RepostedPost::where('user_id', '=', session()->get('user')->id)
                                ->where('post_id', '=', $post->id)
                                ->count();
        $post->comments = array_reverse($post->comments);
        foreach ($post->comments as $comment) {
            $comment->created_at = $this->calculatePostedDate($comment->created_at);
            $comment->userLiked = LikedComment::where('user_id', '=', session()->get('user')->id)
                                ->where('comment_id', '=', $comment->id)
                                ->count();
        }
		return view('pages.client.post', [
            'post' => $post,
            'blockedUsers' => $blockedUsers,
            'title' => $post->user->full_name . " on Z: \"" . $post->content . "\" / Z",
            'postedDate'=> ['time' => $postedOnTime, 'date' => $postedOnDate],
            'reposted' => $reposted > 0,
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

	public function destroy(string $id) : void
	{
        $post = Post::with('image')->where('id', '=', $id)->first();
        if($post->image){
            unlink(public_path('assets/img/posts/' . $post->image->image));
        }
        $notificationsForDelete = PostNotification::where('post_id', '=', $id)->get();
        foreach ($notificationsForDelete as $notification){
            Notification::delete($notification->notification_id);
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
    public function likePost(string $id) : Response
    {
        $alreadyLiked = LikedPost::where('user_id', '=', session()->get('user')->id)
            ->where('post_id', '=', $id)
            ->first();
        if($alreadyLiked){
            Database::table(LikedPost::TABLE)
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
                    $insertedId = Notification::where('notification_type_id', '=', $newNotification['notification_type_id'])
                        ->where('user_id', '=', $newNotification['user_id'])
                        ->where('target_user_id', '=', $newNotification['target_user_id'])
                        ->where('link', '=', $newNotification['link'])
                        ->first()->id;
                    PostNotification::create([
                        'post_id' => $post->id,
                        'notification_id' => $insertedId
                    ]);
                }
            }
        }
        $numOfLikes = LikedPost::where('post_id', '=', $id)->count();
        return response()->json([
            'likes' => $numOfLikes
        ]);
    }
    public function repostPost(string $id) : Response
    {
        $alreadyReposted = RepostedPost::where('user_id', '=', session()->get('user')->id)
            ->where('post_id', '=', $id)
            ->first();
        if($alreadyReposted){
            Database::table(RepostedPost::TABLE)
                ->where('post_id', '=', $id)
                ->where('user_id', '=', session()->get('user')->id)
                ->delete();
        }
        else{
            $repostedPost = [
                'user_id' => session()->get('user')->id,
                'post_id' => $id
            ];
            RepostedPost::create($repostedPost);
            $post = Post::with('user')->where('id', '=', $id)->first();
            if($post->user_id !== session()->get('user')->id){
                $newNotification = [
                    'notification_type_id' => Notification::NOTIFICATION_TYPE_REPOST,
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
                    $insertedId = Notification::where('notification_type_id', '=', $newNotification['notification_type_id'])
                        ->where('user_id', '=', $newNotification['user_id'])
                        ->where('target_user_id', '=', $newNotification['target_user_id'])
                        ->where('link', '=', $newNotification['link'])
                        ->first()->id;
                    PostNotification::create([
                        'post_id' => $post->id,
                        'notification_id' => $insertedId
                    ]);
                }
            }
        }
        $numOfReposts = RepostedPost::where('post_id', '=', $id)->count();
        return response()->json([
            'reposts' => $numOfReposts
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
