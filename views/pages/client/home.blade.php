@extends('layouts.main')
@section('title') Home @endsection
@section('content')
    <section class="content">

        <div class="posts-filter">
            <div class="foryou-filter"><div class="post-filter-text">For you</div></div>
            <div class="following-filter"><div class="post-filter-text active-post-filter">Following</div></div>
        </div>
        <div class="new-post" id="feedNewPost">
            <img src="{{asset('assets/img/users/' . session()->get('user')->photo)}}" loading="eager" alt="" class="user-image" />
            <div class="post-creating">
                <div class="form-block w-form" id="newFormBlock">
                    <form
                            id="wf-form-New-post"
                            name="wf-form-New-post"
                            data-name="New post"
                            method="get"
                            class="form"
                            data-wf-page-id="67b61da06092cd17329df273"
                            data-wf-element-id="597e778f-5c18-5f26-9e21-f051fb8e894a"
                            data-turnstile-sitekey="0x4AAAAAAAQTptj2So4dx43e"
                    >
                        <textarea id="post-body" name="post-body" maxlength="5000" data-name="post-body" placeholder="What is happening?!" class="new-post-body w-input"></textarea>
                        <input type="file" id="fileInput" class="hidden-file-input" name="post-image">
                    </form>
                </div>
                <div class="post-options">
                    <div class="icon-embed-xsmall w-embed upload-post-image">
                        <svg
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true"
                                role="img"
                                class="iconify iconify--carbon"
                                width="100%"
                                height="100%"
                                preserveAspectRatio="xMidYMid meet"
                                viewBox="0 0 32 32"
                        >
                            <path fill="currentColor" d="M19 14a3 3 0 1 0-3-3a3 3 0 0 0 3 3m0-4a1 1 0 1 1-1 1a1 1 0 0 1 1-1"></path>
                            <path
                                    fill="currentColor"
                                    d="M26 4H6a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h20a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2m0 22H6v-6l5-5l5.59 5.59a2 2 0 0 0 2.82 0L21 19l5 5Zm0-4.83l-3.59-3.59a2 2 0 0 0-2.82 0L18 19.17l-5.59-5.59a2 2 0 0 0-2.82 0L6 17.17V6h20Z"
                            ></path>
                        </svg>
                    </div>
                    <button class="submit-post-btn w-button disabled-new-post-btn" id="feedPostBtn" disabled>Post</button>
                </div>
            </div>
        </div>
        <div id="posts">
            @foreach($posts as $index => $post)
                @if(!in_array($post->user->id, session()->get('user')->blocked_users) && $post->user->id !== session()->get('user')->id)
                    <div class="single-post" data-id="{{$post->id}}">
                        <div class="post-more-options-wrapper">
                            <div class="more-options w-embed post-more-options">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                    <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                                </svg>
                            </div>
                            <div class="choose-post-option">
                                    <div class="single-post-option block-user" data-id="{{$post->user->id}}"><div class="block-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--ic" role="img" aria-hidden="true" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2M4 12c0-4.42 3.58-8 8-8c1.85 0 3.55.63 4.9 1.69L5.69 16.9A7.9 7.9 0 0 1 4 12m8 8c-1.85 0-3.55-.63-4.9-1.69L18.31 7.1A7.9 7.9 0 0 1 20 12c0 4.42-3.58 8-8 8" fill="currentColor"></path></svg></div>Block &#64;{{$post->user->username}}</div>
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
                                    <div class="post-reaction-stats-text"></div>
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
                @endif
            @endforeach
        </div>
    </section>



