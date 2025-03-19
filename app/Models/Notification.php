<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

class Notification extends Model
{
    const TABLE = 'notifications';

    const NOTIFICATION_TYPE_LIKE = 1;
    const NOTIFICATION_TYPE_REPOST = 2;
    const NOTIFICATION_TYPE_LIKED_REPLY = 3;
    const NOTIFICATION_TYPE_FOLLOW = 4;
    const NOTIFICATION_TYPE_COMMENT = 5;


    protected string $table = self::TABLE;

    protected array $fillable = [
        'notification_type_id',
        'user_id',
        'target_user_id',
        'link',
        'is_read'
    ];

    protected bool $timestamps = false;
    public function notificationType() : BelongsTo
    {
        return $this->belongsTo(NotificationType::class, 'notification_type_id');
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function targetUser() : BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }
}
