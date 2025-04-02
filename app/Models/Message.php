<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

class Message extends Model
{
	const TABLE = 'messages';

    protected string $table = self::TABLE;

    protected array $fillable = [
        'sent_from',
        'sent_to',
        'message',
        'is_read',
    ];

    public function sender() : BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_from');
    }

    public function receiver() : BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_to');
    }
    public function conversation() : BelongsTo
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }
}
