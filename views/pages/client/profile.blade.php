@extends('layouts.main')
@section('title') Home @endsection
@section('content')
<section id="profile" class="content">
    <div class="top-profile-info">
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
                                <div class="post-stats-icon w-embed">
                                    <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            aria-hidden="true"
                                            role="img"
                                            class="iconify iconify--fe post-ic"
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
                                <div class="post-reaction-stats-text"></div>
                            </div>
                            <div class="post-reposted-stats">
                                <div class="post-stats-icon w-embed">
                                    <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            aria-hidden="true"
                                            role="img"
                                            class="iconify iconify--bx post-ic"
                                            width="100%"
                                            height="100%"
                                            preserveAspectRatio="xMidYMid meet"
                                            viewBox="0 0 24 24"
                                    >
                                        <path fill="currentColor" d="M19 7a1 1 0 0 0-1-1h-8v2h7v5h-3l3.969 5L22 13h-3zM5 17a1 1 0 0 0 1 1h8v-2H7v-5h3L6 6l-4 5h3z"></path>
                                    </svg>
                                </div>
                                <div class="post-reaction-stats-text"></div>
                            </div>
                            <div class="post-likes-stats">
                                <div class="post-stats-icon w-embed">
                                    <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            aria-hidden="true"
                                            role="img"
                                            class="iconify iconify--ph post-ic"
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
                                <div class="post-reaction-stats-text"></div>
                            </div>
                            <div class="post-views-stats">
                                <div class="post-stats-icon w-embed">
                                    <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            aria-hidden="true"
                                            role="img"
                                            class="iconify iconify--ic post-ic"
                                            width="100%"
                                            height="100%"
                                            preserveAspectRatio="xMidYMid meet"
                                            viewBox="0 0 24 24"
                                    >
                                        <path fill="currentColor" d="M4 9h4v11H4zm12 4h4v7h-4zm-6-9h4v16h-4z"></path>
                                    </svg>
                                </div>
                                <div class="post-reaction-stats-text">{{$post->views > 0 ? $post->views : ''}}</div>
                            </div>
                        </div>
                    </div>
                </div>
        @endforeach
    </div>
</section>
    <script src="{{asset('assets/js/profile.js')}}"></script>
@endsection