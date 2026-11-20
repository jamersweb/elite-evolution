<!doctype html>
<html lang="en">
@php
    $developers = \App\Models\Developer::whereStatus(1)
        ->withCount(['property as listings_count' => function ($query) {
            $query->where('status', 1);
        }])
        ->orderByDesc('listings_count')
        ->orderBy('name')
        ->get();
    $areaGroups = \App\Support\MarketGuide::groups();
    $areaPlaces = \App\Support\MarketGuide::places();
    $trendingArea = \App\Support\MarketGuide::trending();
@endphp
<head>
    <meta name="google-site-verification" content="IhgCw9qmFlZizqVMzl9Remx66F0_G-pIlzaFFYjg_bg" />
    <!-- Google tag (gtag.js) -->
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
    </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5GFVS3JW');</script>
    <!-- End Google Tag Manager -->

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="{!! trim($__env->yieldContent('meta_description')) !!}">
    <meta name="title" content="{!! trim($__env->yieldContent('meta_title')) !!}">
    <meta name="keyword" content="{!! trim($__env->yieldContent('meta_tag')) !!}">

    <title>{!! trim($__env->yieldContent('title')) !!}</title>
    <link rel="icon" href="{{asset('favicon.png')}}">







    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a96422e881.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/guides.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style type="text/css">
        .hs-form__virality-link{display: none !important;}
    </style>
</head>