<div class="popup-wrapper">
    <div class="new-message-popup">
        <div class="new-message-top">
            <div class="close-icon close-new-message w-embed">
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
            <div class="text-block-4">New message</div>
            <a href="#" class="new-message-next disabled-next-message-btn w-button">Next</a>
        </div>
        <div class="search-chat-people-form w-form">
            <div class="icon-embed-small-3 w-embed">
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
            <form
                    id="email-form-4"
                    name="email-form-4"
                    data-name="Email Form 4"
                    method="get"
                    class="form-5"
                    data-wf-page-id="67b61da06092cd17329df273"
                    data-wf-element-id="0996dad1-2861-4d58-9268-a417905059cb"
                    data-turnstile-sitekey="0x4AAAAAAAQTptj2So4dx43e"
            >
                <input class="search-people-chat-input w-input" maxlength="256" name="search-people" data-name="search-people" placeholder="Search people" type="text" id="search-people" />
            </form>
        </div>
        <div class="last-chats-wrapper">
            <div class="single-last-chat-user">
                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="user-image" />
                <div class="last-chat-user-info">
                    <div class="last-chat-user-fullname">Marko Stankovic</div>
                    <div class="last-chat-user-username">@markostanke2002</div>
                </div>
            </div>
            <div class="single-last-chat-user">
                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="user-image" />
                <div class="last-chat-user-info">
                    <div class="last-chat-user-fullname">Marko Stankovic</div>
                    <div class="last-chat-user-username">@markostanke2002</div>
                </div>
            </div>
            <div class="single-last-chat-user">
                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="user-image" />
                <div class="last-chat-user-info">
                    <div class="last-chat-user-fullname">Marko Stankovic</div>
                    <div class="last-chat-user-username">@markostanke2002</div>
                </div>
            </div>
            <div class="single-last-chat-user">
                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="user-image" />
                <div class="last-chat-user-info">
                    <div class="last-chat-user-fullname">Marko Stankovic</div>
                    <div class="last-chat-user-username">@markostanke2002</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="popup-wrapper">
    <div class="setup-profile-popup">
        <div class="top-setup-profile">
            <div class="icon-embed-xsmall-5 d-none w-embed">
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
            <img src="{{asset('assets/img/67b61da06092cd17329df26d/67c47292b287cfef93ba2a67_logo2.png')}}" loading="lazy" alt="" class="popup-logo" />
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
                        src="{{asset('67b61da06092cd17329df26d/67c2d609910d0c9573de80d1_default-avatar-icon-of-social-media-user-vector.jpg')}}"
                        loading="lazy"
                        sizes="100vw"
                        srcset="
                                {{asset('67b61da06092cd17329df26d/67c2d609910d0c9573de80d1_default-avatar-icon-of-social-media-user-vector-p-500.jpg')}} 500w,
                                {{asset('67b61da06092cd17329df26d/67c2d609910d0c9573de80d1_default-avatar-icon-of-social-media-user-vector.jpg')}}       980w
                            "
                        alt=""
                        class="pick-picture-image"
                />
                <div class="add-or-remove-photo-icons">
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
            <a href="#" class="skip-profile-btn w-button">Skip for now</a><a href="#" class="next-profile-btn w-button">Next</a>
        </div>
        <div class="pick-header">
            <div class="pick-text-wrapper">
                <div class="pick-text">Pick a header</div>
                <div class="pick-desc">People who visit your profile will see it. Show your style.</div>
            </div>
            <div class="pick-header-img-wrapper">
                <img
                        src="{{asset('67b61da06092cd17329df26d/67c473d4f5982184597bce10_black-pick-header.jpg')}}"
                        loading="lazy"
                        sizes="100vw"
                        srcset="
                                {{asset('67b61da06092cd17329df26d/67c473d4f5982184597bce10_black-pick-header-p-500.jpg')}}   500w,
                                {{asset('67b61da06092cd17329df26d/67c473d4f5982184597bce10_black-pick-header-p-800.jpg')}}   800w,
                                {{asset('67b61da06092cd17329df26d/67c473d4f5982184597bce10_black-pick-header-p-1080.jpg')}} 1080w,
                                {{asset('67b61da06092cd17329df26d/67c473d4f5982184597bce10_black-pick-header.jpg')}}        1280w
                            "
                        alt=""
                        class="pick-header-img"
                />
                <div class="add-or-remove-photo-icons">
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
                        src="{{asset('67b61da06092cd17329df26d/67c2d609910d0c9573de80d1_default-avatar-icon-of-social-media-user-vector.jpg')}}"
                        loading="lazy"
                        sizes="100vw"
                        srcset="
                                {{asset('67b61da06092cd17329df26d/67c2d609910d0c9573de80d1_default-avatar-icon-of-social-media-user-vector-p-500.jpg')}} 500w,
                                {{asset('67b61da06092cd17329df26d/67c2d609910d0c9573de80d1_default-avatar-icon-of-social-media-user-vector.jpg')}}       980w
                            "
                        alt=""
                        class="current-profile-pic"
                />
                <div class="current-user-fullname">Marko Stankovic</div>
                <div class="current-user-username">@markostanke2002</div>
            </div>
            <a href="#" class="skip-profile-btn w-button">Skip for now</a><a href="#" class="next-profile-btn w-button">Next</a>
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
            <a href="#" class="skip-profile-btn w-button">Skip for now</a><a href="#" class="next-profile-btn w-button">Next</a>
        </div>
        <div class="save-profile">
            <img src="{{asset('assets/img/67b61da06092cd17329df26d/67c47292b287cfef93ba2a67_logo2.png')}}" loading="lazy" alt="" class="save-profile-logo" />
            <div class="save-text">Click to save updates</div>
            <a href="#" class="save-profile-btn w-button">Save</a>
        </div>
    </div>
