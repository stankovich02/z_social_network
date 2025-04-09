<?php

namespace App\Controllers\Client;

use App\Models\BlockedUser;
use App\Models\Conversation;
use App\Models\LeftConversation;
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
        $loggedInUserId = session()->get('user')->id;
        $lastConversations = LeftConversation::where('user_id', '=', session()->get('user')->id)->get();
        $conversationsWithMessages = [];
        foreach ($lastConversations as $conversation) {
            $lastMessage = Message::where('conversation_id', '=', $conversation->id)
                                  ->orderBy('created_at', 'desc')
                                  ->first();
            if($lastMessage->created_at > $conversation->left_at){
                $conversationsWithMessages[] = $conversation;
            }
        }
        $leftConversationsIds = array_column($conversationsWithMessages, 'conversation_id');
        $lastChats = Conversation::whereGroup(function ($q) use ($loggedInUserId) {
            $q->where('user_id', '=', $loggedInUserId)
              ->orWhere('other_user_id', '=', $loggedInUserId);
        });
        if($leftConversationsIds){
            $lastChats = $lastChats->whereNotIn('id', $leftConversationsIds);
        }
        $lastChats = $lastChats->orderBy('last_message_time', 'DESC')
                               ->get();
        foreach ($lastChats as $chat) {
            if($chat->user_id == $loggedInUserId){
                $chat->user = User::where('id', '=', $chat->other_user_id)->first();
            }else{
                $chat->user = User::where('id', '=', $chat->user_id)->first();
            }
            if($chat->last_message_time){
                $lastMessage = Message::where('conversation_id', '=', $chat->id)
                    ->where('message', '=', $chat->last_message)
                    ->where('created_at', '=', $chat->last_message_time)
                    ->first();
                $chat->is_read = $lastMessage->is_read;
                $chat->sent_to = $lastMessage->sent_to;
                $chat->last_message_time = $this->calculateLastMessageDate($chat->last_message_time);
            }
        }
        return view('pages.client.messages.index',[
            'chats' => $lastChats
        ]);
    }

    public function conversation(int $id) : View
    {
        $loggedInUserId = session()->get('user')->id;
        $lastConversations = LeftConversation::where('user_id', '=', session()->get('user')->id)->get();
        $conversationsWithMessages = [];
        foreach ($lastConversations as $conversation) {
            $lastMessage = Message::where('conversation_id', '=', $conversation->id)
                ->orderBy('created_at', 'desc')
                ->first();
            if($lastMessage->created_at > $conversation->left_at){
                $conversationsWithMessages[] = $conversation;
            }
        }
        $leftConversationsIds = array_column($conversationsWithMessages, 'conversation_id');
        $lastChats = Conversation::whereGroup(function ($q) use ($loggedInUserId) {
            $q->where('user_id', '=', $loggedInUserId)
                ->orWhere('other_user_id', '=', $loggedInUserId);
        });
        if($leftConversationsIds){
            $lastChats = $lastChats->whereNotIn('id', $leftConversationsIds);
        }
        $lastChats = $lastChats->orderBy('last_message_time', 'DESC')
            ->get();
        foreach ($lastChats as $chat) {
            if($chat->user_id == $loggedInUserId){
                $chat->user = User::where('id', '=', $chat->other_user_id)->first();
            }else{
                $chat->user = User::where('id', '=', $chat->user_id)->first();
            }
            if($chat->last_message_time){
                $lastMessage = Message::where('conversation_id', '=', $chat->id)
                    ->where('message', '=', $chat->last_message)
                    ->where('created_at', '=', $chat->last_message_time)
                    ->first();
                $chat->is_read = $lastMessage->is_read;
                $chat->sent_to = $lastMessage->sent_to;
                $chat->last_message_time = $this->calculateLastMessageDate($chat->last_message_time);
            }
        }
        $conversation = Conversation::where('id', '=', $id)->first();
        $otherUserId = $conversation->user_id == $loggedInUserId ? $conversation->other_user_id : $conversation->user_id;
        $activeChatUser = User::with('followers')->where('id', '=', $otherUserId)->first();
        $activeChatUser->number_of_followers = count($activeChatUser->followers) != 1 ? count
            ($activeChatUser->followers) . " Followers" : count($activeChatUser->followers) . " Follower";
        $activeChatUser->joined_date = date('F Y', strtotime($activeChatUser->created_at));
        $activeChatUser->column_name = $conversation->user_id == $loggedInUserId ? 'other_user_id' : 'user_id';
        $leftConversation = LeftConversation::where('user_id', '=', $loggedInUserId)
                                            ->where('conversation_id', '=', $id)
                                            ->first();
        $messages = Message::with('conversation')
                           ->where('conversation_id', '=', $id);
        if($leftConversation){
            $messages = $messages->where('created_at', '>=',$leftConversation->left_at);
        }
        $messages = $messages->orderBy('created_at', 'ASC')
                             ->get();
        $newMessages = 0;
        foreach ($messages as $message) {
            $message->created_at = $this->calculateMessageDate($message->created_at);
            if ($message->sent_to == $loggedInUserId && $message->is_read == 0) {
                $newMessages++;
            }
        }
        $userBlockedLoggedInUser = BlockedUser::where('blocked_user_id', '=', $loggedInUserId)
                                              ->where('blocked_by_user_id', '=', $otherUserId)
                                              ->first();
        $loggedInUserBlockedUser = BlockedUser::where('blocked_user_id', '=', $otherUserId)
                                              ->where('blocked_by_user_id', '=', $loggedInUserId)
                                              ->first();
        $chatIsBlocked = $userBlockedLoggedInUser || $loggedInUserBlockedUser;
        return view('pages.client.messages.single-conversation',[
            'chatId' => $id,
            'chats' => $lastChats,
            'messages' => $messages,
            'numOfMessages' => count($messages),
            'chatIsBlocked' => $chatIsBlocked,
            'newMessages' => $newMessages,
            'activeChatUser' => $activeChatUser
        ]);
    }
    public function navigateToConversation(Request $request) : Response
    {
        $otherUserId = (int)$request->query('userId');
        $conversationExists1 = Conversation::where('user_id', '=', $otherUserId)
                                          ->where('other_user_id', '=', session()->get('user')->id)
                                          ->first();
        $conversationExists2 = Conversation::where('user_id', '=', session()->get('user')->id)
                                          ->where('other_user_id', '=', $otherUserId)
                                          ->first();
        if (!$conversationExists1 && !$conversationExists2) {
            Conversation::create([
                'user_id' => session()->get('user')->id,
                'other_user_id' => $otherUserId
            ]);
            $insertedId = Conversation::where('user_id', '=', session()->get('user')->id)
                                     ->where('other_user_id', '=', $otherUserId)
                                     ->first();
            $route = route('messages.conversation', ['id' => $insertedId->id]);
            return \response()->json([
                'route' => $route
            ]);
        }
        $conversationExists = $conversationExists1 ?: $conversationExists2;
        $route = route('messages.conversation', ['id' => $conversationExists->id]);
        return \response()->json([
            'route' => $route
        ]);
    }
}