<body class="{{ request()->routeIs('welcome') ? 'is-home' : '' }}">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5GFVS3JW"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<nav class="navbar navbar-expand-lg navbar-light px-md-5 nav-banner {{ request()->routeIs('welcome') ? 'is-overlay' : 'bg-white' }}">
    <div class="container-fluid ee-header">
        <div class="ee-header-top">
            <a class="navbar-brand d-flex align-items-center" href="{{url('/')}}">
                <img class="elit-img logo-dark" src="{{asset('management/images/elite-evolution-real-estate-in-black.png')}}" onerror="this.onerror=null;this.src='{{asset('management/images/logo.png')}}';" alt="Elite Evolution Real Estate">
                <img class="elit-img logo-light" src="{{asset('management/images/elite-evolution-real-estate-in-white.png')}}" alt="">
                <span class="visually-hidden">Elite Evolution Real Estate</span>
            </a>
            <div class="ee-header-tools">
                <a class="ee-nav-phone" href="tel:+971569700771">+971 56 970 0771</a>
                <select class="form-select font-weihgt" id="mySelect" aria-label="Country">
                    <option {{session('country') ==  'uae' ? 'selected' : ''}} value="{{url('/country/uae')}}">UAE</option>
                    <option {{session('country') ==  'uk' ? 'selected' : ''}}  value="{{url('/country/uk')}}">UK</option>
                </select>
                <a class="px-3 ee-heart" href="{{ url('wishlist') }}" aria-label="Saved homes">
                    <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 19L9.55 17.7052C4.4 13.1243 1 10.103 1 6.3951C1 3.37384 3.42 1 6.5 1C8.24 1 9.91 1.79455 11 3.05014C12.09 1.79455 13.76 1 15.5 1C18.58 1 21 3.37384 21 6.3951C21 10.103 17.6 13.1243 12.45 17.715L11 19Z" stroke="currentColor"/>
                    </svg>
                </a>
                @guest
                    <a href="{{url('login')}}" class="btn btn-dark text-color font-weihgt ee-login">Login</a>
                @endguest
                @auth
                    <a href="{{url('my-account')}}" class="btn btn-dark text-color font-weihgt ee-login">Account</a>
                @endauth
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0 gty align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle font-weihgt" href="#" id="buyDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Buy
                    </a>
                    <ul class="dropdown-menu shadow-sm border-0" aria-labelledby="buyDropdown">
                        <li><a class="dropdown-item py-2" href="{{url('/listing/ready')}}"><i class="fa-solid fa-key me-2" style="color:#bb9e5b"></i> Ready Properties</a></li>
                        <li><a class="dropdown-item py-2" href="{{url('/listing/off-plan')}}"><i class="fa-solid fa-compass-drafting me-2" style="color:#bb9e5b"></i> Off-Plan Projects</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2" href="{{url('/listing/sale')}}">All Properties for Sale</a></li>
                    </ul>
                </li>

                @if(config('features.luxury_rentals'))
                <li class="nav-item">
                    <a class="nav-link font-weihgt" href="{{url('/luxury-rentals')}}">Luxury Rentals</a>
                </li>
                @endif

                <li class="nav-item ee-mega">
                    <a class="nav-link font-weihgt" href="{{ url('areas') }}">Areas</a>
                    <button class="ee-mega-toggle" type="button" aria-label="Show areas menu"><i class="fa-solid fa-chevron-down"></i></button>
                    <div class="ee-mega-panel">
                        <div class="container-fluid">
                            <div class="row g-4">
                                <div class="col-lg-5">
                                    <p class="ee-mega-label"><a href="{{ url('areas') }}">Areas <i class="fa-solid fa-angle-right"></i></a></p>
                                    <div class="row">
                                        <div class="col-6">
                                            @foreach(array_slice($areaGroups, 0, 2) as $group)
                                                <p class="ee-mega-label">{{ $group['label'] }}</p>
                                                <ul class="ee-mega-links">
                                                    @foreach($group['places'] as $placeSlug)
                                                        @if(isset($areaPlaces[$placeSlug]))
                                                            <li><a href="{{ \App\Support\MarketGuide::placeUrl($areaPlaces[$placeSlug]) }}">{{ $areaPlaces[$placeSlug]['name'] }}</a></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            @endforeach
                                        </div>
                                        <div class="col-6">
                                            @foreach(array_slice($areaGroups, 2) as $group)
                                                <p class="ee-mega-label">{{ $group['label'] }}</p>
                                                <ul class="ee-mega-links">
                                                    @foreach($group['places'] as $placeSlug)
                                                        @if(isset($areaPlaces[$placeSlug]))
                                                            <li><a href="{{ \App\Support\MarketGuide::placeUrl($areaPlaces[$placeSlug]) }}">{{ $areaPlaces[$placeSlug]['name'] }}</a></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    @if($trendingArea)
                                        <a class="ee-mega-card" href="{{ \App\Support\MarketGuide::placeUrl($trendingArea) }}">
                                            <img src="{{ asset('frontend/img/banner_update.jpg') }}" alt="{{ $trendingArea['name'] }}">
                                            <span>Trending Areas</span>
                                            <strong>{{ $trendingArea['name'] }} <i class="fa-solid fa-angle-right"></i></strong>
                                        </a>
                                    @endif
                                </div>
                                <div class="col-lg-4 ee-mega-side">
                                    <h3>Other Locations</h3>
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="ee-mega-label">Other Emirates</p>
                                            <ul class="ee-mega-links">
                                                @foreach(array_slice(\App\Support\MarketGuide::otherEmirates(), 0, 4) as $emirate)
                                                    <li><a href="{{ \App\Support\MarketGuide::marketUrl($emirate['slug']) }}">{{ $emirate['name'] }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="col-6">
                                            <p class="ee-mega-label">International</p>
                                            <ul class="ee-mega-links">
                                                @foreach(\App\Support\MarketGuide::international() as $market)
                                                    <li><a href="{{ \App\Support\MarketGuide::marketUrl($market['slug']) }}">{{ $market['name'] }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item ee-mega">
                    <a class="nav-link font-weihgt" href="{{ url('developers') }}">Developers</a>
                    <button class="ee-mega-toggle" type="button" aria-label="Show developers menu"><i class="fa-solid fa-chevron-down"></i></button>
                    <div class="ee-mega-panel">
                        <div class="container-fluid">
                            <div class="row g-4">
                                <div class="col-lg-7">
                                    <p class="ee-mega-label"><a href="{{ url('developers') }}">All developers <i class="fa-solid fa-angle-right"></i></a></p>
                                    <div class="row">
                                        @foreach($developers->take(12)->chunk(6) as $column)
                                            <div class="col-6">
                                                <ul class="ee-mega-links">
                                                    @foreach($column as $developer)
                                                        <li><a href="{{ url('developer/'.$developer->slug) }}">{{ $developer->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="row g-3">
                                        @foreach($developers->take(2) as $developer)
                                            <div class="col-6">
                                                <a class="ee-mega-card" href="{{ url('developer/'.$developer->slug) }}">
                                                    <img src="{{ $developer->cover ? asset('images/media/developers/'.$developer->cover) : asset('frontend/img/sell_with_us.jpeg') }}" alt="{{ $developer->name }}">
                                                    <span>Developer</span>
                                                    <strong>{{ $developer->name }}</strong>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link font-weihgt" href="{{url('/agents')}}">Brokers & Agents</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .dropdown-content.developers-dropdown {
        width: 300px !important;
    }
    .sublist a{
        padding-left: 40px !important;
        padding-block: 5px;
    }
</style>

<script>
    var selectElement = document.getElementById("mySelect");

    selectElement.addEventListener("change", function() {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var href = selectedOption.value;

        if (href) {
            window.location.href = href;
        }
    });

    var megaCloseTimer = null;
    var megaDesktop = window.matchMedia('(min-width: 992px)');
    var siteNav = document.querySelector('.nav-banner');

    document.querySelectorAll('.ee-mega').forEach(function (item) {
        item.addEventListener('mouseenter', function () {
            if (!megaDesktop.matches) return;
            clearTimeout(megaCloseTimer);
            document.querySelectorAll('.ee-mega.is-open').forEach(function (other) {
                if (other !== item) other.classList.remove('is-open');
            });
            item.classList.add('is-open');
            if (siteNav) siteNav.classList.add('menu-open');
        });
        item.addEventListener('mouseleave', function () {
            if (!megaDesktop.matches) return;
            clearTimeout(megaCloseTimer);
            megaCloseTimer = setTimeout(function () {
                item.classList.remove('is-open');
                if (!document.querySelector('.ee-mega:hover') && siteNav && !siteNav.classList.contains('nav-mobile-open')) {
                    siteNav.classList.remove('menu-open');
                }
            }, 220);
        });
    });

    document.querySelectorAll('.ee-mega-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            var item = button.closest('.ee-mega');
            var open = item.classList.contains('is-open');
            clearTimeout(megaCloseTimer);
            document.querySelectorAll('.ee-mega.is-open').forEach(function (other) {
                other.classList.remove('is-open');
            });
            if (!open) {
                item.classList.add('is-open');
                if (siteNav) siteNav.classList.add('menu-open');
            } else if (siteNav && !siteNav.classList.contains('nav-mobile-open')) {
                siteNav.classList.remove('menu-open');
            }
        });
    });

    var siteMenu = document.getElementById('navbarSupportedContent');
    if (siteNav && siteMenu) {
        siteMenu.addEventListener('show.bs.collapse', function () {
            siteNav.classList.add('menu-open', 'nav-mobile-open');
        });
        siteMenu.addEventListener('hide.bs.collapse', function () {
            siteNav.classList.remove('nav-mobile-open');
            if (!document.querySelector('.ee-mega.is-open')) {
                siteNav.classList.remove('menu-open');
            }
        });
    }
</script>