</div>
<div class="popup-wrapper edit-popup">
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
            <a href="#" class="save-edited-profile w-button">Save</a>
        </div>
        <div class="pick-header-img-wrapper">
            <img
                    src="{{asset('67b61da06092cd17329df26d/67c473d4f5982184597bce10_black-pick-header.jpg')}}"
                    loading="lazy"
                    sizes="100vw"
                    srcset="
                            {{asset('67b61da06092cd17329df26d/67c473d4f5982184597bce10_black-pick-header-p-500.jpg')}}   500w,
                            {{asset('67b61da06092cd17329df26d/67c473d4f5982184597bce10_black-pick-header-p-800.jpg')}}   800w,
                            {{asset('67b61da06092cd17329df26d/67c473d4f5982184597bce10_black-pick-header-p-1080.jpg')}} 1080w,
                            {{asset('67b61da06092cd17329df26d/67c473d4f5982184597bce10_black-pick-header.jpg')}}        1280w
                        "
                    alt=""
                    class="pick-header-img"
            />
            <div class="add-or-remove-photo-icons">
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
                    src="{{asset('67b61da06092cd17329df26d/67c2d609910d0c9573de80d1_default-avatar-icon-of-social-media-user-vector.jpg')}}"
                    loading="lazy"
                    sizes="100vw"
                    srcset="
                            {{asset('67b61da06092cd17329df26d/67c2d609910d0c9573de80d1_default-avatar-icon-of-social-media-user-vector-p-500.jpg')}} 500w,
                            {{asset('67b61da06092cd17329df26d/67c2d609910d0c9573de80d1_default-avatar-icon-of-social-media-user-vector.jpg')}}       980w
                        "
                    alt=""
                    class="current-profile-pic"
            />
            <div class="add-or-remove-photo-icons edit-profile-img-icon">
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
                <div class="num-of-characters">0 / 50</div>
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
                    <input class="current-name-input w-input" maxlength="256" name="current-fullname" data-name="current-fullname" placeholder="Marko Stankovic" type="text" id="current-fullname" />
                </form>
            </div>
        </div>
        <div class="current-bio-wrapper">
            <div class="input-info">
                <div class="name-text">Bio</div>
                <div class="num-of-characters">0 / 160</div>
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
                    <textarea class="current-biography-input">Ovo je moja biografija</textarea>
                </form>
            </div>
        </div>
    </div>
</div>
    <script src="{{asset('assets/js/home.js')}}"></script>
@endsection
