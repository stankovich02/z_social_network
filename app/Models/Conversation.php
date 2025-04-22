<?php

namespace App\Models;

use NovaLite\Database\Database;
use NovaLite\Database\Model;
use NovaLite\Database\Relations\BelongsTo;
use NovaLite\Database\Relations\HasMany;

class Conversation extends Model
{
    const TABLE = 'conversations';

    protected string $table = self::TABLE;

    protected array $fillable = [
        'user_id',
        'other_user_id',
        'last_message',
        'last_message_time'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function otherUser() : BelongsTo
    {
        return $this->belongsTo(User::class, 'other_user_id');
    }

    public function leftConversations(): HasMany
    {
        return $this->hasMany(LeftConversation::class, 'conversation_id');
    }
    public function lastChats() : array
    {
        $loggedInUserId = session()->get('user')->id;
        $leftConversations = Database::table(LeftConversation::TABLE)
            ->where('user_id', '=', $loggedInUserId)
            ->where('is_active', '=', 0)
            ->get();
        $leftConversationsIds = array_column($leftConversations, 'conversation_id');
        $lastChats = Conversation::whereGroup(function ($q) use ($loggedInUserId) {
            $q->where('user_id', '=', $loggedInUserId)
                ->orWhere('other_user_id', '=', $loggedInUserId);
        });
        if($leftConversationsIds){
            $lastChats = $lastChats->whereNotIn('id', $leftConversationsIds);
        }
       return $lastChats->orderBy('last_message_time', 'DESC')
            ->get();
    }
}
