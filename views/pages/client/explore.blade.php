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
            <div class="search-form">
                <form
                        id="searchForm"
                        name="searchForm"
                        data-name="Search Form"
                        method="get"
                        class="form-2"
                        data-wf-page-id="67b61da06092cd17329df273"
                        data-wf-element-id="d03f3054-631c-3eac-7d9b-daaf0230fa69"
                        data-turnstile-sitekey="0x4AAAAAAAQTptj2So4dx43e"
                >
                    <input class="search-input w-input" name="Search" data-name="Search" placeholder="Search" type="text" id="Search" autocomplete="off" />
                </form>
            </div>
        </div>

    </div>
</section>
    <script src="{{asset("assets/js/explore.js")}}"></script>
@endsection