<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

class Conversation extends Model
{
    const TABLE = 'conversations';
    protected string $table = self::TABLE;
    protected array $fillable = [
        'user_id',
        'other_user_id',
        'last_message',
        'last_message_time'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function otherUser() : BelongsTo
    {
        return $this->belongsTo(User::class, 'other_user_id');
    }
}
