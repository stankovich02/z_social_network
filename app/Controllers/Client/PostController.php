<?php

namespace App\Controllers\Client;

use App\Models\ImagePost;
use App\Models\Post;
use App\Traits\CalculateDate;
use NovaLite\Http\Controller;
use NovaLite\Http\Request;

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
        $post = Post::with('user', 'images')->where('id', '=', $post->id)->first();
        $images = [];
        if($post->images){
            foreach ($post->images as $image) {
                $images[] = asset('assets/img/posts/' . $image->image);
            }
        }
        return response()->json([
            'id' => $post->id,
            'content' => $post->content,
            'created_at' => $this->calculatePostedDate($post->created_at),
            'images' => $images,
            'user' => [
                'id' => $post->user->id,
                'photo' => asset('assets/img/users/' . $post->user->photo),
                'username' => $post->user->username,
                'full_name' => $post->user->full_name,
            ]
        ]);
	}

	public function show(string $id)
	{
		//
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
		//
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
}
