<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

class LeftConversation extends Model
{
	const TABLE = 'left_conversations';

    protected string $table = self::TABLE;

    protected bool $timestamps = false;

    protected array $fillable = [
        'conversation_id',
        'user_id',
        'left_at',
        'is_active'
    ];

    public function conversation() : BelongsTo
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'id');
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
