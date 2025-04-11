<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\HasOne;

class ViewedPost extends Model
{
	const TABLE = 'viewed_posts';

    protected string $table = self::TABLE;

    protected array $fillable = [
        'user_id',
        'post_id',
    ];
    protected bool $timestamps = false;

    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }
    public function post() : HasOne
    {
        return $this->hasOne(Post::class, 'post_id', 'id');
    }
}
