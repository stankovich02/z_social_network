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
            @if($user->username === session()->get('user')->username)
                @if(!$user->biography && $user->photo === 'default.jpg' && $user->cover_photo === 'default-cover.jpg')
                    <button class="setup-profile w-button" id="setupProfile">Set up profile</button>
                @else
                    <button class="setup-profile w-button" id="editProfile">Edit profile</button>
                @endif
            @endif
        </div>
        <div class="profile-info-detailed">
            <div class="profile-fullname">{{$user->full_name}}</div>
            <div class="profile-username">&#64;{{$user->username}}</div>
            <p class="profile-bio">{{$user->biography ?? ''}}</p>
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
        @foreach($user->mergedPosts as $index => $post)
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
                                    src="{{asset('assets/img/posts/' . $post->post->image->image)}}"
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
                                @if($user->id === session()->get('user')->id)
                                    <div class="single-post-option delete-post" data-id="{{$post->id}}"><div class="trash-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--bx" role="img" aria-hidden="true" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm10.618-3L15 2H9L7.382 4H3v2h18V4z"></path></svg></div>Delete</div>
                                @else
                                    <div class="single-post-option block-user" data-id="{{$user->id}}"><div class="block-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--ic" role="img" aria-hidden="true" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2M4 12c0-4.42 3.58-8 8-8c1.85 0 3.55.63 4.9 1.69L5.69 16.9A7.9 7.9 0 0 1 4 12m8 8c-1.85 0-3.55-.63-4.9-1.69L18.31 7.1A7.9 7.9 0 0 1 20 12c0 4.42-3.58 8-8 8" fill="currentColor"></path></svg></div>Block &#64;{{$post->user->username}}</div>
                                @endif
                            </div>
                        </div>
                        <img src="{{asset('assets/img/users/' . $user->photo)}}" loading="eager" alt="" class="user-image" />
                        <div class="post-info-and-body">
                            <div class="post-info">
                                <div class="posted-by-fullname">{{$user->full_name}}</div>
                                <div class="posted-by-username">&#64;{{$user->username}}</div>
                                <div class="dot">·</div>
                                <div class="posted-on-date-text">{{$post->created_at}}</div>
                            </div>
                            <div class="post-body">
                                <p class="post-body-text">{{$post->content}}</p>
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
<div id="setupProfileWrapper" class="popup-wrapper">
    <div class="setup-profile-popup">
        <div class="top-setup-profile">
            <div class="icon-embed-xsmall-5 w-embed" id="returnBackSetupProfile">
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
            <img src="{{asset('assets/img/logo_large.png')}}" loading="lazy" alt="" class="popup-logo" />
            <div class="close-icon w-embed">
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
        </div>
        <div class="pick-profile-picture">
            <div class="pick-text-wrapper">
                <div class="pick-text">Pick a profile picture</div>
                <div class="pick-desc">Have a favorite selfie? Upload it now.</div>
            </div>
            <div class="pick-picture-wrapper">
                <img
                        src="{{asset('assets/img/users/' . $user->photo)}}"
                        loading="lazy"
                        sizes="100vw"
                        alt=""
                        class="pick-picture-image"
                />
                <div class="add-or-remove-photo-icons">
                    <input type="file" id="pickProfilePicture" class="hidden-file-input" name="profile-picture" />
                    <div class="add-new-photo-icon-wrapper">
                        <div class="add-new-photo-icon w-embed">
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
                                        d="M21 6h-3.17L16 4h-6v2h5.12l1.83 2H21v12H5v-9H3v9c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2M8 14c0 2.76 2.24 5 5 5s5-2.24 5-5s-2.24-5-5-5s-5 2.24-5 5m5-3c1.65 0 3 1.35 3 3s-1.35 3-3 3s-3-1.35-3-3s1.35-3 3-3M5 6h3V4H5V1H3v3H0v2h3v3h2z"
                                ></path>
                            </svg>
                        </div>
                    </div>
                    <div class="remove-new-photo-wrapper">
                        <div class="remove-new-photo-icon w-embed">
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
                    </div>
                </div>
            </div>
            <button class="skip-profile-btn w-button">Skip for now</button>
            <button class="next-profile-btn w-button">Next</button>
        </div>
        <div class="pick-header">
            <div class="pick-text-wrapper">
                <div class="pick-text">Pick a header</div>
                <div class="pick-desc">People who visit your profile will see it. Show your style.</div>
            </div>
            <div class="pick-header-img-wrapper">
                <img
                        src="{{asset('assets/img/users-covers/' . $user->cover_photo)}}"
                        loading="lazy"
                        sizes="100vw"
                        alt=""
                        class="pick-header-img"
                />
                <div class="add-or-remove-photo-icons">
                    <input type="file" id="pickHeaderPicture" class="hidden-file-input" name="profile-header-picture" />
                    <div class="add-new-photo-icon-wrapper">
                        <div class="add-new-photo-icon w-embed">
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
                                        d="M21 6h-3.17L16 4h-6v2h5.12l1.83 2H21v12H5v-9H3v9c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2M8 14c0 2.76 2.24 5 5 5s5-2.24 5-5s-2.24-5-5-5s-5 2.24-5 5m5-3c1.65 0 3 1.35 3 3s-1.35 3-3 3s-3-1.35-3-3s1.35-3 3-3M5 6h3V4H5V1H3v3H0v2h3v3h2z"
                                ></path>
                            </svg>
                        </div>
                    </div>
                    <div class="remove-new-photo-wrapper">
                        <div class="remove-new-photo-icon w-embed">
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
                    </div>
                </div>
            </div>
            <div class="current-profile-info">
                <img
                        src="{{asset('assets/img/users/' . $user->photo)}}"
                        loading="lazy"
                        sizes="100vw"
                        alt=""
                        class="current-profile-pic"
                />
                <div class="current-user-fullname"></div>
                <div class="current-user-username"></div>
            </div>
            <button class="skip-profile-btn w-button">Skip for now</button>
            <button class="next-profile-btn w-button">Next</button>
        </div>
        <div class="describe-bio">
            <div class="pick-text-wrapper">
                <div class="pick-text">Describe yourself</div>
                <div class="pick-desc">What makes you special? Don&#x27;t think too hard, just have fun with it.</div>
            </div>
            <div class="bio-text">
                <div class="bio-text-info">
                    <div class="yourbio">Your bio</div>
                    <div class="max-num-of-letters"><span class="num-of-letters">0</span> / 160</div>
                </div>
                <div class="bio-form w-form">
                    <form
                            id="wf-form-Biography"
                            name="wf-form-Biography"
                            data-name="Biography"
                            method="get"
                            class="form"
                            data-wf-page-id="67b61da06092cd17329df273"
                            data-wf-element-id="fd0f9d90-08ff-eaa0-6b65-8c70debd295c"
                            data-turnstile-sitekey="0x4AAAAAAAQTptj2So4dx43e"
                    >
                        <textarea id="biography" name="biography" data-name="biography" autofocus="autofocus" class="bio-input w-input"></textarea>
                    </form>
                </div>
            </div>
            <button class="skip-profile-btn w-button">Skip for now</button>
            <button class="next-profile-btn w-button">Next</button>
        </div>
        <div class="save-profile" id="saveProfileDiv">
            <img src="{{asset('assets/img/logo_large.png')}}" loading="lazy" alt="" class="save-profile-logo" />
            <div class="save-text">Click to save updates</div>
            <button class="save-profile-btn w-button">Save</button>
        </div>
    </div>
