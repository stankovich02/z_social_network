<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

class Nav extends Model
{
    const TABLE = 'navs';

    protected string $table = self::TABLE;

    protected array $fillable = [
        'name',
        'route',
        'icon_id',
    ];

    public function icon() : BelongsTo
    {
        return $this->belongsTo(Icon::class, 'icon_id', 'id');
    }
}
