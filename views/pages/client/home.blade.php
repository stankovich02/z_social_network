@extends('layouts.main')
@section('title') Home @endsection
@section('content')
    <section class="content">

        <div class="posts-filter">
            <div class="foryou-filter"><div class="post-filter-text active-post-filter">For you</div></div>
            <div class="following-filter"><div class="post-filter-text">Following</div></div>
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
                    <div id="postEmojiImagePick">
                        <div id="emojiPicker"></div>
                        <div class="icon-embed-xsmall w-embed upload-post-image">
                            <i class="fa-regular fa-image"></i>
                        </div>
                    </div>
                    <button class="submit-post-btn w-button disabled-new-post-btn" id="feedPostBtn" disabled>Post</button>
                </div>
            </div>
        </div>
        <script type="module">
            import { EmojiButton } from 'https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.4/dist/index.min.js';


            const html = '<i class="fa-regular fa-face-smile pickEmoji"></i>';
            document.getElementById("emojiPicker").innerHTML += html;

            const picker = new EmojiButton({
                position: 'top-start',
                theme: 'auto'
            });

            const input = document.querySelector("#post-body");
            let submitPostBtn = document.querySelector("#feedPostBtn");

            picker.on('emoji', emoji => {
                input.value += emoji.emoji;
                submitPostBtn.classList.remove("disabled-new-post-btn");
                submitPostBtn.disabled = false;
            });
            let emojiIcon = document.querySelector("#feedNewPost .pickEmoji");
            emojiIcon.addEventListener('click', () => {
                picker.togglePicker(emojiIcon);
            });
        </script>
        <div id="posts">
            @foreach($posts as $index => $post)
                @if(!in_array($post->user->id, $blockedUsers) && !in_array($post->user->id, $usersWhoBlockLoggedInUser))
                    <div class="single-post" data-id="{{$post->id}}">
                        <div class="post-more-options-wrapper">
                            <div class="more-options w-embed post-more-options">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ph more-opt-ic" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                    <path fill="currentColor" d="M144 128a16 16 0 1 1-16-16a16 16 0 0 1 16 16m-84-16a16 16 0 1 0 16 16a16 16 0 0 0-16-16m136 0a16 16 0 1 0 16 16a16 16 0 0 0-16-16"></path>
                                </svg>
                            </div>
                            <div class="choose-post-option">
                                    <div class="single-post-option block-user" data-id="{{$post->user->id}}" data-username="{{$post->user->username}}"><div class="block-icon w-embed"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" height="100%" width="100%" class="iconify iconify--ic" role="img" aria-hidden="true" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2M4 12c0-4.42 3.58-8 8-8c1.85 0 3.55.63 4.9 1.69L5.69 16.9A7.9 7.9 0 0 1 4 12m8 8c-1.85 0-3.55-.63-4.9-1.69L18.31 7.1A7.9 7.9 0 0 1 20 12c0 4.42-3.58 8-8 8" fill="currentColor"></path></svg></div>Block &#64;{{$post->user->username}}</div>
                                @if($post->user->loggedInUserFollowing)
                                    <div class="single-post-option unfollow-user" data-id="{{$post->user->id}}" data-username="{{$post->user->username}}"><i class="fa-solid fa-user-xmark"></i> Unfollow &#64;{{$post->user->username}}</div>
                                @else
                                    <div class="single-post-option follow-user" data-id="{{$post->user->id}}" data-username="{{$post->user->username}}"><i class="fa-solid fa-user-plus"></i> Follow &#64;{{$post->user->username}}</div>
                                @endif
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
                                @if($post->content)
                                    <p class="post-body-text">{!!$post->content!!}</p>
                                @endif
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
                                    <div class="post-reaction-stats-text">{{$post->number_of_comments > 0 ? $post->number_of_comments : ""}}</div>
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
            <div id="load-more"></div>
        </div>
    </section>
    <script src="{{asset('assets/js/home.js')}}"></script>
@endsection
