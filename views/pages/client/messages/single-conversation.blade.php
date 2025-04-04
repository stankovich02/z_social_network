@extends('layouts.main')
@section('title') Home @endsection
@section('content')
    <section id="messages" class="content messages">
        <div class="messages-wrapper">
            <div class="content-name-div">
                <div class="content-name">Messages</div>
                <div class="new-message-icon w-embed">
                    <svg
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            aria-hidden="true"
                            role="img"
                            class="iconify iconify--ic"
                            width="100%"
                            height="100%"
                            preserveAspectRatio="xMidYMid meet"
                            viewBox="0 0 24 24"
                    >
                        <path fill="currentColor" d="M22 4c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4zm-2 13.17L18.83 16H4V4h16zM13 5h-2v4H7v2h4v4h2v-4h4V9h-4z"></path>
                    </svg>
                </div>
            </div>
            <div class="search-wrapper messages-search-wrapper">
                <div class="search-div">
                    <div class="icon-embed-xsmall-3 w-embed">
                        <svg
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true"
                                role="img"
                                class="iconify iconify--bx"
                                width="100%"
                                height="100%"
                                preserveAspectRatio="xMidYMid meet"
                                viewBox="0 0 24 24"
                        >
                            <path
                                    fill="currentColor"
                                    d="M10 18a7.95 7.95 0 0 0 4.897-1.688l4.396 4.396l1.414-1.414l-4.396-4.396A7.95 7.95 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8s3.589 8 8 8m0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6s-6-2.691-6-6s2.691-6 6-6"
                            ></path>
                        </svg>
                    </div>
                    <div class="search-form w-form">
                        <form
                                id="email-form"
                                name="email-form"
                                data-name="Email Form"
                                method="get"
                                class="form-2"
                                data-wf-page-id="67b61da06092cd17329df273"
                                data-wf-element-id="c8442348-8eb0-1fa2-063b-f770bf60c2fd"
                                data-turnstile-sitekey="0x4AAAAAAAQTptj2So4dx43e"
                        >
                            <input class="search-input w-input" maxlength="256" name="message-search" data-name="message-search" placeholder="Search Direct Messages" type="text" id="message-search" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="all-messages">
                @foreach($chats as $chat)
                    @if($chat->is_read === 0 && $chat->sent_to === session()->get('user')->id)
                        <a href="{{route("messages.conversation", ['id' => $chat->id])}}" class="single-message new-message" data-id="{{session()->get('user')->id}}" data-other-id="{{$chat->user->id}}">
                            <img src="{{asset('assets/img/users/' . $chat->user->photo)}}" loading="lazy" alt="" class="user-image" />
                            <div class="message-sender-info">
                                <div class="messaged-by-user-info">
                                    <div class="messaged-by-fullname">{{$chat->user->full_name}}</div>
                                    <div class="messaged-by-username">&#64;{{$chat->user->username}}</div>
                                    @if($chat->last_message_time)
                                        <div class="dot">·</div>
                                        <div class="last-sent-time-text">{{$chat->last_message_time}}</div>
                                    @endif
                                </div>
                                <div class="message-from-user new-message">{{$chat->message}}</div>
                            </div>
                            <img src="{{asset('assets/img/67b61da06092cd17329df26d/67bd987eda529b92af7c73e7_IcBaselineMoreHoriz.png')}}" loading="lazy" alt="" class="more-options-message" />
                            <i class="fa-solid fa-circle newMessageIcon"></i>
                        </a>
                    @elseif($chat->id === $chatId)
                        <a href="{{route("messages.conversation", ['id' => $chat->id])}}" class="single-message active-chat" data-id="{{session()->get('user')->id}}" data-other-id="{{$activeChatUser->id}}">
                            <img src="{{asset('assets/img/users/' . $chat->user->photo)}}" loading="lazy" alt="" class="user-image" />
                            <div class="message-sender-info">
                                <div class="messaged-by-user-info">
                                    <div class="messaged-by-fullname">{{$chat->user->full_name}}</div>
                                    <div class="messaged-by-username">&#64;{{$chat->user->username}}</div>
                                    @if($chat->last_message_time)
                                        <div class="dot">·</div>
                                        <div class="last-sent-time-text">{{$chat->last_message_time}}</div>
                                    @endif
                                </div>
                                @if($chat->last_message)
                                    <div class="message-from-user new-message">{{$chat->last_message}}</div>
                                @endif
                            </div>
                            <img src="{{asset('assets/img/67b61da06092cd17329df26d/67bd987eda529b92af7c73e7_IcBaselineMoreHoriz.png')}}" loading="lazy" alt="" class="more-options-message" />
                        </a>
                    @else
                        @if($chat->last_message_time)
                            <a href="{{route("messages.conversation", ['id' => $chat->id])}}" class="single-message old-message" data-id="{{session()->get('user')->id}}" data-other-id="{{$chat->user->id}}">
                                <img src="{{asset('assets/img/users/' . $chat->user->photo)}}" loading="lazy" alt="" class="user-image" />
                                <div class="message-sender-info">
                                    <div class="messaged-by-user-info">
                                        <div class="messaged-by-fullname">{{$chat->user->full_name}}</div>
                                        <div class="messaged-by-username">&#64;{{$chat->user->username}}</div>
                                        @if($chat->last_message_time)
                                            <div class="dot">·</div>
                                            <div class="last-sent-time-text">{{$chat->last_message_time}}</div>
                                        @endif
                                    </div>
                                    @if($chat->last_message)
                                        <div class="message-from-user new-message">{{$chat->last_message}}</div>
                                    @endif
                                </div>
                                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67bd987eda529b92af7c73e7_IcBaselineMoreHoriz.png')}}" loading="lazy" alt="" class="more-options-message" />
                            </a>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
        <div class="chat">
            <div class="chat-user-fullname">{{$activeChatUser->full_name}}</div>
            <a href="{{route('profile', ['username' => $activeChatUser->username])}}" class="chat-user-info-wrapper">
                <img src="{{asset('assets/img/users/' . $activeChatUser->photo)}}" loading="lazy" alt="" class="chat-user-image" />
                <div class="chat-user-info">
                    <div class="chat-user-info-fullname">{{$activeChatUser->full_name}}</div>
                    <div class="chat-user-info-username">&#64;{{$activeChatUser->username}}</div>
                    <div class="chat-user-bio">{{$activeChatUser->biography}}</div>
                    <div class="chat-user-date-joined-and-followers">
                        <div class="user-joined-date">Joined {{$activeChatUser->joined_date}}</div>
                        <div class="dot">·</div>
                        <div class="chat-user-num-of-followers">{{$activeChatUser->number_of_followers}}</div>
                    </div>
                </div>
            </a>
            <div class="chat-messages-wrapper">
                <?php
                $isWrittenNewMessage = false;
                ?>
                @foreach($messages as $index => $message)
                    @if($message->sent_from === session()->get('user')->id)
                        <div class="sent-message-wrapper {{$message->is_read ? "viewed" : ""}}" data-id="{{$message->id}}" >
                            <div class="sent-message">
                                <p class="message-text">{{$message->message}}</p>
                            </div>
                            <div class="sent-message-info">
                                <p class="sentInfoDate">{{$message->created_at}}</p>
                                @if($index === ($numOfMessages - 1))
                                    <div class="dot">·</div>
                                    <p class="sentInfoText">{{$message->is_read ? "Seen" : "Sent"}}</p>
                                @endif
                            </div>
                        </div>
                    @else
                        @if($message->is_read === 0 && !$isWrittenNewMessage )
                            <div id="newMessagesChatNotification">
                                <div class="lineNotification"></div>
                                <p>{{$newMessages}} new {{$newMessages != 1 ? "messages" : "message"}}</p>
                                <div class="lineNotification"></div>
                            </div>
                            <?php
                                $isWrittenNewMessage = true;
                            ?>
                        @endif
                        <div class="received-message-wrapper {{$message->is_read ? "viewed" : ""}}" data-id="{{$message->id}}" >
                            <div class="received-message">
                                <p class="message-text">{{$message->message}}</p>
                            </div>
                            <div class="received-message-info">
                                <p>{{$message->created_at}}</p>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
            @if($chatIsBlocked)
                <div id="blockedChat">
                    <p>You can no longer send messages to this person.</p>
                </div>
            @else
                <div class="send-message-div">
                    <div class="send-message-form">
                        <form
                                id="email-form-2"
                                method="get"
                                class="form-3"
                        >
                            <input class="type-message-input w-input" placeholder="Start a new message" type="text" id="new-message-text" />
                        </form>
                    </div>
                    <div class="send-message-icon w-embed" disabled data-id="{{session()->get('user')->id}}" data-receiver-id="{{$activeChatUser->id}}" data-conversation-id="{{$chatId}}" data-other-user-column-name="{{$activeChatUser->column_name}}">
                        <svg
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true"
                                role="img"
                                class="iconify iconify--ic"
                                width="100%"
                                height="100%"
                                preserveAspectRatio="xMidYMid meet"
                                viewBox="0 0 24 24"
                        >
                            <path fill="currentColor" d="M2.01 21L23 12L2.01 3L2 10l15 2l-15 2z"></path>
                        </svg>
                    </div>
                </div>
            @endif

        </div>
    </section>
    <script src="{{asset('assets/js/messages.js')}}"></script>
@endsection