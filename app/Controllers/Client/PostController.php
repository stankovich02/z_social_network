<?php

namespace App\Controllers\Client;

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
        $post = Post::with('user')->orderBy('id', 'desc')->first();
        return response()->json([
            'id' => $post->id,
            'content' => $post->content,
            'created_at' => $this->calculatePostedDate($post->created_at),
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
}
