<?php

namespace App\Models;

use NovaLite\Database\Model;

class BlockedUser extends Model
{
	protected string $table = 'blocked_users';

    protected array $fillable = [
        'blocked_by_user_id',
        'blocked_user_id',
    ];
}
