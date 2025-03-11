<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\HasMany;

class Role extends Model
{
	const TABLE = 'roles';

    protected string $table = self::TABLE;

    protected array $fillable = [
        'name'
    ];

    public function users() : HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
