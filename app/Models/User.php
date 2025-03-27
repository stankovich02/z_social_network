<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;
use NovaLite\Database\Relations\HasMany;

class User extends Model
{
	const TABLE = 'users';

    protected string $table = self::TABLE;

    protected array $fillable = [
        'full_name',
        'email',
        'password',
        'username',
        'biography',
        'photo',
        'cover_photo',
        'token',
        'is_active',
        'role_id',
    ];

    protected array $hidden = [
        'password',
        'token',
    ];

    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function posts() : HasMany
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function repostedPosts() : HasMany
    {
        return $this->hasMany(RepostedPost::class, 'user_id');
    }
    public function likedPosts() : HasMany
    {
        return $this->hasMany(LikedPost::class, 'user_id');
    }
    public function notifications() : HasMany
    {
        return $this->hasMany(Notification::class, 'target_user_id');
    }
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
    public function likedComments() : HasMany
    {
        return $this->hasMany(LikedComment::class, 'user_id');
    }
    public function following() : HasMany
    {
        return $this->hasMany(UserFollower::class, 'user_id');
    }
    public function followers() : HasMany
    {
        return $this->hasMany(UserFollower::class, 'follower_id');
    }
}
