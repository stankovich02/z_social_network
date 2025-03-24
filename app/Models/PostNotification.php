<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

class PostNotification extends Model
{
	const TABLE = 'posts_notifications';
    protected string $table = self::TABLE;
    protected array $fillable = ['post_id', 'notification_id'];
    protected bool $timestamps = false;

    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
    public function notification() : BelongsTo
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }
}
