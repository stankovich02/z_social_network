<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;
use NovaLite\Database\Relations\HasMany;
use NovaLite\Database\Relations\HasOne;

class Post extends Model
{
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
    public function image() : HasMany
    {
        return $this->hasMany(ImagePost::class, 'post_id', 'id');
    }
    public function likes() : HasMany
    {
        return $this->hasMany(LikedPost::class, 'post_id', 'id');
    }
    public function reposts() : HasMany
    {
        return $this->hasMany(RepostedPost::class, 'post_id', 'id');
    }
    public function likesCount(int $id) : int
    {
        return LikedPost::where('post_id', '=', $id)->count();
    }
    public function repostsCount(int $id) : int
    {
        return RepostedPost::where('post_id', '=', $id)->count();
    }
}
