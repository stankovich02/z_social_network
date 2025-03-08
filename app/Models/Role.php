<?php

namespace App\Models;

use NovaLite\Database\Model;

class Role extends Model
{
	const TABLE = 'roles';

    protected string $table = self::TABLE;

    protected array $fillable = [
        'name'
    ];
}
