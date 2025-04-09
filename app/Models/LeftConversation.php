<?php

namespace App\Models;

use NovaLite\Database\Model;

class LeftConversation extends Model
{
	const TABLE = 'left_conversations';

    protected string $table = self::TABLE;

    protected bool $timestamps = false;

    protected array $fillable = [
        'conversation_id',
        'user_id',
        'left_at'
    ];

}
