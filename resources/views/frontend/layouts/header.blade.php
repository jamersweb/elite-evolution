<!doctype html>
<html lang="en">
@php
    $developers = \App\Models\Developer::whereStatus(1)->get();
@endphp
<head>
    <script>
        (function () {
            try {
                if (localStorage.getItem('ee_intro_seen_v1') === '1') {
                    document.documentElement.classList.add('ee-intro-seen');
                } else {
                    document.documentElement.classList.add('ee-intro-open');
                }
            } catch (e) {
                document.documentElement.classList.add('ee-intro-open');
            }
        })();
    </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WCRWXKLS');</script>
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <meta name=“google-site-verification” content=“We0bNagz3k_JCxoOFYXLNUqLegkh4EhTLHrfGpSFlW8" />
    <style type="text/css">
        .hs-form__virality-link{display: none !important;}
    </style>
</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WCRWXKLS"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<nav class="navbar navbar-expand-lg navbar-light bg-white px-md-5 nav-banner">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{url('/')}}">
            <img class="elit-img" src="{{asset('management/images/elite-evolution-real-estate-in-black.png')}}" onerror="this.onerror=null;this.src='{{asset('management/images/logo.png')}}';" alt="Elite Evolution Real Estate">
            <span class="visually-hidden">Elite Evolution Real Estate</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto mb-2 mb-lg-0 gty align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle font-weihgt text-dark" href="#" id="buyDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Buy
                    </a>
                    <ul class="dropdown-menu shadow-sm border-0" aria-labelledby="buyDropdown">
                        <li><a class="dropdown-item py-2" href="{{url('/listing/ready')}}"><i class="fa-solid fa-key me-2 text-warning"></i> Ready Properties</a></li>
                        <li><a class="dropdown-item py-2" href="{{url('/listing/off-plan')}}"><i class="fa-solid fa-compass-drafting me-2 text-warning"></i> Off-Plan Projects</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2" href="{{url('/listing/sale')}}">All Properties for Sale</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link font-weihgt text-dark" href="{{url('/luxury-rentals')}}">Luxury Rentals</a>
                </li>

                <li class="nav-item">
                    <a class="dropbtn dropdown nav-link font-weihgt text-dark">Developers <i class="fa-solid fa-angle-down"></i></a>
                    <div class="dropdown-content developers-dropdown">
                        @foreach($developers as $developer)
                            <a class="fw-bold" href="{{url('/developer',$developer->slug)}}">{{$developer->name}} </a>
                            <div class="sublist">
                                @if($developer->property != null)
                                    @foreach($developer->property as $properties)
                                    @if($properties->id != 43)
                                        <a href="{{url('/developer',$developer->slug).'/'.$properties->slug}}">{{$properties->title}}</a>
                                    @endif
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link font-weihgt text-dark" href="{{url('/agents')}}">Brokers & Agents</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link font-weihgt text-dark" href="{{url('/map-view')}}"><i class="fa-solid fa-map-location-dot me-1 text-warning"></i> Map Search</a>
                </li>

                {{-- Insights/blog nav hidden until current content is ready --}}
            </ul>
            <form class="d-flex justify-content-center align-items-center m-0">
                <select class="form-select font-weihgt" id="mySelect" aria-label="Default select example">
                    <option {{session('country') ==  'uae' ? 'selected' : ''}} value="{{url('/country/uae')}}">UAE</option>
                    <option {{session('country') ==  'uk' ? 'selected' : ''}}  value="{{url('/country/uk')}}">UK</option>
                </select>
                <div class="px-3 text-color">
                    <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 19L9.55 17.7052C4.4 13.1243 1 10.103 1 6.3951C1 3.37384 3.42 1 6.5 1C8.24 1 9.91 1.79455 11 3.05014C12.09 1.79455 13.76 1 15.5 1C18.58 1 21 3.37384 21 6.3951C21 10.103 17.6 13.1243 12.45 17.715L11 19Z" stroke="black"/>
                    </svg>
                </div>
                @guest
                    <a href="{{url('login')}}" class="btn btn-dark text-color font-weihgt">Login</a>
                @endguest
                @auth
                    <a href="{{url('my-account')}}" class="btn btn-dark text-color font-weihgt" >Account</a>
                @endauth
            </form>
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
</script>
