<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

class RepostedPost extends Model
{
	    const TABLE = 'reposted_posts';

    protected string $table = self::TABLE;

    protected array $fillable = [
        'post_id',
        'user_id',
    ];

    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
