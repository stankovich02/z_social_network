<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

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

    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
