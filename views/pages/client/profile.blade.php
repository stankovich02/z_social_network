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
            <div class="top-fullname-text">Marko Stankovic</div>
            <div class="num-of-posts">0 posts</div>
        </div>
    </div>
    <img
            src="{{asset('67b61da06092cd17329df26d/67c2db6961477e2704cc081b_default_banner.jpg')}}"
            loading="lazy"
            sizes="100vw"
            srcset="
                        {{asset('67b61da06092cd17329df26d/67c2db6961477e2704cc081b_default_banner-p-500.jpg')}}   500w,
                        {{asset('67b61da06092cd17329df26d/67c2db6961477e2704cc081b_default_banner-p-800.jpg')}}   800w,
                        {{asset('67b61da06092cd17329df26d/67c2db6961477e2704cc081b_default_banner-p-1080.jpg')}} 1080w,
                        {{asset('67b61da06092cd17329df26d/67c2db6961477e2704cc081b_default_banner.jpg')}}        1280w
                    "
            alt=""
            class="profile-banner"
    />
    <div class="profile-info">
        <div class="image-and-setup">
            <img
                    src="{{asset('67b61da06092cd17329df26d/67c2d609910d0c9573de80d1_default-avatar-icon-of-social-media-user-vector.jpg')}}"
                    loading="lazy"
                    sizes="100vw"
                    srcset="
                                {{asset('67b61da06092cd17329df26d/67c2d609910d0c9573de80d1_default-avatar-icon-of-social-media-user-vector-p-500.jpg')}} 500w,
                                {{asset('67b61da06092cd17329df26d/67c2d609910d0c9573de80d1_default-avatar-icon-of-social-media-user-vector.jpg')}}       980w
                            "
                    alt=""
                    class="profile-image"
            />
            <a href="#" class="setup-profile w-button">Set up profile</a>
        </div>
        <div class="profile-info-detailed">
            <div class="profile-fullname">Marko Stankovic</div>
            <div class="profile-username">@markostanke2002</div>
            <p class="profile-bio">Ovo je moja biografija</p>
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
                <div class="joined-date-text">Joined October 2016</div>
            </div>
            <div class="follow-stats">
                <div class="following-stats">16 <span class="text-span-2">Following</span></div>
                <div class="followers-stats">0 <span class="text-span-3">Followers</span></div>
            </div>
        </div>
    </div>
</section>
@endsection