<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

class ImagePost extends Model
{
	const TABLE = 'image_posts';

    protected string $table = self::TABLE;
    protected array $fillable = [
        'post_id',
        'image',
    ];

    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