</div>
<div id="editProfileWrapper" class="popup-wrapper edit-popup">
    <div class="edit-profile-popup">
        <div class="top-edit-profile">
            <div class="close-icon close-edit-icon w-embed">
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
            <div class="edit-text">Edit profile</div>
            <button class="save-edited-profile w-button" data-id="{{$user->id}}">Save</button>
        </div>
        <div class="pick-header-img-wrapper">
            <img
                    src="{{asset('assets/img/users-covers/' . $user->cover_photo)}}"
                    loading="lazy"
                    sizes="100vw"
                    alt=""
                    class="pick-header-img"
            />
            <div class="add-or-remove-photo-icons">
                <input type="file" id="editHeaderPicture" class="hidden-file-input" name="cover-picture" />
                <div class="add-new-photo-icon-wrapper">
                    <div class="add-new-photo-icon w-embed">
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
                                    d="M21 6h-3.17L16 4h-6v2h5.12l1.83 2H21v12H5v-9H3v9c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2M8 14c0 2.76 2.24 5 5 5s5-2.24 5-5s-2.24-5-5-5s-5 2.24-5 5m5-3c1.65 0 3 1.35 3 3s-1.35 3-3 3s-3-1.35-3-3s1.35-3 3-3M5 6h3V4H5V1H3v3H0v2h3v3h2z"
                            ></path>
                        </svg>
                    </div>
                </div>
                <div class="remove-new-photo-wrapper">
                    <div class="remove-new-photo-icon w-embed">
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
                </div>
            </div>
        </div>
        <div class="edit-profile-pic">
            <img
                    src="{{asset('assets/img/users/' . $user->photo)}}"
                    loading="lazy"
                    sizes="100vw"
                    alt=""
                    class="current-profile-pic"
            />
            <div class="add-or-remove-photo-icons edit-profile-img-icon">
                <input type="file" id="editProfilePicture" class="hidden-file-input" name="profile-picture" />
                <div class="add-new-photo-icon-wrapper">
                    <div class="add-new-photo-icon w-embed">
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
                                    d="M21 6h-3.17L16 4h-6v2h5.12l1.83 2H21v12H5v-9H3v9c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2M8 14c0 2.76 2.24 5 5 5s5-2.24 5-5s-2.24-5-5-5s-5 2.24-5 5m5-3c1.65 0 3 1.35 3 3s-1.35 3-3 3s-3-1.35-3-3s1.35-3 3-3M5 6h3V4H5V1H3v3H0v2h3v3h2z"
                            ></path>
                        </svg>
                    </div>
                </div>
                <div class="remove-new-photo-wrapper">
                    <div class="remove-new-photo-icon w-embed">
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
                </div>
            </div>
        </div>
        <div class="current-fullname-wrapper">
            <div class="input-info">
                <div class="name-text">Name</div>
                <div class="max-num-of-characters"><span class="num-of-characters">0</span> / 50</div>
            </div>
            <div class="form-block-3 w-form">
                <form
                        id="email-form-5"
                        name="email-form-5"
                        data-name="Email Form 5"
                        method="get"
                        data-wf-page-id="67b61da06092cd17329df273"
                        data-wf-element-id="e3fc05a5-9080-97fa-ad0e-a98918343e4d"
                        data-turnstile-sitekey="0x4AAAAAAAQTptj2So4dx43e"
                >
                    <input class="current-name-input" name="current-fullname" data-name="current-fullname" type="text" id="current-fullname" value="{{$user->full_name}}"/>
                </form>
            </div>
        </div>
        <p class="errorMsg" id="editFullNameError"></p>
        <div class="current-bio-wrapper">
            <div class="input-info">
                <div class="name-text">Bio</div>
                <div class="max-num-of-characters"><span class="num-of-characters">0</span> / 160</div>
            </div>
            <div class="form-block-3 w-form">
                <form
                        id="email-form-5"
                        name="email-form-5"
                        data-name="Email Form 5"
                        method="get"
                        data-wf-page-id="67b61da06092cd17329df273"
                        data-wf-element-id="d72bb7c7-1537-77a7-9fbb-77d5964488a8"
                        data-turnstile-sitekey="0x4AAAAAAAQTptj2So4dx43e"
                >
                    <textarea class="current-biography-input">{{$user->biography}}</textarea>
                </form>
            </div>
        </div>
        <p class="errorMsg" id="editError"></p>
    </div>
</div>
    <script src="{{asset('assets/js/profile.js')}}"></script>
@endsection