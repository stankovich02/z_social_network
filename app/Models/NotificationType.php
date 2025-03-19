<?php

namespace App\Models;

use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;
use NovaLite\Database\Relations\HasMany;

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
    public function notifications() : HasMany
    {
        return $this->hasMany(Notification::class, 'notification_type_id');
    }

}
