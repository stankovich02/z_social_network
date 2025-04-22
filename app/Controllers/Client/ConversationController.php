<?php

namespace App\Controllers\Client;

use App\Models\Conversation;
use App\Models\LeftConversation;
use App\Models\Message;
use App\Models\User;
use App\Traits\Calculate;
use NovaLite\Database\Database;
use NovaLite\Http\Controller;
use NovaLite\Http\Request;
use NovaLite\Http\Response;

class ConversationController extends Controller
{
    use Calculate;
    public function searchNewConversation(Request $request) : Response
    {
        $query = $request->query('query');
        $loggedInUserId = session()->get('user')->id;
        $lastChats = Conversation::with('user', 'otherUser')->whereGroup(function ($q) use ($loggedInUserId) {
            $q->where('user_id', '=', $loggedInUserId)
                ->orWhere('other_user_id', '=', $loggedInUserId);
        })->orderBy('last_message_time', 'DESC')
            ->get();
        $usersArray = [];
        $userIds = [];
        foreach ($lastChats as $chat) {
            $otherUserRelation = $chat->user_id == $loggedInUserId ? 'otherUser' : 'user';
            if(str_contains($chat->$otherUserRelation->username, $query) || (str_contains($chat->$otherUserRelation->full_name, $query))){
                $usersArray[] = [
                    'id' => $chat->$otherUserRelation->id,
                    'username' => $chat->$otherUserRelation->username,
                    'full_name' => $chat->$otherUserRelation->full_name,
                    'photo' => asset('assets/img/users/' . $chat->$otherUserRelation->photo),
                ];
                $userIds[] = $chat->$otherUserRelation->id;
            }
        }
        $otherUsers = User::where('id', '!=', $loggedInUserId)
                          ->whereGroup(function ($q) use ($query) {
                            $q->where('username', 'like', "%{$query}%")
                              ->orWhere('full_name', 'like', "%{$query}%");
                        })->whereNotIn('id', $userIds)
                          ->get();
        foreach ($otherUsers as $otherUser) {
            $usersArray[] = [
                'id' => $otherUser->id,
                'username' => $otherUser->username,
                'full_name' => $otherUser->full_name,
                'photo' => asset('assets/img/users/' . $otherUser->photo),
            ];
        }
        return response()->json($usersArray);
    }

    public function searchDirectMessages(Request $request) : Response
    {
        $query = $request->query('query');
        $loggedInUserId = session()->get('user')->id;
        $peopleArray = [];
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
        $lastChats = $lastChats->orderBy('last_message_time', 'DESC')
            ->get();
        if(strlen($query) > 2){
            foreach ($lastChats as $chat) {
                if($chat->user_id == $loggedInUserId){
                    $chat->user = User::where('id', '=', $chat->other_user_id)->first();
                }else{
                    $chat->user = User::where('id', '=', $chat->user_id)->first();
                }
                if(str_contains($chat->user->username, $query) || (str_contains($chat->user->full_name, $query))){
                    $peopleArray[] = [
                        'conversation_link' => route('messages.conversation', ['id' => $chat->id]),
                        'id' => $chat->user->id,
                        'username' => $chat->user->username,
                        'full_name' => $chat->user->full_name,
                        'photo' => asset('assets/img/users/' . $chat->user->photo),
                    ];
                }
            }
        }
        $messagesArray = [];
        $messages = Message::with('conversation','sender','receiver', 'conversation.leftConversations')
            ->whereGroup(function ($q) use ($loggedInUserId) {
                $q->where('sent_from', '=', $loggedInUserId)
                    ->orWhere('sent_to', '=', $loggedInUserId);
            })
            ->where('message', 'like', "%{$query}%")
            ->orderBy('created_at', 'DESC')
            ->get();
        foreach ($messages as $message) {
            if(in_array($message->conversation->id, $leftConversationsIds)){
                foreach ($message->conversation->leftConversations as $leftConversation) {
                    if($leftConversation->user_id == $loggedInUserId && $leftConversation->is_active == 1){
                        if($message->created_at > $leftConversation->left_at){
                            $messagesArray[] = [
                                'conversation_link' => route('messages.conversation', ['id' => $message->conversation->id]),
                                'id' => $message->id,
                                'username' => $message->sent_from == $loggedInUserId ? $message->receiver->username : $message->sender->username,
                                'full_name' => $message->sent_from == $loggedInUserId ? $message->receiver->full_name : $message->sender->full_name,
                                'photo' => $message->sent_from == $loggedInUserId ? asset('assets/img/users/' . $message->receiver->photo) : asset('assets/img/users/' . $message->sender->photo),
                                'message' => $message->message,
                                'created_at' => $this->calculateMessageDate($message->created_at),
                            ];
                        }
                    }
                }
            }
            else{
                $messagesArray[] = [
                    'conversation_link' => route('messages.conversation', ['id' => $message->conversation->id]),
                    'id' => $message->id,
                    'username' => $message->sent_from == $loggedInUserId ? $message->receiver->username : $message->sender->username,
                    'full_name' => $message->sent_from == $loggedInUserId ? $message->receiver->full_name : $message->sender->full_name,
                    'photo' => $message->sent_from == $loggedInUserId ? asset('assets/img/users/' . $message->receiver->photo) : asset('assets/img/users/' . $message->sender->photo),
                    'message' => $message->message,
                    'created_at' => $this->calculateMessageDate($message->created_at),
                ];
            }
        }
        return response()->json([
            'people' => $peopleArray,
            'messages' => $messagesArray
        ]);

    }
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
                        'left_at' => date('Y-m-d H:i:s'),
                        'is_active' => 0
                        ]
                    );
        }
        else{
            LeftConversation::create([
                'conversation_id' => $id,
                'user_id' => session()->get('user')->id,
                'left_at' => date('Y-m-d H:i:s'),
                'is_active' => 0
            ]);
        }

    }
}
