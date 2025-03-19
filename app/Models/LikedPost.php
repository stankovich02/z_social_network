<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

class LikedPost extends Model
{
    const TABLE = 'liked_posts';
    protected string $table = self::TABLE;
    protected array $fillable = ['user_id', 'post_id'];
    protected bool $timestamps = false;

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
