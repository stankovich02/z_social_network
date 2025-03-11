<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;
use NovaLite\Database\Relations\HasMany;

class Post extends Model
{
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
    public function images() : HasMany
    {
        return $this->hasMany(ImagePost::class, 'post_id', 'id');
    }
}
