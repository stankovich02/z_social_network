@extends('layouts.main')
@section('title') Following @endsection
@section('content')
    <div id="followingWrapper" class="content">
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
                <div class="top-username-text">&#64;{{$user->username}}</div>
            </div>
        </div>
        <div id="filterWrapper">
            <a href="{{route('profile.followers', ['username' => $user->username])}}" class="filterLink">
                <p>Followers</p>
            </a>
            <a href="{{route('profile.following', ['username' => $user->username])}}" class="filterLink">
                <p class="activeFollowFilter">Following</p>
            </a>
        </div>
        <div id="following">
           @foreach($user->following as $userProfile)
                <div class="single-following-user">
                    <img src="{{asset('assets/img/users/' . $userProfile->follower->photo)}}" loading="lazy" alt="" class="user-image" />
                    <div class="user-following-information">
                        <div class="user-following-fullname-and-username">
                            <div class="user-following-fullname">{{$userProfile->follower->full_name}}</div>
                            <div class="user-following-username">&#64;{{$userProfile->follower->username}}</div>
                        </div>
                        <button class="followingBtn" data-id="{{$userProfile->follower->id}}" data-username="{{$userProfile->follower->username}}">Following</button>
                        @if($userProfile->follower->biography)
                            <div class="user-following-bio">{{$userProfile->follower->biography}}</div>
                        @endif
                    </div>
                </div>
           @endforeach
        </div>
    </div>
    <script src="{{asset('assets/js/follow.js')}}"></script>
@endsection