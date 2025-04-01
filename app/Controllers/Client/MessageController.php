<?php

namespace App\Controllers\Client;

use App\Models\Message;
use App\Models\User;
use App\Traits\CalculateDate;
use NovaLite\Database\Database;
use NovaLite\Http\Controller;
use NovaLite\Http\Request;
use NovaLite\Http\Response;
use NovaLite\Views\View;

class MessageController extends Controller
{
    use CalculateDate;
    public function index(Request $request) : View|Response
    {
        if($request->isAjax()){
          $userId = $request->query('userId');
          $otherUserid = $request->query('otherUserId');
          $otherUser = User::with('followers')->where('id', '=', $otherUserid)->first();
          $sentMessages = Message::where('sent_from', '=', $userId)
                         ->where('sent_to', '=', $otherUserid)
                         ->orderBy('created_at', 'asc')
                         ->get();
          $receivedMessages = Message::where('sent_from', '=', $otherUserid)
                                 ->where('sent_to', '=', $userId)
                                 ->orderBy('created_at', 'asc')
                                 ->get();
          $messages = array_merge($sentMessages, $receivedMessages);
          usort($messages, function ($a, $b) {
              return strtotime($a->created_at) <=> strtotime($b->created_at);
          });
            $jsonMessages = [];
            foreach ($messages as $message) {
                $jsonMessages[] = [
                    'id' => $message->id,
                    'sent_from' => $message->sent_from,
                    'sent_to' => $message->sent_to,
                    'message' => $message->message,
                    'created_at' => $this->calculatePostedDate($message->created_at),
                ];
            }
            return \response()->json([
                'messages' => $jsonMessages,
                'otherUser' => [
                    'id' => $otherUser->id,
                    'full_name' => $otherUser->full_name,
                    'username' => $otherUser->username,
                    'biography' => $otherUser->biography,
                    'photo' => asset('assets/img/users/' . $otherUser->photo),
                    'profile_link' => route('profile', ['username' => $otherUser->username]),
                    'numOfFollowers' => count($otherUser->followers) !== 1 ? count($otherUser->followers) . ' Followers' : count($otherUser->followers) . ' Follower',
                    'joinedDate' =>  date('F Y', strtotime($otherUser->created_at))
                ]
            ]);
        }
        $loggedInUserId = session()->get('user')->id;
        $lastChats = Database::select("SELECT m1.*, 
       CASE 
           WHEN m1.sent_from = $loggedInUserId THEN m1.sent_to 
           ELSE m1.sent_from 
       END AS other_user_id
FROM messages m1
JOIN (
    SELECT 
        LEAST(sent_from, sent_to) AS user1, 
        GREATEST(sent_from, sent_to) AS user2, 
        MAX(created_at) AS last_message_time
    FROM messages
    WHERE sent_from = $loggedInUserId OR sent_to = $loggedInUserId
    GROUP BY user1, user2
) m2 ON (LEAST(m1.sent_from, m1.sent_to) = m2.user1 
         AND GREATEST(m1.sent_from, m1.sent_to) = m2.user2 
         AND m1.created_at = m2.last_message_time);
");
        foreach ($lastChats as $chat) {
            $chat->user = User::where('id', '=',$chat->other_user_id)->first();
            $chat->created_at = $this->calculatePostedDate($chat->created_at);
        }

        return view('pages.client.messages',[
            'chats' => $lastChats
        ]);
    }
}
