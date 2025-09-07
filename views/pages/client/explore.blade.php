@extends('layouts.main')
@section('title') Home @endsection
@section('content')
<section id="explore" class="content">
    <div id="top-search">
        <div class="search-wrapper">
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
                <div class="search-form">
                    <form
                            id="searchForm"
                            name="searchForm"
                            data-name="Search Form"
                            method="get"
                            class="form-2"
                            data-wf-page-id="67b61da06092cd17329df273"
                            data-wf-element-id="d03f3054-631c-3eac-7d9b-daaf0230fa69"
                            data-turnstile-sitekey="0x4AAAAAAAQTptj2So4dx43e"
                    >
                        <input class="search-input w-input" name="Search" value="{{$query}}" data-name="Search" placeholder="Search" type="text" id="Search" autocomplete="off" />
                    </form>
                </div>
            </div>
        </div>
        @if($query)
        <div class="filterWrapper">
            <a href="{{route('explore')}}?q={{rawurlencode($query)}}" class="filterLink">
                <p class="{{$filter === "top" ? "activeFollowFilter" : ""}}">Top</p>
            </a>
            <a href="{{route('explore')}}?q={{rawurlencode($query)}}&filter=latest" class="filterLink">
                <p class="{{$filter === "latest" ? "activeFollowFilter" : ""}}">Latest</p>
            </a>
            <a href="{{route('explore')}}?q={{rawurlencode($query)}}&filter=people" class="filterLink">
                <p class="{{$filter === "people" ? "activeFollowFilter" : ""}}">People</p>
            </a>
            <a href="{{route('explore')}}?q={{rawurlencode($query)}}&filter=posts" class="filterLink">
                <p class="{{$filter === "posts" ? "activeFollowFilter" : ""}}">Posts</p>
            </a>
        </div>
        @endif
    </div>
    @if($query)
        <div id="searchResults">
            @if(count($users))
                <div id="searchPeopleResult" @if($filter === "people")style="border-bottom: 0" @endif>
                    @if($filter === "top")
                        <div class="resultInfo">
                            <p>People</p>
                        </div>
                    @endif
                    <div id="searchedPeople">
                        @foreach($users as $user)
                            <a class="single-result-user" href="{{route('profile', ['username' => $user->username])}}" data-id="{{$user->id}}">
                                <img src="{{asset('assets/img/users/' . $user->photo)}}" loading="lazy" alt="" class="user-image" />
                                <div class="searched-user-information">
                                    <div class="searched-user-fullname-and-username">
                                        <div class="searched-user-fullname">{{$user->full_name}}</div>
                                        <div class="searched-user-username">&#64;{{$user->username}}</div>
                                    </div>
                                    @if($user->userFollowsLoggedInUser && !$user->loggedInUserFollowsUser)
                                        <button class="followBackBtn" data-id="{{$user->id}}" data-username="{{$user->username}}">Follow back</button>
                                    @elseif($user->loggedInUserFollowsUser)
                                        <button class="followingBtn" data-id="{{$user->id}}" data-username="{{$user->username}}">Following</button>
                                    @else
                                        <button class="followBtn" data-id="{{$user->id}}" data-username="{{$user->username}}">Follow</button>
                                    @endif
                                    @if($user->biography)
                                        <div class="searched-user-bio">{{$user->biography}}</div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                    @if(count($users) > 3 && $filter !== "people")
                        <div id="viewAllPeople">
                            <a href="{{route('explore')}}?q={{rawurlencode($query)}}&filter=people">View all</a>
                        </div>
                    @endif
                </div>
            @endif
                @if(count($posts))
                    <div id="searchPostsResult">
                        @foreach($posts as $post)
                            <div class="single-post" data-id="{{$post->id}}">
                                <div class="post-more-options-wrapper">
                                    <div class="more-options w-embed post-more-options">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                            <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                                        </svg>
                                    </div>
                                    <div class="choose-post-option">
                                        <div class="single-post-option block-user" data-id="{{$post->user->id}}" data-username="{{$post->user->username}}"><div class="block-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--ic" role="img" aria-hidden="true" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2M4 12c0-4.42 3.58-8 8-8c1.85 0 3.55.63 4.9 1.69L5.69 16.9A7.9 7.9 0 0 1 4 12m8 8c-1.85 0-3.55-.63-4.9-1.69L18.31 7.1A7.9 7.9 0 0 1 20 12c0 4.42-3.58 8-8 8" fill="currentColor"></path></svg></div>Block &#64;{{$post->user->username}}</div>
                                        @if($post->user->loggedInUserFollowing)
                                            <div class="single-post-option unfollow-user" data-id="{{$post->user->id}}" data-username="{{$post->user->username}}"><i class="fa-solid fa-user-xmark"></i> Unfollow &#64;{{$post->user->username}}</div>
                                        @else
                                            <div class="single-post-option follow-user" data-id="{{$post->user->id}}" data-username="{{$post->user->username}}"><i class="fa-solid fa-user-plus"></i> Follow &#64;{{$post->user->username}}</div>
                                        @endif
                                        <button id="cancelOption" class="cancelPopupBtn">Cancel</button>
                                    </div>

                                </div>

                                <a href="{{route('profile', ['username' => $post->user->username])}}"><img src="{{asset('assets/img/users/' . $post->user->photo)}}" loading="eager" alt="" class="user-image" /></a>
                                <div class="post-info-and-body">
                                    <div class="post-info">
                                        <a href="{{route('profile', ['username' => $post->user->username])}}" class="posted-by-fullname">{{$post->user->full_name}}</a>
                                        <a href="{{route('profile', ['username' => $post->user->username])}}" class="posted-by-username">&#64;{{$post->user->username}}</a>
                                        <div class="dot">·</div>
                                        <div class="posted-on-date-text">{{$post->created_at}}</div>
                                    </div>
                                    <div class="post-body">
                                        @if($post->content)
                                            <p class="post-body-text">{!!$post->content!!}</p>
                                        @endif
                                        @if($post->image)
                                            <img
                                                    src="{{asset('assets/img/posts/' . $post->image->image)}}"
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
                                            <div class="post-reaction-stats-text">{{$post->number_of_comments > 0 ? $post->number_of_comments : ""}}</div>
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
                                            <div class="post-reaction-stats-text {{$post->user_liked ? "likedPost" : ""}}">{{$post->number_of_likes > 0 ? $post->number_of_likes : ""}}</div>
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
                        @endforeach
                        @if(count($posts) > 5 && $filter !== "posts")
                            <div id="viewAllPosts">
                                <a href="{{route('explore')}}?q={{rawurlencode($query)}}&filter=posts">View all</a>
                            </div>
                        @endif
                    </div>
                @endif
        </div>
    @endif
</section>
    <script src="{{asset("assets/js/explore.js")}}"></script>
@endsection