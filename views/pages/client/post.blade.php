@extends('layouts.main')
@section('title') {{$title}} @endsection
@section('content')
<section id="post" class="content">
    <div class="top-nav-post">
        <a href="{{$_SERVER['HTTP_REFERER']}}" class="returnBackLink">
            <div class="icon-embed-xsmall-5 w-embed">
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
                    <path fill="currentColor" d="M21 11H6.83l3.58-3.59L9 6l-6 6l6 6l1.41-1.41L6.83 13H21z"></path>
                </svg>
            </div>
        </a>
        <div class="text-block-3">Post</div>
    </div>
    <div class="post-info" id="single-post-info">
        <div class="post-more-options-wrapper">
            <div class="more-options w-embed post-more-options">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                    <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                </svg>
            </div>
            <div class="choose-post-option">
                @if($post->user->id === session()->get('user')->id)
                    <div class="single-post-option delete-post" data-id="{{$post->id}}"><div class="trash-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--bx" role="img" aria-hidden="true" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm10.618-3L15 2H9L7.382 4H3v2h18V4z"></path></svg></div>Delete</div>
            @else
                <div class="single-post-option block-user" data-id="{{$post->user->id}}" data-username="{{$post->user->username}}"><div class="block-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--ic" role="img" aria-hidden="true" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2M4 12c0-4.42 3.58-8 8-8c1.85 0 3.55.63 4.9 1.69L5.69 16.9A7.9 7.9 0 0 1 4 12m8 8c-1.85 0-3.55-.63-4.9-1.69L18.31 7.1A7.9 7.9 0 0 1 20 12c0 4.42-3.58 8-8 8" fill="currentColor"></path></svg></div>Block &#64;{{$post->user->username}}</div>
                @if($post->user->loggedInUserFollowing)
                    <div class="single-post-option unfollow-user" data-id="{{$post->user->id}}" data-username="{{$post->user->username}}"><i class="fa-solid fa-user-xmark"></i> Unfollow &#64;{{$post->user->username}}</div>
                @else
                    <div class="single-post-option follow-user" data-id="{{$post->user->id}}" data-username="{{$post->user->username}}"><i class="fa-solid fa-user-plus"></i> Follow &#64;{{$post->user->username}}</div>
                @endif
            @endif
            </div>
        </div>
       @if($reposted)
            <div class="reposted-info">
                <div class="icon-embed-xsmall-7 w-embed">
                    <i class="fa-solid fa-retweet"></i>
                </div>
                <div><strong>You</strong> reposted</div>
            </div>
       @endif
        <div class="posted-by-info">
            <img src="{{asset('assets/img/users/' . $post->user->photo)}}" loading="lazy" alt="" class="user-image" />
            <div class="user-info">
                <div class="posted-by-fullname">{{$post->user->full_name}}</div>
                <div class="posted-by-username">&#64;{{$post->user->username}}</div>
            </div>
        </div>
        <div class="post-body">
           @if($post->content)
                <p class="post-body-text">{{$post->content}}</p>
           @endif
           @if($post->image)
                <img src="{{asset('assets/img/posts/' . $post->image->image)}}" loading="lazy" alt="" class="post-image" />
           @endif
        </div>
        <div class="posted-date-wrapper">
            <div class="posted-date-time">{{$postedDate['time']}}</div>
            <div class="dot">·</div>
            <div class="posted-date-date">{{$postedDate['date']}}</div>
            @if($post->views)
                <div class="dot">·</div>
                <div class="num-of-views"><span class="text-span-4">{{$post->views}}</span> {{$post->views > 1 ? "Views" : "View"}}</div>
            @endif
        </div>
        <div class="post-reactions single-post-reactions">
            <div class="post-comment-stats single-post-comment-stats">
                <div class="post-stats-icon singe-post-stats-icon" data-id="{{$post->id}}">
                    <i class="fa-regular fa-comment post-ic"></i>
                </div>
                <div class="post-reaction-stats-text">{{$post->number_of_comments > 0 ? $post->number_of_comments : ""}}</div>
            </div>
            <div class="post-reposted-stats single-post-reposted-stats">
                <div class="post-stats-icon singe-post-stats-icon" data-id="{{$post->id}}">
                    <i class="{{$post->user_reposted ? "repostedPost" : ""}} fa-solid fa-retweet post-ic"></i>
                </div>
                <div class="post-reaction-stats-text {{$post->user_reposted ? "repostedPost" : ""}}">{{$post->number_of_reposts > 0 ? $post->number_of_reposts : ""}}</div>
            </div>
            <div class="post-likes-stats single-post-likes-stats">
                <div class="post-stats-icon singe-post-stats-icon" data-id="{{$post->id}}">
                    <i class="{{$post->user_liked ? "fa-solid likedPost" : "fa-regular"}} fa-heart post-ic"></i>
                </div>
                <div class="post-reaction-stats-text {{$post->user_liked ? "likedPost" : ""}}">{{$post->number_of_likes > 0 ? $post->number_of_likes : ""}}</div>
            </div>
        </div>

    </div>
    <div class="new-comment-wrapper">
        <img src="{{asset('assets/img/users/' . session()->get('user')->photo)}}" loading="lazy" alt="" class="user-image" />
        <div class="new-comment w-form">
            <form
                    id="wf-form-New-comment"
                    name="wf-form-New-comment"
                    data-name="New comment"
                    method="get"
                    class="form-4"
                    data-wf-page-id="67b61da06092cd17329df273"
                    data-wf-element-id="505b33a2-f521-5db4-e608-4900fd0c1792"
                    data-turnstile-sitekey="0x4AAAAAAAQTptj2So4dx43e"
            >
                <textarea class="new-comment-text" placeholder="Post your reply"></textarea>
            </form>
            <div id="commentEmojiPicker"></div>
        </div>
        <button id="postReplyComment" class="reply-comment disabled-new-comment w-button" disabled data-id="{{$post->id}}">Reply</button>
        <script type="module">
            import { EmojiButton } from 'https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.4/dist/index.min.js';

            const html = '<i class="fa-regular fa-face-smile pickEmoji"></i>';
            document.getElementById("commentEmojiPicker").innerHTML += html;

            const picker = new EmojiButton({
                position: 'top-start',
                theme: 'auto'
            });

            const input = document.querySelector(".new-comment-text");
            let submitCommentBtn = document.querySelector("#postReplyComment");

            picker.on('emoji', emoji => {
                input.value += emoji.emoji;
                submitCommentBtn.classList.remove("disabled-new-comment");
                submitCommentBtn.disabled = false;
            });
            let emojiIcon = document.querySelector(".new-comment-wrapper .pickEmoji");
            emojiIcon.addEventListener('click', () => {
                picker.togglePicker(emojiIcon);
            });
        </script>
    </div>
    <div class="other-comments">
        @foreach($post->comments as $comment)
            @if(!in_array($comment->user->id, $blockedUsers) && !in_array($comment->user->id, $usersWhoBlockLoggedInUser))
                <div class="single-comment">
                    <div class="comment-more-options-wrapper">
                        <div class="more-options w-embed comment-more-options">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                            </svg>
                        </div>
                        <div class="choose-comment-option">
                            @if($comment->user->id === session()->get('user')->id)
                                <div class="single-comment-option delete-comment" data-id="{{$comment->id}}"><div class="trash-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--bx" role="img" aria-hidden="true" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm10.618-3L15 2H9L7.382 4H3v2h18V4z"></path></svg></div>Delete</div>
                            @else
                                <div class="single-comment-option block-user" data-id="{{$comment->user->id}}" data-username="{{$comment->user->username}}"><div class="block-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--ic" role="img" aria-hidden="true" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2M4 12c0-4.42 3.58-8 8-8c1.85 0 3.55.63 4.9 1.69L5.69 16.9A7.9 7.9 0 0 1 4 12m8 8c-1.85 0-3.55-.63-4.9-1.69L18.31 7.1A7.9 7.9 0 0 1 20 12c0 4.42-3.58 8-8 8" fill="currentColor"></path></svg></div>Block &#64;{{$comment->user->username}}</div>
                                @if($comment->user->loggedInUserFollowing)
                                    <div class="single-comment-option unfollow-user" data-id="{{$comment->user->id}}" data-username="{{$comment->user->username}}"><i class="fa-solid fa-user-xmark"></i> Unfollow &#64;{{$comment->user->username}}</div>
                                @else
                                    <div class="single-comment-option follow-user" data-id="{{$comment->user->id}}" data-username="{{$comment->user->username}}"><i class="fa-solid fa-user-plus"></i> Follow &#64;{{$comment->user->username}}</div>
                                @endif
                            @endif
                        </div>
                    </div>
                    <img src="{{asset('assets/img/users/' . $comment->user->photo)}}" loading="eager" alt="" class="user-image" />
                    <div class="comment-info">
                        <div class="comment-user-info">
                            <div class="commented-by-fullname">{{$comment->user->full_name}}</div>
                            <div class="commented-by-username">&#64;{{$comment->user->username}}</div>
                            <div class="dot">·</div>
                            <div class="commented-on-date-text">{{$comment->created_at}}</div>
                        </div>
                        <div class="comment-body">{{$comment->content}}</div>
                        <div class="comment-reactions">
                            <div class="comments-on-comment-stats">
                                <div class="comment-stats-icon w-embed">
                                    <i class="fa-regular fa-comment post-ic"></i>
                                </div>
                                <div class="comment-reactions-stats-num"></div>
                            </div>
                            <div class="liked-on-comment-stats">
                                <div class="comment-stats-icon w-embed" data-cid="{{$comment->id}}" data-pid="{{$post->id}}">
                                    <i class="fa-heart post-ic {{$comment->userLiked ? "likedComment fa-solid" : "fa-regular"}}"></i>
                                </div>
                                <div class="comment-reactions-stats-num {{$comment->userLiked ? "likedComment" : ""}}">{{count($comment->likes) > 0 ? count($comment->likes) : ""}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>
<script src="{{asset('assets/js/post.js')}}"></script>
@endsection