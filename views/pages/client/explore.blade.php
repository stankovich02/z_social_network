@extends('layouts.main')
@section('title') Home @endsection
@section('content')
<section id="explore" class="content">
    <div class="search-wrapper">
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
                        data-wf-element-id="d03f3054-631c-3eac-7d9b-daaf0230fa69"
                        data-turnstile-sitekey="0x4AAAAAAAQTptj2So4dx43e"
                >
                    <input class="search-input w-input" maxlength="256" name="Search" data-name="Search" placeholder="Search" type="text" id="Search" />
                </form>
                <div class="w-form-done"><div>Thank you! Your submission has been received!</div></div>
                <div class="w-form-fail"><div>Oops! Something went wrong while submitting the form.</div></div>
            </div>
        </div>
        <div class="search-results">
            <div class="single-search-result">
                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="search-result-user-image" />
                <div class="search-result-user-info">
                    <div class="search-result-user-fullname">Marko Stankovic</div>
                    <div class="search-result-user-username">@stanke2002</div>
                </div>
            </div>
            <div class="single-search-result">
                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="search-result-user-image" />
                <div class="search-result-user-info">
                    <div class="search-result-user-fullname">Marko Stankovic</div>
                    <div class="search-result-user-username">@stanke2002</div>
                </div>
            </div>
            <div class="single-search-result">
                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="search-result-user-image" />
                <div class="search-result-user-info">
                    <div class="search-result-user-fullname">Marko Stankovic</div>
                    <div class="search-result-user-username">@stanke2002</div>
                </div>
            </div>
            <div class="single-search-result">
                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="search-result-user-image" />
                <div class="search-result-user-info">
                    <div class="search-result-user-fullname">Marko Stankovic</div>
                    <div class="search-result-user-username">@stanke2002</div>
                </div>
            </div>
            <div class="single-search-result">
                <img src="{{asset('assets/img/67b61da06092cd17329df26d/67b9c46d9abe545630bb3f09_default.jpg')}}" loading="lazy" alt="" class="search-result-user-image" />
                <div class="search-result-user-info">
                    <div class="search-result-user-fullname">Marko Stankovic</div>
                    <div class="search-result-user-username">@stanke2002</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection