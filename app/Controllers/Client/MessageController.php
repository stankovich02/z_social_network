<?php

namespace App\Controllers\Client;

use App\Models\Message;
use App\Models\User;
use App\Traits\CalculateDate;
use NovaLite\Database\Database;
use NovaLite\Http\Controller;
use NovaLite\Views\View;

class MessageController extends Controller
{
    use CalculateDate;
    public function index() : View
    {
    /*    $lastChats = Message::with('sender', 'receiver')
            ->where('sent_from', '=', session()->get('user')->id)
            ->orWhere('sent_to', '=', session()->get('user')->id)
            ->distinct()
            ->groupBy('sent_from')
            ->orderBy('created_at', 'desc')
            ->get();*/
        $lastChats = Database::select("SELECT m1.*, 
       CASE 
           WHEN m1.sent_from = 1 THEN m1.sent_to 
           ELSE m1.sent_from 
       END AS other_user_id
FROM messages m1
JOIN (
    SELECT 
        LEAST(sent_from, sent_to) AS user1, 
        GREATEST(sent_from, sent_to) AS user2, 
        MAX(created_at) AS last_message_time
    FROM messages
    WHERE sent_from = 1 OR sent_to = 1
    GROUP BY user1, user2
) m2 ON (LEAST(m1.sent_from, m1.sent_to) = m2.user1 
         AND GREATEST(m1.sent_from, m1.sent_to) = m2.user2 
         AND m1.created_at = m2.last_message_time);
");
        foreach ($lastChats as $chat) {
            $chat->user = User::where('id', '=',$chat->other_user_id)->first();
            $chat->created_at = $this->calculatePostedDate($chat->created_at);
        }
  /*      $sentMessages = Message::where('sent_from', '=', 1)
                           ->where('sent_to', '=', 2)
                           ->orderBy('created_at', 'asc')
                           ->get();

        $receivedMessages = Message::where('sent_from', '=', 2)
                           ->where('sent_to', '=', 1)
                           ->orderBy('created_at', 'asc')
                           ->get();
        $messages = array_merge($sentMessages, $receivedMessages);
        usort($messages, function ($a, $b) {
            return strtotime($b->created_at) <=> strtotime($a->created_at);
        });*/

        return view('pages.client.messages',[
            'chats' => $lastChats
        ]);
    }
}
