<?php

namespace App\Controllers\Client;

use App\Models\BlockedUser;
use App\Models\Conversation;
use App\Models\LeftConversation;
use App\Models\Message;
use App\Models\User;
use App\Models\UserFollower;
use App\Traits\Calculate;
use mysql_xdevapi\Table;
use NovaLite\Database\Database;
use NovaLite\Http\Controller;
use NovaLite\Http\Request;
use NovaLite\Http\Response;
use NovaLite\Views\View;

class MessageController extends Controller
{
    use Calculate;
    public function index(Request $request) : View|Response
    {
        $loggedInUserId = session()->get('user')->id;
        $leftConversations = Database::table(LeftConversation::TABLE)
                                     ->where('user_id', '=', session()->get('user')->id)
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
        $leftConversations = Database::table(LeftConversation::TABLE)
            ->where('user_id', '=', session()->get('user')->id)
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
        $matchedFollowers = [];
        $loggedInUserFollowing = array_column(
            Database::table(UserFollower::TABLE)
                ->where('user_id', '=', session()->get('user')->id)
                ->get(),
            'follower_id'
        );
        $profileUserFollowers = array_column(
            Database::table(UserFollower::TABLE)
                ->where('follower_id', '=', $otherUserId)
                ->get(),
            'user_id'
        );
        $matched = array_intersect($loggedInUserFollowing, $profileUserFollowers);
        foreach ($matched as $id) {
            $matchedUser = User::where('id', '=', $id)->first();
            $matchedFollowers[] = [
                'full_name' => $matchedUser->full_name,
                'photo' => asset('assets/img/users/' . $matchedUser->photo),
            ];
        }
        $matchedText = '';
        $numOfRemaining = count($matchedFollowers) - 2;
        $others = $numOfRemaining != 1 ? "$numOfRemaining others" : "$numOfRemaining other";
        switch (count($matchedFollowers)) {
            case 0:
                $matchedText = "Not followed by anyone you’re following";
                break;
            case 1:
                $matchedText = 'Followed by ' . $matchedFollowers[0]['full_name'];
                break;
            case 2:
                $matchedText = 'Followed by ' . $matchedFollowers[0]['full_name'] . ' and ' . $matchedFollowers[1]['full_name'];
                break;
            default:
                $matchedText = 'Followed by ' . $matchedFollowers[0]['full_name'] . ', ' . $matchedFollowers[1]['full_name'] . ' and ' . $others . ' you follow';
        }
        return view('pages.client.messages.single-conversation',[
            'chatId' => $id,
            'chats' => $lastChats,
            'messages' => $messages,
            'numOfMessages' => count($messages),
            'chatIsBlocked' => $chatIsBlocked,
            'newMessages' => $newMessages,
            'activeChatUser' => $activeChatUser,
            'matchedFollowers' => $matchedFollowers,
            'matchedText' => $matchedText,
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
