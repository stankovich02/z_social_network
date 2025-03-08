<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\HasMany;

class Icon extends Model
{
	const TABLE = 'icons';

    protected string $table = self::TABLE;

    protected array $fillable = [
        'divClass',
        'className',
        'path_d',
        'viewBox'
    ];

    public function navs() : HasMany
    {
        return $this->hasMany(Nav::class, 'icon_id', 'id');
    }

    public function notifications_types() : HasMany
    {
        return $this->hasMany(NotificationType::class, 'icon_id', 'id');
    }
}
