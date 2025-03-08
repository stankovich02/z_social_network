<div class="header">
    <div class="left-bar-menu">
        <a href="" aria-current="page" class="w-inline-block w--current"><img src="{{asset("assets/img/67b61da06092cd17329df26d/67c47292b287cfef93ba2a67_logo2.png")}}" loading="lazy" alt="" class="logo" /></a>
        <div class="menu">
            @foreach(App\Models\Nav::with('icon') as $index => $nav)
                    <a href="{{$nav->route}}" class="single-link w-inline-block">
                        <div class="icon-embed-medium link-icon w-embed">
                            <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true"
                                    role="img"
                                    class="{{$nav->icon->className}}"
                                    width="100%"
                                    height="100%"
                                    preserveAspectRatio="xMidYMid meet"
                                    viewBox="0 0 24 24"
                            >
                                <path fill="currentColor" d="{{$nav->icon->path_d}}"></path>
                            </svg>
                        </div>
                        <div class="link-text">{{$nav->name}}</div>
                    </a>
            @endforeach

           {{-- <a href="#" class="single-link w-inline-block">
                <div class="icon-embed-medium link-icon w-embed">
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
                <div class="link-text">Explore</div>
            </a>
            <a href="#" class="single-link w-inline-block">
                <div class="icon-embed-medium link-icon w-embed">
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
                                d="M19 13.586V10c0-3.217-2.185-5.927-5.145-6.742C13.562 2.52 12.846 2 12 2s-1.562.52-1.855 1.258C7.185 4.074 5 6.783 5 10v3.586l-1.707 1.707A1 1 0 0 0 3 16v2a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-2a1 1 0 0 0-.293-.707zM19 17H5v-.586l1.707-1.707A1 1 0 0 0 7 14v-4c0-2.757 2.243-5 5-5s5 2.243 5 5v4c0 .266.105.52.293.707L19 16.414zm-7 5a2.98 2.98 0 0 0 2.818-2H9.182A2.98 2.98 0 0 0 12 22"
                        ></path>
                    </svg>
                </div>
                <div class="link-text">Notifications</div>
            </a>
            <a href="#" class="single-link w-inline-block">
                <div class="icon-embed-medium link-icon w-embed">
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
                        <path fill="currentColor" d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2zm-2 0l-8 5l-8-5zm0 12H4V8l8 5l8-5z"></path>
                    </svg>
                </div>
                <div class="link-text">Messages</div>
            </a>
            <a href="#" class="single-link w-inline-block">
                <div class="icon-embed-medium link-icon w-embed">
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
                <div class="link-text">Profile</div>
            </a>--}}
        </div>
        <a href="#" class="post-btn w-button">Post</a>
        <div id="logout-wrapper">
            <a href="{{route('logout')}}" id="logout-text">Logout, <span id="logged-user-fullname">{{session()->get('user')->full_name}}</span></a>
        </div>
        <div class="logged-in-user">
            <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="user-image" />
            <div class="logged-in-user-info">
                <div class="user-fullname">{{session()->get('user')->full_name}}</div>
                <div class="user-username">{{session()->get('user')->username}}</div>
            </div>
            <div class="more-options w-embed">
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
                    <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                </svg>
            </div>
        </div>
    </div>
</div>