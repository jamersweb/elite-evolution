@extends('frontend.layouts.master')
@section('title')
    Thank You
@endsection
@section('content')
    <style>
        .blogs img {
            height: 200px;
            object-fit: cover;
        }
        .hero-banner{
            height:60vh;
            background-position: center;
            background-size: cover !important;
            background-repeat: no-repeat !important;
            position: relative;
        }
        .hero-banner:before {
            content: "";
            background: rgba(0,0,0,.4);
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
        }
        .hero-banner  div{
            z-index: 99;
        }
        .hbspt-form {
            display: none ;
        }
        .banner-footer{border-top:0;margin-top:20px}

    </style>
    {{--    <section class="container-fluid hero-banner" style="background: url({{asset('frontend/img/blog.png')}});">--}}
    {{--        <div class="row align-items-center h-100">--}}
    {{--            <div class="col-12">--}}
    {{--                <h1 class="text-center text-uppercase text-white">Appraise Your Property with Elite Evolution</h1>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}
    <section style="min-height: calc(100vh - 445px);">
        <div class="container px-md-5 py-md-5">
            <div class="row py-md-5">
                <div class="col-lg-9 mx-auto">



                    <h1 class="mb-4 text-success h2 pt-5">Thank you for contacting us! We will get back to you shortly.</h1>
                   


                </div>

            </div>
        </div>
    </section>
@endsection
