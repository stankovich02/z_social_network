@extends('layouts.main')
@section('title') Home @endsection
@section('content')
<section id="notifications" class="content">
    @foreach($notifications as $index => $notification)
        <a href="{{$notification->link}}" class="single-notification-link" data-id="{{$notification->id}}">
            <div class="single-notification @if(!$notification->is_read) new-notification @endif">
                @if($notification->notification_type_id === \App\Models\Notification::NOTIFICATION_TYPE_FOLLOW)
                <div class="user-icon w-embed">
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
                        <path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2S7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z" fill="currentColor"></path>
                    </svg>
                </div>
                <div class="follower-info">
                    <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="follower-image" />
                    <div class="text-block"><strong>Marko Stankovic</strong> followed you</div>
                </div>
                @elseif($notification->notification_type_id === \App\Models\Notification::NOTIFICATION_TYPE_LIKE)
                    <div class="heart-icon w-embed">
                        <svg
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true"
                                role="img"
                                class="iconify iconify--fe"
                                width="100%"
                                height="100%"
                                preserveAspectRatio="xMidYMid meet"
                                viewBox="0 0 24 24"
                        >
                            <path fill="currentColor" fill-rule="evenodd" d="M12 20c-2.205-.48-9-4.24-9-11a5 5 0 0 1 9-3a5 5 0 0 1 9 3c0 6.76-6.795 10.52-9 11"></path>
                        </svg>
                    </div>
                    <div class="liked-info">
                        <img src="{{asset('assets/img/users/' . $notification->user->photo)}}" loading="lazy" alt="" class="user-image" />
                        <div class="text-block"><strong>{{$notification->user->full_name}}</strong> liked your post</div>
                        @if($notification->post_notification->post->content)
                            <div class="liked-post-info">{{strlen($notification->post_notification->post->content) > 100 ? substr($notification->post_notification->post->content,0,100) . "..." : $notification->post_notification->post->content}}</div>
                        @endif
                        @if($notification->post_notification->post->image)
                            <p data-link="{{$notification->link}}" class="show-all-post">Show all</p>
                        @endif
                    </div>
                @elseif($notification->notification_type_id === \App\Models\Notification::NOTIFICATION_TYPE_REPOST)
                    <div class="repost-icon w-embed">
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
                            <path fill="currentColor" d="M19 7a1 1 0 0 0-1-1h-8v2h7v5h-3l3.969 5L22 13h-3zM5 17a1 1 0 0 0 1 1h8v-2H7v-5h3L6 6l-4 5h3z"></path>
                        </svg>
                    </div>
                    <div class="repost-info">
                        <img src="{{asset('assets/img/users/' . $notification->user->photo)}}" loading="lazy" alt="" class="user-image" />
                        <div class="text-block"><strong>{{$notification->user->full_name}}</strong> reposted your post</div>
                        @if($notification->post_notification->post->content)
                            <div class="liked-post-info">{{strlen($notification->post_notification->post->content) > 100 ? substr($notification->post_notification->post->content,0,100) . "..." : $notification->post_notification->post->content}}</div>
                        @endif
                        @if($notification->post_notification->post->image)
                            <a href="{{$notification->link}}" class="show-all-post">Show all</a>
                        @endif
                    </div>
                @elseif($notification->notification_type_id === \App\Models\Notification::NOTIFICATION_TYPE_COMMENT)
                    <div class="single-comment">
                        <img src="{{asset('assets/img/users/' . $notification->user->photo)}}" loading="eager" alt="" class="user-image" />
                        <div class="comment-info">
                            <div class="comment-user-info">
                                <div class="commented-by-fullname">{{$notification->user->full_name}}</div>
                                <div class="commented-by-username">&#64;{{$notification->user->username}}</div>
                                <div class="dot">·</div>
                                <div class="commented-on-date-text">{{$notification->post_comment_notification->comment->created_at}}</div>
                            </div>
                            <div class="replying-to">Replying to <span class="text-span">&#64;{{session()->get('user')->username}}</span></div>
                            <div class="comment-body">{{strlen($notification->post_comment_notification->comment->content) > 100 ? substr($notification->post_comment_notification->comment->content,0,100) . "..." : $notification->post_comment_notification->comment->content}}</div>

                            <div class="comment-reactions">
                                <div class="comments-on-comment-stats">
                                    <div class="comment-stats-icon w-embed">
                                        <i class="fa-regular fa-comment post-ic"></i>
                                    </div>
                                    <div class="comment-reactions-stats-num"></div>
                                </div>
                                <div class="liked-on-comment-stats">
                                    <div class="comment-stats-icon w-embed">
                                        <i class="fa-regular fa-heart post-ic"></i>
                                    </div>
                                    <div class="comment-reactions-stats-num"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($notification->notification_type_id === \App\Models\Notification::NOTIFICATION_TYPE_LIKED_REPLY)
                    <div class="heart-icon w-embed">
                        <svg
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true"
                                role="img"
                                class="iconify iconify--fe"
                                width="100%"
                                height="100%"
                                preserveAspectRatio="xMidYMid meet"
                                viewBox="0 0 24 24"
                        >
                            <path fill="currentColor" fill-rule="evenodd" d="M12 20c-2.205-.48-9-4.24-9-11a5 5 0 0 1 9-3a5 5 0 0 1 9 3c0 6.76-6.795 10.52-9 11"></path>
                        </svg>
                    </div>
                    <div class="liked-info">
                        <img src="{{asset('assets/img/users/' . $notification->user->photo)}}" loading="lazy" alt="" class="user-image" />
                        <div class="text-block"><strong>{{$notification->user->full_name}}</strong> liked your reply</div>
                        <div class="liked-post-info">{{$notification->post_comment_notification->comment->content}}</div>
                    </div>
                @endif
            </div>
        </a>
    @endforeach
</section>
<script src="{{asset('assets/js/notifications.js')}}"></script>
@endsection