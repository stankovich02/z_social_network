<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;

class NotificationType extends Model
{
	const TABLE = 'notification_types';

    protected string $table = self::TABLE;

    protected array $fillable = [
        'text',
        'icon_id',
    ];

    public function icon() : BelongsTo
    {
        return $this->belongsTo(Icon::class, 'icon_id', 'id');
    }

}
