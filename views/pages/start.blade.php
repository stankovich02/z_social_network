<!DOCTYPE html>
<html data-wf-domain="z-social-network.webflow.io" data-wf-page="67b61da06092cd17329df273" data-wf-site="67b61da06092cd17329df26d" data-wf-status="1">
<head>
    <title>
        Z
    </title>
    @include("fixed.client.head")
</head>
<body class="body">
    <div id="opening-wrapper">
        <img src="{{asset("assets/img/logo_large.png")}}" alt="Logo"/>
        <div id="opening-right-section">
            <h1 id="opening-heading">It happens now</h1>
            <h2 id="join-text">Join today.</h2>
            <button type="button" id="register-btn">Register</button>
            <div id="login-question">
                <div id="has-account-text">Already have an account?</div>
                <button type="button" id="login-btn">Login</button>
            </div>
        </div>
    </div>
    <div class="popup-wrapper" id="register-login-wrapper" @if($errors->all() || session()->has('success-message') || session()->has('error-message')) style="display:block;" @endif>
        <div id="register-login-popup">
            <div class="register-login-top">
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
            <div id="register-container" @if($errors->all() || session()->has('success-message')) style="display:block;" @endif>
                <h1 id="create-account-text">Create an account</h1>
                <form
                        id="register-form"
                        name="register-form"
                        data-name="Register Form"
                        method="post"
                        action="{{route('register')}}"
                >
                <div class="inputs">
                    <div id="name-wrapper">
                        <div class="input-info">
                            <div class="name-text">Name</div>
                            <div class="num-of-characters"><span class="current-num-of-characters">0</span> / 50</div>
                        </div>
                        <input class="w-input" name="full_name" data-name="full_name" type="text" id="register-fullname" value="{{old('full_name')}}"/>
                    </div>
                    @if($errors->has('full_name'))
                        <p class="validationError">{{$errors->first('full_name')}}</p>
                    @endif
                    <div id="username-wrapper">
                        <div class="input-info">
                            <div class="name-text">Username</div>
                            <div class="num-of-characters"><span class="current-num-of-characters">0</span> / 50</div>
                        </div>
                        <input class="w-input" name="username" data-name="username" type="text" id="register-username" value="{{old('username')}}"/>
                    </div>
                    @if($errors->has('username'))
                        <p class="validationError">{{$errors->first('username')}}</p>
                    @endif
                    <div id="email-wrapper">
                        <div class="input-info">
                            <div class="name-text">Email</div>
                        </div>
                        <input class="w-input" name="email" data-name="email" type="text" id="register-email" value="{{old('email')}}"/>
                    </div>
                    @if($errors->has('email'))
                        <p class="validationError">{{$errors->first('email')}}</p>
                    @endif
                    <div id="password-wrapper">
                        <div class="input-info">
                            <div class="name-text">Password</div>
                        </div>
                        <input class="w-input" name="password" data-name="password" type="password" id="register-password" value="{{old('password')}}"/>
                    </div>
                    @if($errors->has('password'))
                        <p class="validationError">{{$errors->first('password')}}</p>
                    @endif
                </div>
                <button type="submit" id="submit-register-form">Register</button>
                @if(session()->has('success-message'))
                    <p class="success-message">{{session()->getFlash('success-message')}}</p>
                @endif
            </form>
            </div>
            <div id="login-container" @if(session()->has('error-message')) style="display: block" @endif>
                <h1 id="login-to-account-text">Sign in to Z network.</h1>
                <form
                        id="login-form"
                        name="login-form"
                        data-name="Login Form"
                        method="post"
                        action="{{route('login')}}"
                >
                    <div class="inputs">
                        <div id="username-wrapper">
                            <div class="input-info">
                                <div class="name-text">Username</div>
                            </div>
                            <input class="w-input" name="username" data-name="username" type="text" id="login-username" value="{{old('username')}}" />
                        </div>
                        <div id="password-wrapper">
                            <div class="input-info">
                                <div class="name-text">Password</div>
                            </div>
                            <input class="w-input" name="password" data-name="password" type="password" id="login-password" value="{{old('password')}}"/>
                            <svg id="opened-eye" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--tabler eye-icon" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0-4 0"></path><path d="M21 12q-3.6 6-9 6t-9-6q3.6-6 9-6t9 6"></path></g></svg>
                            <svg id="closed-eye" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--iconoir eye-icon" width="100%" height="100%" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="m3 3l18 18M10.5 10.677a2 2 0 0 0 2.823 2.823"></path><path d="M7.362 7.561C5.68 8.74 4.279 10.42 3 12c1.889 2.991 5.282 6 9 6c1.55 0 3.043-.523 4.395-1.35M12 6c4.008 0 6.701 3.158 9 6a15.66 15.66 0 0 1-1.078 1.5"></path></g></svg>
                        </div>
                        @if(session()->has('error-message'))
                            <p class="errorMsg">{{session()->getFlash('error-message')}}</p>
                        @endif
                    </div>

                    <button type="submit" id="submit-login-form">Login</button>
                </form>
            </div>
        </div>
    </div>
    @if(session()->has('verification-message'))
        <div id="verification" class="notification-popup">
            <p id="verification-message" class="notification-message">{{session()->getFlash('verification-message')}}</p>
        </div>
    @endif
    @if(session()->has('error-verification-message'))
        <div id="error-verification" class="notification-popup">
            <p id="error-verification-message" class="notification-message">{{session()->getFlash('error-verification-message')}}</p>
        </div>
    @endif
<script src="{{asset('assets/js/jquery-3.5.1.min.dc5e7f18c8.js')}}" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="{{asset('assets/js/webflow.a0aa6ca1.8803622a53cb8314.js')}}" type="text/javascript"></script>
<script src="{{asset("assets/js/start.js")}}"></script>
</body>
</html>
