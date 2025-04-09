<?php

namespace App\Controllers\Client;

use App\Models\Conversation;
use App\Models\LeftConversation;
use App\Models\Message;
use NovaLite\Database\Database;
use NovaLite\Http\Controller;
use NovaLite\Http\Request;

class ConversationController extends Controller
{
    public function destroy(int $id) : void
    {

        $leftConversation = LeftConversation::where('conversation_id', '=', $id)
            ->where('user_id', '=', session()->get('user')->id)
            ->first();

        if ($leftConversation) {
            Database::table(LeftConversation::TABLE)
                    ->where('conversation_id', '=', $id)
                    ->where('user_id', '=', session()->get('user')->id)
                    ->update([
                        'left_at' => date('Y-m-d H:i:s')]
                    );
        }
        else{
            LeftConversation::create([
                'conversation_id' => $id,
                'user_id' => session()->get('user')->id,
                'left_at' => date('Y-m-d H:i:s')
            ]);
        }

    }
}
