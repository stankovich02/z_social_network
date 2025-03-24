@extends('layouts.main')
@section('title') Home @endsection
@section('content')
<section id="profile" class="content">
    <div class="top-profile-info">
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
        <div class="top-profile-fullname">
            <div class="top-fullname-text">{{$user->full_name}}</div>
            <div class="num-of-posts">{{$numOfPosts}}</div>
        </div>
    </div>
    <img
            src="{{asset('assets/img/users-covers/'. $user->cover_photo)}}"
            loading="lazy"
            sizes="100vw"
            alt=""
            class="profile-banner"
    />
    <div class="profile-info">
        <div class="image-and-setup">
            <img
                    src="{{asset('assets/img/users/'. $user->photo)}}"
                    loading="lazy"
                    sizes="100vw"
                    alt=""
                    class="profile-image"
            />
            <a href="#" class="setup-profile w-button">Set up profile</a>
        </div>
        <div class="profile-info-detailed">
            <div class="profile-fullname">{{$user->full_name}}</div>
            <div class="profile-username">&#64;{{$user->username}}</div>
            @if($user->biography)
                <p class="profile-bio">{{$user->biography}}</p>
            @endif
            <div class="profile-joined-date">
                <div class="icon-embed-xsmall-6 w-embed">
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
                        <path
                                fill="currentColor"
                                d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 16H5V10h14zM9 14H7v-2h2zm4 0h-2v-2h2zm4 0h-2v-2h2zm-8 4H7v-2h2zm4 0h-2v-2h2zm4 0h-2v-2h2z"
                        ></path>
                    </svg>
                </div>
                <div class="joined-date-text">Joined {{$joinedDate}}</div>
            </div>
            <div class="follow-stats">
                <div class="following-stats">16 <span class="text-span-2">Following</span></div>
                <div class="followers-stats">0 <span class="text-span-3">Followers</span></div>
            </div>
        </div>
    </div>
    <div id="posts">
        @foreach($posts as $index => $post)
            @if($post->type === \App\Models\Post::REPOSTED_POST)
            <div class="single-post reposted-post" data-id="{{$post->post->id}}">
                <div class="reposted-info">
                    <div class="icon-embed-xsmall-7 w-embed">
                        <i class="fa-solid fa-retweet"></i>
                    </div>
                    <div><strong>{{$post->user->username === session()->get('user')->username ? "You" : $post->user->full_name}}</strong> reposted</div>
                </div>
                <img src="{{asset('assets/img/users/' . $post->user->photo)}}" loading="eager" alt="" class="user-image" />
                <div class="post-info-and-body">
                    <div class="post-info">
                        <div class="posted-by-fullname">{{$post->post->user->full_name}}</div>
                        <div class="posted-by-username">&#64;{{$post->post->user->username}}</div>
                        <div class="dot">·</div>
                        <div class="posted-on-date-text">{{$post->post->created_at}}</div>
                    </div>
                    <div class="post-body">
                        @if($post->post->content)
                        <p class="post-body-text">{{$post->post->content}}</p>
                        @endif
                        @if($post->post->image)
                            <img
                                    src="{{asset('assets/img/posts/' . $post->post->image[0]->image)}}"
                                    loading="lazy"
                                    sizes="100vw"
                                    alt=""
                                    class="post-image"
                            />
                        @endif
                    </div>
                    <div class="post-reactions">
                        <div class="post-comment-stats">
                            <div class="post-stats-icon" data-id="{{$post->post->id}}">
                                <i class="fa-regular fa-comment post-ic"></i>
                            </div>
                            <div class="post-reaction-stats-text"></div>
                        </div>
                        <div class="post-reposted-stats">
                            <div class="post-stats-icon" data-id="{{$post->post->id}}">
                                <i class="{{$post->post->user_reposted ? "repostedPost" : ""}} fa-solid fa-retweet post-ic"></i>
                            </div>
                            <div class="post-reaction-stats-text {{$post->post->user_reposted ? "repostedPost" : ""}}">{{$post->post->number_of_reposts > 0 ? $post->post->number_of_reposts : ""}}</div>
                        </div>
                        <div class="post-likes-stats">
                            <div class="post-stats-icon" data-id="{{$post->post->id}}">
                                <i class="{{$post->post->user_liked ? "fa-solid likedPost" : "fa-regular"}} fa-heart post-ic"></i>
                            </div>
                            <div class="post-reaction-stats-text {{$post->post->user_liked ? "likedPost" : ""}} ">{{$post->post->number_of_likes > 0 ? $post->post->number_of_likes : ""}}</div>
                        </div>
                        <div class="post-views-stats">
                            <div class="post-stats-icon">
                                <i class="fa-solid fa-chart-simple post-ic"></i>
                            </div>
                            <div class="post-reaction-stats-text">{{$post->post->views > 0 ? $post->post->views : ''}}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($post->type === \App\Models\Post::ORIGINAL_POST)
                    <div class="single-post" data-id="{{$post->id}}">
                        <div class="post-more-options-wrapper">
                            <div class="more-options w-embed post-more-options">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                    <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                                </svg>
                            </div>
                            <div class="choose-post-option">
                                <div class="single-post-option delete-post" data-id="{{$post->id}}"><div class="trash-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--bx" role="img" aria-hidden="true" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm10.618-3L15 2H9L7.382 4H3v2h18V4z"></path></svg></div>Delete</div>
                            </div>
                        </div>
                        <img src="{{asset('assets/img/users/' . $post->user->photo)}}" loading="eager" alt="" class="user-image" />
                        <div class="post-info-and-body">
                            <div class="post-info">
                                <div class="posted-by-fullname">{{$post->user->full_name}}</div>
                                <div class="posted-by-username">&#64;{{$post->user->username}}</div>
                                <div class="dot">·</div>
                                <div class="posted-on-date-text">{{$post->created_at}}</div>
                            </div>
                            <div class="post-body">
                                <p class="post-body-text">{{$post->content}}</p>
                                @if($post->image)
                                    <img
                                            src="{{asset('assets/img/posts/' . $post->image[0]->image)}}"
                                            loading="lazy"
                                            sizes="100vw"
                                            alt=""
                                            class="post-image"
                                    />
                                @endif
                            </div>
                            <div class="post-reactions">
                                <div class="post-comment-stats">
                                    <div class="post-stats-icon" data-id="{{$post->id}}">
                                        <i class="fa-regular fa-comment post-ic"></i>
                                    </div>
                                    <div class="post-reaction-stats-text"><div class="post-reaction-stats-text">{{$post->number_of_comments > 0 ? $post->number_of_comments : ""}}</div></div>
                                </div>
                                <div class="post-reposted-stats">
                                    <div class="post-stats-icon" data-id="{{$post->id}}">
                                        <i class="{{$post->user_reposted ? "repostedPost" : ""}} fa-solid fa-retweet post-ic"></i>
                                    </div>
                                    <div class="post-reaction-stats-text {{$post->user_reposted ? "repostedPost" : ""}}">{{$post->number_of_reposts > 0 ? $post->number_of_reposts : ""}}</div>
                                </div>
                                <div class="post-likes-stats">
                                    <div class="post-stats-icon" data-id="{{$post->id}}">
                                        <i class="{{$post->user_liked ? "fa-solid likedPost" : "fa-regular"}} fa-heart post-ic"></i>
                                    </div>
                                    <div class="post-reaction-stats-text {{$post->user_liked ? "likedPost" : ""}} ">{{$post->number_of_likes > 0 ? $post->number_of_likes : ""}}</div>
                                </div>
                                <div class="post-views-stats">
                                    <div class="post-stats-icon">
                                        <i class="fa-solid fa-chart-simple post-ic"></i>
                                    </div>
                                    <div class="post-reaction-stats-text">{{$post->views > 0 ? $post->views : ''}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
            @endif
        @endforeach
    </div>
</section>
    <script src="{{asset('assets/js/profile.js')}}"></script>
@endsection