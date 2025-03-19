@extends('layouts.main')
@section('title') Home @endsection
@section('content')
<section id="messages" class="content messages">
    <div class="messages-wrapper">
        <div class="content-name-div">
            <div class="content-name">Messages</div>
            <div class="new-message-icon w-embed">
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
                    <path fill="currentColor" d="M22 4c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4zm-2 13.17L18.83 16H4V4h16zM13 5h-2v4H7v2h4v4h2v-4h4V9h-4z"></path>
                </svg>
            </div>
        </div>
        <div class="search-wrapper messages-search-wrapper">
            <div class="search-div">
                <div class="icon-embed-xsmall-3 w-embed">
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
                <div class="search-form w-form">
                    <form
                            id="email-form"
                            name="email-form"
                            data-name="Email Form"
                            method="get"
                            class="form-2"
                            data-wf-page-id="67b61da06092cd17329df273"
                            data-wf-element-id="c8442348-8eb0-1fa2-063b-f770bf60c2fd"
                            data-turnstile-sitekey="0x4AAAAAAAQTptj2So4dx43e"
                    >
                        <input class="search-input w-input" maxlength="256" name="message-search" data-name="message-search" placeholder="Search Direct Messages" type="text" id="message-search" />
                    </form>
                </div>
            </div>
        </div>
        <div class="all-messages">
            <div class="single-message">
                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="user-image" />
                <div class="message-sender-info">
                    <div class="messaged-by-user-info">
                        <div class="messaged-by-fullname">Marko Stankovic</div>
                        <div class="messaged-by-username">@markostanke2002</div>
                        <div class="dot">·</div>
                        <div class="last-sent-time-text">15h</div>
                    </div>
                    <div class="message-from-user">Cao brate</div>
                </div>
                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67bd987eda529b92af7c73e7_IcBaselineMoreHoriz.png')}}" loading="lazy" alt="" class="more-options-message" />
            </div>
            <div class="single-message new-message">
                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="user-image" />
                <div class="message-sender-info">
                    <div class="messaged-by-user-info">
                        <div class="messaged-by-fullname">Marko Stankovic</div>
                        <div class="messaged-by-username">@markostanke2002</div>
                        <div class="dot">·</div>
                        <div class="last-sent-time-text">15h</div>
                    </div>
                    <div class="message-from-user new-message">Cao brate</div>
                </div>
                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67bd987eda529b92af7c73e7_IcBaselineMoreHoriz.png')}}" loading="lazy" alt="" class="more-options-message" />
                <div class="icon-embed-small-2 w-embed">
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
                        <circle cx="16" cy="16" r="8" fill="currentColor"></circle>
                    </svg>
                </div>
            </div>
            <div class="single-message active-chat">
                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="user-image" />
                <div class="message-sender-info">
                    <div class="messaged-by-user-info">
                        <div class="messaged-by-fullname">Marko Stankovic</div>
                        <div class="messaged-by-username">@markostanke2002</div>
                        <div class="dot">·</div>
                        <div class="last-sent-time-text">15h</div>
                    </div>
                    <div class="message-from-user">Cao brate</div>
                </div>
                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67bd987eda529b92af7c73e7_IcBaselineMoreHoriz.png')}}" loading="lazy" alt="" class="more-options-message" />
            </div>
        </div>
    </div>
    <div class="chat">
        <div class="chat-user-fullname">Marko Stankovic</div>
        <div class="chat-user-info-wrapper">
            <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="chat-user-image" />
            <div class="chat-user-info">
                <div class="chat-user-info-fullname">Marko Stankovic</div>
                <div class="chat-user-info-username">@markostanke2002</div>
                <div class="chat-user-bio">Ovo je moja biografija</div>
                <div class="chat-user-date-joined-and-followers">
                    <div class="user-joined-date">Joined February 2025</div>
                    <div class="dot">·</div>
                    <div class="chat-user-num-of-followers">1 Follower</div>
                </div>
            </div>
        </div>
        <div class="chat-messages-wrapper">
            <div class="sent-message-wrapper">
                <div class="sent-message">
                    <p class="message-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero vitae
                        erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique posuere.
                    </p>
                </div>
                <div class="sent-message-info">May 28, 2024, 11:05 AM</div>
            </div>
            <div class="received-message-wrapper">
                <div class="received-message">
                    <p class="message-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero vitae
                        erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique posuere.
                    </p>
                </div>
                <div class="received-message-info">May 28, 2024, 11:25 AM</div>
            </div>
            <div class="sent-message-wrapper">
                <div class="sent-message">
                    <p class="message-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero vitae
                        erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique posuere.
                    </p>
                </div>
                <div class="sent-message-info">May 28, 2024, 11:05 AM</div>
            </div>
            <div class="received-message-wrapper">
                <div class="received-message">
                    <p class="message-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero vitae
                        erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique posuere.
                    </p>
                </div>
                <div class="received-message-info">May 28, 2024, 11:25 AM</div>
            </div>
            <div class="received-message-wrapper">
                <div class="received-message">
                    <p class="message-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero vitae
                        erat. Aenean faucibus nibh et justo cursus id rutrum lorem imperdiet. Nunc ut sem vitae risus tristique posuere.
                    </p>
                </div>
                <div class="received-message-info">May 28, 2024, 11:25 AM</div>
            </div>
        </div>
        <div class="send-message-div">
            <div class="send-message-form w-form">
                <form
                        id="email-form-2"
                        name="email-form-2"
                        data-name="Email Form 2"
                        method="get"
                        class="form-3"
                        data-wf-page-id="67b61da06092cd17329df273"
                        data-wf-element-id="9e904a35-d3ac-6b33-8a50-ddbc237c6bcc"
                        data-turnstile-sitekey="0x4AAAAAAAQTptj2So4dx43e"
                >
                    <input class="type-message-input w-input" maxlength="256" name="new-message-text" data-name="new-message-text" placeholder="Start a new message" type="text" id="new-message-text" />
                </form>
            </div>
            <div class="send-message-icon can-send-icon w-embed">
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
                    <path fill="currentColor" d="M2.01 21L23 12L2.01 3L2 10l15 2l-15 2z"></path>
                </svg>
            </div>
        </div>
    </div>
</section>
@endsection