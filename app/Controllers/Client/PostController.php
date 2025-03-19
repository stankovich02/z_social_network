<?php

namespace App\Controllers\Client;

use App\Models\ImagePost;
use App\Models\Post;
use App\Traits\CalculateDate;
use DateTime;
use NovaLite\Http\Controller;
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
/*    public function getPostLink(Request $request) : Response
    {
        $postId = $request->query('postId');
        $post = Post::with('user')->where('id', '=',$postId)->first();
        return response()->json([
            'post_link' => route('post', ['username' => $post->user->username, 'id' => $post->id])
        ]);
    }*/
}
