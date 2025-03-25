<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

class LikedComment extends Model
{
	const TABLE = 'liked_comments';
    protected string $table = self::TABLE;
    protected array $fillable = ['comment_id', 'user_id'];
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function comment() : BelongsTo
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }
}
