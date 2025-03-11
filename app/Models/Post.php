<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

class Post extends Model
{
	const TABLE = 'posts';

    protected string $table = self::TABLE;
    protected array $fillable = [
        'user_id',
        'content',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
