@extends('frontend.layouts.master')

@section('title')
Real Estate Careers at Elite Evolution | Join Our Dynamic Team
@endsection

@section('meta_title')
Real Estate Careers at Elite Evolution | Join Our Dynamic Team
@endsection

@section('meta_description')
Explore exciting career opportunities in real estate with Elite Evolution. Join our dynamic team and embark on a rewarding journey in the property industry.
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
    </style>
    <section class="container-fluid hero-banner" style="background: url({{asset('frontend/img/blog.png')}});">
        <div class="row align-items-center h-100">
            <div class="col-12">
                <h1 class="text-center text-uppercase text-white">Join Elite Evolution Real Estate's Dynamic Team</h1>
            </div>
        </div>
    </section>
    <section>
        <div class="container px-md-5 py-md-5">
            <div class="row py-md-5">
                <div class="col-lg-8 mx-auto">
                    @include('management/layouts/error')
                    <form id="your-form-id" action="{{ url('career-submit') }}" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <h2 class="text-uppercase text-center">Career Application Form</h2>
                            </div>
                            <div class="col-md-12">
                                @csrf
                                <input type="text" class="form-control" name="name" placeholder="Full Name" aria-label="First name" required>
                            </div>
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" placeholder="Email" aria-label="Email" required>
                            </div>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="phone" placeholder="Phone number" aria-label="Phone number" required>
                            </div>
                            <div class="col-md-12">
                                <input type="file" class="form-control" name="resume" placeholder="Phone number" aria-label="Phone number" required>
                            </div>
                            <div class="col-md-12">
                                <textarea class="form-control" name="cover" placeholder="Cover Letter" aria-label="Last name" required></textarea>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-block w-100 btn-dark rounded-pill text-uppercase " onclick="submitForm()"> Submit Detail</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
