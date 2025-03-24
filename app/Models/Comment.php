<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

class Comment extends Model
{
	const TABLE = 'comments';
    protected string $table = self::TABLE;
    protected array $fillable = [
        'post_id',
        'user_id',
        'content',
    ];
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
