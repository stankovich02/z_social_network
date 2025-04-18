@extends('layouts.main')
@section('title') Followers @endsection
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
            <div class="filterWrapper">
                @if(count($matchedFollowers) > 0)
                    <a href="{{route('profile.followers_you_follow', ['username' => $user->username])}}" class="filterLink">
                        <p class="w-65">Followers you know</p>
                    </a>
                @endif
                <a href="{{route('profile.followers', ['username' => $user->username])}}" class="filterLink">
                    <p class="activeFollowFilter {{count($matchedFollowers) > 0 ? "w-65" : ""}}">Followers</p>
                </a>
                <a href="{{route('profile.following', ['username' => $user->username])}}" class="filterLink">
                    <p class="{{count($matchedFollowers) > 0 ? "w-65" : ""}}">Following</p>
                </a>
            </div>
            <div id="followers">
                @if($user->followers)
                    @foreach($user->followers as $userProfile)
                        <a href={{route('profile', ['username' => $userProfile->user->username])}} class="single-follower-user">
                            <img src="{{asset('assets/img/users/' . $userProfile->user->photo)}}" loading="lazy" alt="" class="user-image" />
                            <div class="user-follower-information">
                                <div class="user-follower-fullname-and-username">
                                    <div class="user-follower-fullname">{{$userProfile->user->full_name}}</div>
                                    <div class="user-follower-username">&#64;{{$userProfile->user->username}}</div>
                                    @if($user->username === session()->get('user')->username)
                                        <div class="followsBackInfo">Follows you</div>
                                    @endif
                                </div>
                                @if($user->username === session()->get('user')->username)
                                    @if($userProfile->user->loggedInUserFollowsFollower)
                                        <button class="followingBtn" data-id="{{$userProfile->user->id}}">Following</button>
                                    @else
                                        <button class="followBackBtn" data-id="{{$userProfile->user->id}}">Follow back</button>
                                    @endif
                                    <div class="single-follower-more-options-wrapper">
                                        <div class="more-options w-embed single-follower-more-options">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                                <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                                            </svg>
                                        </div>
                                        <div class="choose-follower-option">
                                            <div class="single-follower-option block-user" data-id="{{$userProfile->user->id}}" data-username="{{$userProfile->user->username}}"><div class="block-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--ic" role="img" aria-hidden="true" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2M4 12c0-4.42 3.58-8 8-8c1.85 0 3.55.63 4.9 1.69L5.69 16.9A7.9 7.9 0 0 1 4 12m8 8c-1.85 0-3.55-.63-4.9-1.69L18.31 7.1A7.9 7.9 0 0 1 20 12c0 4.42-3.58 8-8 8" fill="currentColor"></path></svg></div>Block &#64;{{$userProfile->user->username}}</div>
                                            <div class="single-follower-option remove-user-from-followers" data-id="{{$userProfile->user->id}}" data-username="{{$userProfile->user->username}}"><i class="fa-solid fa-user-xmark"></i> Remove this follower</div>
                                        </div>
                                    </div>
                                @endif
                                @if($userProfile->user->biography)
                                    <div class="user-follower-bio">{{$userProfile->user->biography}}</div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                @else
                    <div id="noFollowers">
                        <h2>Looking for followers?</h2>
                        <p>When someone follows this account, they’ll show up here. Posting and interacting with others helps boost followers.</p>
                    </div>
                @endif
            </div>
        </div>
        <script src="{{asset('assets/js/follow.js')}}"></script>
@endsection