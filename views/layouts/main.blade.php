<!DOCTYPE html>
<html data-wf-domain="z-social-network.webflow.io" data-wf-page="67b61da06092cd17329df273" data-wf-site="67b61da06092cd17329df26d" data-wf-status="1">
<head>
    <title>
        Z | @yield('title')
    </title>
    <script src="{{asset('assets/js/jquery-3.5.1.min.dc5e7f18c8.js')}}" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    @include("fixed.client.head")
</head>
<body class="body">
    <div class="container">
        @include("fixed.client.header")

        @yield("content")
    </div>
    <div class="popup-wrapper" id="new-post-popup-wrapper">
        <div class="new-post-popup">
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
            <div class="new-post new-post-popup-create">
                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="eager" alt="" class="user-image" />
                <div class="post-creating">
                    <div class="form-block w-form">
                        <form
                                id="wf-form-New-post"
                                name="wf-form-New-post"
                                data-name="New post"
                                method="get"
                                class="form"
                                data-wf-page-id="67b61da06092cd17329df273"
                                data-wf-element-id="6377f7de-df15-457c-e3aa-a91c0a5595fd"
                                data-turnstile-sitekey="0x4AAAAAAAQTptj2So4dx43e"
                        >
                            <textarea id="post-body-2" name="post-body-2" maxlength="5000" data-name="Post Body 2" placeholder="What is happening?!" class="new-post-body w-input"></textarea>
                        </form>
                        <div class="w-form-done"><div>Thank you! Your submission has been received!</div></div>
                        <div class="w-form-fail"><div>Oops! Something went wrong while submitting the form.</div></div>
                    </div>
                    <div class="post-options">
                        <div class="icon-embed-xsmall w-embed">
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
                        <a href="#" class="submit-post-btn w-button">Post</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{asset('assets/js/webflow.a0aa6ca1.8803622a53cb8314.js')}}" type="text/javascript"></script>
    <script src="{{asset("assets/js/main.js")}}"></script>
</body>
</html>
