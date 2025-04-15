<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

class PostCommentNotification extends Model
{
	const TABLE = 'posts_comments_notifications';

    protected string $table = self::TABLE;

    protected array $fillable = ['comment_id', 'notification_id'];

    protected bool $timestamps = false;

    public function comment() : BelongsTo
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }
    public function notification() : BelongsTo
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }
}
