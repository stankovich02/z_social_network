<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;
use NovaLite\Database\Relations\HasOne;

class UserFollower extends Model
{
	const TABLE = 'users_followers';

    protected string $table = self::TABLE;

    protected array $fillable = [
        'user_id',
        'follower_id'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function follower() : BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

}
