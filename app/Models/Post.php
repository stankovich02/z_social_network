<?php

namespace App\Models;

use App\Traits\Calculate;
use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;
use NovaLite\Database\Relations\HasMany;
use NovaLite\Database\Relations\HasOne;

class Post extends Model
{
    use Calculate;
    const ORIGINAL_POST = 'original_post';
    const REPOSTED_POST = 'reposted_post';

	const TABLE = 'posts';

    protected string $table = self::TABLE;

    protected array $fillable = [
        'user_id',
        'content',
        'views',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function image() : HasOne
    {
        return $this->hasOne(ImagePost::class, 'post_id', 'id');
    }
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
    public function likes() : HasMany
    {
        return $this->hasMany(LikedPost::class, 'post_id', 'id');
    }
    public function reposts() : HasMany
    {
        return $this->hasMany(RepostedPost::class, 'post_id', 'id');
    }
    public function views(): HasMany
    {
        return $this->hasMany(ViewedPost::class, 'post_id', 'id');
    }
    public function likesCount(int $id) : int
    {
        return LikedPost::where('post_id', '=', $id)->count();
    }
    public function repostsCount(int $id) : int
    {
        return RepostedPost::where('post_id', '=', $id)->count();
    }
    public function commentsCount(int $id) : int
    {
        return Comment::where('post_id', '=', $id)->count();
    }
    public function makePosts($posts, $followedUsers) : array
    {
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
        return $posts;
    }
}
