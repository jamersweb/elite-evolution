@extends('frontend.layouts.master')

@section('title')
    {{$blogs->meta_title}}
@endsection

@section('meta_title')
    {{$blogs->meta_title}}
@endsection

@section('meta_description')
    {{$blogs->meta_description}}
@endsection

@section('content')
    <style>
        .long_description img{
            width:100% !important;
            height:auto !important;
        }
        .long_description h1, .long_description h2, .long_description h3{
            text-transform:uppercase !important;
        }
    </style>
    <section>
        <div class="">
            <img src="{{asset('frontend/img/blog.png')}}" class="w-100" alt="">
        </div>
    </section>
    <section>
        <div class="container py-md-5 py-3">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row row-cols-1 row-cols-md-1 g-4">
                        <div class="col">
                            <div class="">
                                <img src="{{asset('images/media/'.'/'.$blogs->image)}}" class="w-100" style="border-radius: 20px;" alt="...">
                                    <h3 class="my-3 fw-bold text-uppercase">{{$blogs->title}}</h3>
                                    <p style="color:#707070;" class=" fw-bold text-uppercase">{{$newDate = date("M Y", strtotime($blogs->created_at))}}</p>
                                    <div class="long_description">
                                        {!!$blogs->long_description!!}
                                    </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-lg-4">
                    <div class="border p-2">
                        <h3 class="py-md-3 fw-bold">LATEST POSTS</h3>
                        <!-- <div class="row">
                        <div class="col-lg-6">

                        </div>
                        <div class="col-lg-6"></div>
                    </div> -->
                        @foreach($latest_blogs as $latest)
                        <div class=" mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{asset('images/media/'.'/'.$latest->image)}}" class="card-img-top pro" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold fs-10 text-uppercase">{{$latest->title}}</h5>
                                        <p style="color:#707070;" class="card-text fs-10 fw-bold m-0">{{date("M Y", strtotime($latest->created_at))}}</p>
                                        <a href="{{url('blog/'.$latest->slug)}}" class="button-reed">READ MORE</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="banner-image" style="background: #F5F5F5">
        <div class="container px-md-5 py-md-5">
            <div class="row">
                <div class="col-lg-3 col-sm-12 col-md-6">
                    <div class="h-100">

                        <div class="card-body">
                            <h5 class="card-title fw-bold fs-15">POPULAR SEARCHES</h5>
                            <p class="card-text">Properties for rent in UAE
                                Properties for sale in UAE Apartments for sale in UAE Apartments for sale Dubai
                                Properties for sale in Dubai Villas for sale in Dubai</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12 col-md-6">
                    <div class="h-100">
                        <div class="card-body">
                            <h5 class="card-title fw-bold fs-15">POPULAR AREAS</h5>
                            <p class="card-text">Properties for rent in UAE
                                Properties for sale in UAE Apartments for sale in UAE Apartments for sale Dubai
                                Properties for sale in Dubai Villas for sale in Dubai</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12 col-md-6">
                    <div class="h-100">
                        <div class="card-body">
                            <h5 class="card-title fw-bold fs-15">TRENDING AREAS</h5>
                            <p class="card-text">Properties for rent in UAE
                                Properties for sale in UAE Apartments for sale in UAE Apartments for sale Dubai
                                Properties for sale in Dubai Villas for sale in Dubai</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12 col-md-6">
                    <div class="h-100">
                        <div class="card-body">
                            <h5 class="card-title fw-bold fs-15">TRENDING SEARCHES</h5>
                            <p class="card-text">Properties for rent in UAE
                                Properties for sale in UAE Apartments for sale in UAE Apartments for sale Dubai
                                Properties for sale in Dubai Villas for sale in Dubai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
