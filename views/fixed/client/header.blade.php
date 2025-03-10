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