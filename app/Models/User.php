<?php

namespace App\Models;

use NovaLite\Database\Model;

class User extends Model
{
	const TABLE = 'users';

    protected string $table = self::TABLE;

    protected array $fillable = [
        'full_name',
        'email',
        'password',
        'username',
        'biography',
        'photo',
        'cover_photo',
        'token',
        'is_active',
        'role_id',
    ];
}
