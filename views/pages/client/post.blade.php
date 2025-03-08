@extends('layouts.main')
@section('title') Home @endsection
@section('content')
<section id="post" class="content">
    <div class="top-nav-post">
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
        <div class="text-block-3">Post</div>
    </div>
    <div class="post-info">
        <div class="posted-by-info">
            <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="user-image" />
            <div class="user-info">
                <div class="posted-by-fullname">Marko Stankovic</div>
                <div class="posted-by-username">@markostanke2002</div>
            </div>
        </div>
        <div class="post-body">
            <p class="post-body-text">Danas je novi dan, bas je to lepo</p>
            <img
                    src="{{asset('67b61da06092cd17329df26d/67b9d052f7767b39837c06fd_myPic.png')}}"
                    loading="lazy"
                    sizes="100vw"
                    srcset="
                                {{asset('67b61da06092cd17329df26d/67b9d052f7767b39837c06fd_myPic-p-500.png')}}  500w,
                                {{asset('67b61da06092cd17329df26d/67b9d052f7767b39837c06fd_myPic-p-800.png')}}  800w,
                                {{asset('67b61da06092cd17329df26d/67b9d052f7767b39837c06fd_myPic.png')}}       1002w
                            "
                    alt=""
                    class="post-image"
            />
        </div>
        <div class="posted-date-wrapper">
            <div class="posted-date-time">12:39 AM</div>
            <div class="dot">·</div>
            <div class="posted-date-date">Mar 1, 2025</div>
            <div class="dot">·</div>
            <div class="num-of-views"><span class="text-span-4">53K</span> Views</div>
        </div>
        <div class="post-reactions single-post-reactions">
            <div class="post-comment-stats">
                <div class="post-stats-icon singe-post-stats-icon w-embed">
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
                <div class="post-reaction-stats-text">45</div>
            </div>
            <div class="post-reposted-stats">
                <div class="post-stats-icon singe-post-stats-icon w-embed">
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
                <div class="post-reaction-stats-text">1K</div>
            </div>
            <div class="post-likes-stats">
                <div class="post-stats-icon singe-post-stats-icon w-embed">
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
                <div class="post-reaction-stats-text">1.3K</div>
            </div>
        </div>
        <div class="new-comment-wrapper">
            <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="user-image" />
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
                    <textarea class="new-comment-text">Post your reply</textarea>
                </form>
                <div class="w-form-done"><div>Thank you! Your submission has been received!</div></div>
                <div class="w-form-fail"><div>Oops! Something went wrong while submitting the form.</div></div>
            </div>
            <a href="#" class="reply-comment disabled-new-comment w-button">Reply</a>
        </div>
        <div class="other-comments">
            <div class="single-comment p-x-none">
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
    </div>
</section>
@endsection