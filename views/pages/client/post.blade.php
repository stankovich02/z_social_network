@extends('layouts.main')
@section('title') {{$title}} @endsection
@section('content')
<section id="post" class="content">
    <div class="top-nav-post">
        <a href="{{$returnBackLink}}" class="returnBackLink">
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
                <div class="post-stats-icon singe-post-stats-icon">
                    <i class="fa-regular fa-comment post-ic"></i>
                </div>
                <div class="post-reaction-stats-text"></div>
            </div>
            <div class="post-reposted-stats single-post-reposted-stats">
                <div class="post-stats-icon singe-post-stats-icon">
                        <i class="fa-solid fa-retweet post-ic"></i>
                </div>
                <div class="post-reaction-stats-text"></div>
            </div>
            <div class="post-likes-stats single-post-likes-stats">
                <div class="post-stats-icon singe-post-stats-icon" data-id="{{$post->id}}">
                    <i class="{{$post->user_liked ? "fa-solid likedPost" : "fa-regular"}} fa-heart post-ic"></i>
                </div>
                <div class="post-reaction-stats-text">{{$post->number_of_likes > 0 ? $post->number_of_likes : ""}}</div>
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
        <div class="single-comment">
            <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="eager" alt="" class="user-image" />
            <div class="comment-info">
                <div class="comment-user-info">
                    <div class="commented-by-username">Marko Stankovic</div>
                    <div class="commented-by-fullname">@markostanke2002</div>
                    <div class="dot">·</div>
                    <div class="commented-on-date-text">3 mins</div>
                </div>
                <div class="comment-body">Bas lep komentar</div>
                <div class="comment-reactions">
                    <div class="comments-on-comment-stats">
                        <div class="comment-stats-icon w-embed">
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
                                <path
                                        fill="currentColor"
                                        d="M5 21v-4.157c-1.25-1.46-2-3.319-2-5.343C3 6.806 7.03 3 12 3s9 3.806 9 8.5s-4.03 8.5-9 8.5a9.35 9.35 0 0 1-4.732-1.268zm7-3c3.866 0 7-2.91 7-6.5S15.866 5 12 5s-7 2.91-7 6.5S8.134 18 12 18"
                                ></path>
                            </svg>
                        </div>
                        <div class="comment-rections-stats-num">1</div>
                    </div>
                    <div class="liked-on-comment-stats">
                        <div class="comment-stats-icon w-embed">
                            <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true"
                                    role="img"
                                    class="iconify iconify--ph"
                                    width="100%"
                                    height="100%"
                                    preserveAspectRatio="xMidYMid meet"
                                    viewBox="0 0 256 256"
                            >
                                <path
                                        fill="currentColor"
                                        d="M178 40c-20.65 0-38.73 8.88-50 23.89C116.73 48.88 98.65 40 78 40a62.07 62.07 0 0 0-62 62c0 70 103.79 126.66 108.21 129a8 8 0 0 0 7.58 0C136.21 228.66 240 172 240 102a62.07 62.07 0 0 0-62-62m-50 174.8c-18.26-10.64-96-59.11-96-112.8a46.06 46.06 0 0 1 46-46c19.45 0 35.78 10.36 42.6 27a8 8 0 0 0 14.8 0c6.82-16.67 23.15-27 42.6-27a46.06 46.06 0 0 1 46 46c0 53.61-77.76 102.15-96 112.8"
                                ></path>
                            </svg>
                        </div>
                        <div class="comment-rections-stats-num">1</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{asset('assets/js/post.js')}}"></script>
@endsection