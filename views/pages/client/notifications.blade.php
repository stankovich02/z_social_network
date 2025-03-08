@extends('layouts.main')
@section('title') Home @endsection
@section('content')
<section id="notifications" class="content">
    <div class="single-notification">
        <div class="user-icon w-embed">
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
                <path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2S7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z" fill="currentColor"></path>
            </svg>
        </div>
        <div class="follower-info">
            <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="follower-image" />
            <div class="text-block"><strong>Marko Stankovic</strong> followed you</div>
        </div>
    </div>
    <div class="single-notification">
        <div class="heart-icon w-embed">
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
                <path fill="currentColor" fill-rule="evenodd" d="M12 20c-2.205-.48-9-4.24-9-11a5 5 0 0 1 9-3a5 5 0 0 1 9 3c0 6.76-6.795 10.52-9 11"></path>
            </svg>
        </div>
        <div class="liked-info">
            <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="user-image" />
            <div class="text-block"><strong>Marko Stankovic</strong> liked your post</div>
            <div class="liked-post-info">Test sadrzaj</div>
        </div>
    </div>
    <div class="single-notification">
        <div class="heart-icon w-embed">
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
                <path fill="currentColor" fill-rule="evenodd" d="M12 20c-2.205-.48-9-4.24-9-11a5 5 0 0 1 9-3a5 5 0 0 1 9 3c0 6.76-6.795 10.52-9 11"></path>
            </svg>
        </div>
        <div class="liked-info">
            <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="user-image" />
            <div class="text-block"><strong>Marko Stankovic</strong> liked your post</div>
            <div class="liked-post-info">Test sadrzaj</div>
            <a href="#" class="show-all-post">Show all</a>
        </div>
    </div>
    <div class="single-notification new-notification">
        <div class="heart-icon w-embed">
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
                <path fill="currentColor" fill-rule="evenodd" d="M12 20c-2.205-.48-9-4.24-9-11a5 5 0 0 1 9-3a5 5 0 0 1 9 3c0 6.76-6.795 10.52-9 11"></path>
            </svg>
        </div>
        <div class="liked-info">
            <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="user-image" />
            <div class="text-block"><strong>Marko Stankovic</strong> liked your post</div>
            <div class="liked-post-info">Test sadrzaj</div>
        </div>
    </div>
    <div class="single-comment">
        <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="eager" alt="" class="user-image" />
        <div class="comment-info">
            <div class="comment-user-info">
                <div class="commented-by-username">Marko Stankovic</div>
                <div class="commented-by-fullname">@markostanke2002</div>
                <div class="dot">·</div>
                <div class="commented-on-date-text">3 mins</div>
            </div>
            <div class="replying-to">Replying to <span class="text-span">@novikorisnik</span></div>
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
    <div class="single-notification">
        <div class="repost-icon w-embed">
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
                <path fill="currentColor" d="M19 7a1 1 0 0 0-1-1h-8v2h7v5h-3l3.969 5L22 13h-3zM5 17a1 1 0 0 0 1 1h8v-2H7v-5h3L6 6l-4 5h3z"></path>
            </svg>
        </div>
        <div class="repost-info">
            <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="user-image" />
            <div class="text-block"><strong>Marko Stankovic</strong> reposted your post</div>
            <div class="reposted-post-info">Test sadrzaj</div>
        </div>
    </div>
</section>
@endsection