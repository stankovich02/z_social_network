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
                <img src="{{asset('assets/img/posts/' . $post->image[0]->image)}}" loading="lazy" alt="" class="post-image" />
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
                <div class="post-reaction-stats-text"></div>
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
        </div>
        <button class="reply-comment disabled-new-comment w-button" disabled>Reply</button>
    </div>
    <div class="other-comments">
        @foreach($post->comments as $comment)
            <div class="single-comment">
                <img src="{{asset('assets/img/users/' . $comment->user->photo)}}" loading="eager" alt="" class="user-image" />
                <div class="comment-info">
                    <div class="comment-user-info">
                        <div class="commented-by-username">{{$comment->user->full_name}}</div>
                        <div class="commented-by-fullname">&#64;{{$comment->user->username}}</div>
                        <div class="dot">·</div>
                        <div class="commented-on-date-text">{{$comment->created_at}}</div>
                    </div>
                    <div class="comment-body">{{$comment->content}}</div>
                    <div class="comment-reactions">
                        <div class="comments-on-comment-stats">
                            <div class="comment-stats-icon w-embed">
                                <i class="fa-regular fa-comment post-ic"></i>
                            </div>
                            <div class="comment-rections-stats-num"></div>
                        </div>
                        <div class="liked-on-comment-stats">
                            <div class="comment-stats-icon w-embed">
                                <i class="fa-regular fa-heart post-ic"></i>
                            </div>
                            <div class="comment-rections-stats-num"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
<script src="{{asset('assets/js/post.js')}}"></script>
@endsection