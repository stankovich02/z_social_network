<?php

namespace App\Models;

use NovaLite\Database\Model;

class UserFollower extends Model
{
	const TABLE = 'users_followers';

    protected string $table = self::TABLE;

    protected array $fillable = [
        'user_id',
        'follower_id'
    ];

}
