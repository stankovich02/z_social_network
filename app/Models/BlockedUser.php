<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

class BlockedUser extends Model
{
	protected string $table = 'blocked_users';

    protected array $fillable = [
        'blocked_by_user_id',
        'blocked_user_id',
    ];
    public function blockedByUser() : BelongsTo
    {
        return $this->belongsTo(User::class, 'blocked_by_user_id');
    }
    public function blockedUser() : BelongsTo
    {
        return $this->belongsTo(User::class, 'blocked_user_id');
    }
}
