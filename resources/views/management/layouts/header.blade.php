
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from www.radixtouch.in/templates/admin/lorax/source/light/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 17 Jun 2021 10:52:06 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
{{--    <title>@yield('title')</title>--}}
    <!-- Favicon-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <link rel="icon" href="{{asset('favicon.png')}}"
          type="image/x-icon">
    <!-- Plugins Core Css -->
    <link href="{{asset('management/js/bundles/multiselect/css/multi-select.css')}}" rel="stylesheet" />

    <link href="{{asset('management/css/app.min.css')}}" rel="stylesheet">
    <!-- Custom Css -->
    <!-- Theme style. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{asset('management/css/styles/all-themes.css')}}" rel="stylesheet" />
    <link href="{{asset('management/css/style.css')}}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Konkhmer+Sleokchher&family=Lalezar&family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="{{asset('management/css/form.min.css')}}" rel="stylesheet" />
{{--    <link href="{{asset('management/css/custom.css')}}" rel="stylesheet" />--}}
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://kit.fontawesome.com/a96422e881.js" crossorigin="anonymous"></script>
    {{--    <link rel="stylesheet" href="{{asset('css/app.css')}}">--}}
{{--    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">--}}
{{--    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>--}}
{{--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <link rel="stylesheet"  href="//cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
    <link href="{{asset('management/css/custom.css')}}" rel="stylesheet" />
{{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>--}}
    <title>@yield('title') - {{config('app.name')}}</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">

</head>
<style>
    .fw-900{
        font-weight: 900 !important;
    }
    .text-signature {
        color: #E8BC50;
    }
    .bg-signature {
        background: #E8BC50;
    }


</style>
<body class="light">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30">
            <img class="loading-img-spin" src="{{asset('management/images/preloading.png')}}" width="20" height="20" alt="admin">
        </div>
        <p>Please wait...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="#" onClick="return false;" class="navbar-toggle collapsed" data-toggle="collapse"
               data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="#" onClick="return false;" class="bars"></a>
            <a class="navbar-brand" href="/">
                <img height="35px" src="{{asset('management/images/logo.png')}}" alt="{{config('app.dashboard')}}" />
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="pull-left px-5 text-dark">
{{--                <li>--}}
{{--                    <a href="#" onClick="return false;" class="sidemenu-collapse">--}}
{{--                        <i class="fas fa-align-justify"></i>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li class="text-dark">
                    <a href="{{url('admin/dashboard')}}" >
                        Dashboard
                    </a>
                </li>
                <li class="text-dark">
                    <a href="{{route('property.index')}}" class="px-3">
                        Property
                    </a>
                </li>
                <li class="text-dark">
                    <a href="{{route('lead.index')}}" >
                        Lead
                    </a>
                </li>
                <li class="text-dark">
                    <a href="{{route('developer.index')}}" >
                        Developers
                    </a>
                </li>

            </ul>


{{--            <ul class="navbar-nav mr-auto">--}}
{{--                <li class="nav-item active">--}}
{{--                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" href="#">Link</a>--}}
{{--                </li>--}}
{{--                <li class="nav-item dropdown">--}}
{{--                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                        Dropdown--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
{{--                        <a class="dropdown-item" href="#">Action</a>--}}
{{--                        <a class="dropdown-item" href="#">Another action</a>--}}
{{--                        <div class="dropdown-divider"></div>--}}
{{--                        <a class="dropdown-item" href="#">Something else here</a>--}}
{{--                    </div>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link disabled" href="#">Disabled</a>--}}
{{--                </li>--}}
{{--            </ul>--}}

            <ul class="nav navbar-nav navbar-right">
                <!-- Full Screen Button -->
                <li class="fullscreen">
                    <a href="javascript:;" class="fullscreen-btn">
                        <i class="fas fa-expand"></i>
                    </a>
                </li>
                <!-- #END# Full Screen Button -->
                <!-- #START# Notifications-->
{{--                @include('Notifications/index');--}}



                <!-- #END# Notifications-->
                <li class="dropdown user_profile">
                    <a href="#" onClick="return false;" class="dropdown-toggle" data-toggle="dropdown"
                       role="button">
                        <img src="{{asset('management/images/user.jpg')}}" width="32" height="32" alt="{{config('app.dashboard')}} | User">
                    </a>
                    <ul class="dropdown-menu pullDown">
                        <li class="body">
                            <ul class="user_dw_menu">
                                <li>
                                    <a href="#" onClick="return false;">
                                        <i class="fas fa-user"></i>Profile
                                    </a>
                                </li>
                                <li>
                                    <form class="m-0" method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="#"  :href="route('logout')"
                                           onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                            <i class="material-icons"></i> {{ __('Log Out') }}
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>
                <!-- #END# Tasks -->
{{--                <li class="pull-right">--}}
{{--                    <a href="#" onClick="return false;" class="js-right-sidebar" data-close="true">--}}
{{--                        <i class="fas fa-cog"></i>--}}
{{--                    </a>--}}
{{--                </li>--}}
            </ul>
        </div>
    </div>
</nav>
