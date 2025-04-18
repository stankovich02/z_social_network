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
                            @if($chat->last_message)
                                <div class="message-from-user new-message">{{$chat->last_message}}</div>
                            @endif
                        </div>
                        <div class="single-message-more-options-wrapper">
                            <div class="more-options w-embed single-message-more-options">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                    <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                                </svg>
                            </div>
                            <div class="choose-single-message-option">
                                <div class="single-chat-option delete-conversation" data-id="{{$chat->id}}">
                                    <i class="fa-regular fa-trash-can"></i>Delete conversation
                                </div>
                            </div>
                        </div>
                        <i class="fa-solid fa-circle newMessageIcon"></i>
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
                                    <div class="message-from-user">{{$chat->last_message}}</div>
                                @endif
                            </div>
                            <div class="single-message-more-options-wrapper">
                                <div class="more-options w-embed single-message-more-options">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                        <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                                    </svg>
                                </div>
                                <div class="choose-single-message-option">
                                    <div class="single-chat-option delete-conversation" data-id="{{$chat->id}}">
                                        <i class="fa-regular fa-trash-can"></i>Delete conversation
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
    <div class="chat">
            <div id="selectMessageNotification">
                <h2 id="selectMessageHeading">Select a message</h2>
                <p id="selectMessText">Choose from your existing conversations, start a new one, or just keep swimming.</p>
                <button id="newMessageBtn">New message</button>
            </div>
    </div>
</section>
<div class="popup-wrapper">
    <div class="new-message-popup">
        <div class="new-message-top">
            <div class="close-icon close-new-message w-embed">
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
                    <path fill="currentColor" d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z"></path>
                </svg>
            </div>
            <div class="text-block-4">New message</div>
        </div>
        <div class="search-chat-people-form w-form">
            <i class="fa-solid fa-magnifying-glass"></i>
            <form
                    id="email-form-4"
                    name="email-form-4"
                    method="get"
                    class="form-5"
            >
                <input class="search-people-chat-input w-input" name="" autocomplete="off" placeholder="Search people" type="text" id="search-people"/>
            </form>
        </div>
        <div class="new-message-result-wrapper">
            @foreach($chats as $chat)
                <div class="single-new-message-user" data-id="{{$chat->user->id}}">
                    <img src="{{asset('assets/img/users/' . $chat->user->photo)}}" loading="lazy" alt="" class="user-image" />
                    <div class="new-message-user-info">
                        <div class="new-message-user-fullname">{{$chat->user->full_name}}</div>
                        <div class="new-message-user-username">&#64;{{$chat->user->username}}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
    <script src="{{asset('assets/js/messages.js')}}"></script>
@endsection