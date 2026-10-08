@extends('frontend.layouts.master')
@section('title')
    Elite Evolution Real Estate Blog | Expert Insights & Property Tips
@endsection

@section('meta_title')
    Elite Evolution Real Estate Blog | Expert Insights & Property Tips
@endsection

@section('meta_description')
    Discover the latest trends, expert insights, and valuable tips on real estate. Stay informed with Elite Evolution's blog for all your property needs.
@endsection

@section('content')
    <style>
        .blogs img {
            height: 200px;
            object-fit: cover;
        }
    </style>
    <section>
        <div class="">
            <img src="{{asset('frontend/img/blog.png')}}" class="w-100 mrj" alt="">
        </div>
    </section>
    <section>
        <div class="container px-md-5 py-md-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row row-cols-1 row-cols-md-2 g-4 py-md-0 py-3">

                        @foreach($blogs as $blog)

                            <div class="col-lg-4 col-12 blogs my-4">
                                <div class="">
                                    <img src="{{asset('images/media/'.'/'.$blog->image)}}" style="border-radius: 20px;" class="w-100" alt="...">
                                    <div class="card-body px-0">
                                        <h5 class="card-title fw-bold fs-18 text-uppercase">   {{$blog->title}}</h5>
                                        <div class="short-decs">
                                        <p class="card-text">
                                            {!!$blog->short_description!!}
                                        </p>
                                        </div>
                                        <a href="{{url('blog/'.$blog->slug)}}" class="button">READ MORE</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
{{--                <div class="col-lg-4">--}}
{{--                    <div class="border p-2">--}}
{{--                        <h1 class="text-center py-md-3 fw-bold">LATEST POSTS</h1>--}}
{{--                        <!-- <div class="row">--}}
{{--                            <div class="col-lg-6">--}}

{{--                            </div>--}}
{{--                            <div class="col-lg-6"></div>--}}
{{--                        </div> -->--}}
{{--                        <div class=" mb-3" style="max-width: 540px;">--}}
{{--                            <div class="row g-0">--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <img src="{{asset('management/images/reg1.png')}}" class="w-100" alt="...">--}}
{{--                                </div>--}}
{{--                                <div class="col-md-8">--}}
{{--                                    <div class="card-body">--}}
{{--                                        <h5 class="card-title fw-bold fs-15">MODERN APARTMENT ADJACENT</h5>--}}
{{--                                        <p style="color:#707070;" class="card-text fw-bold">April 2023</p>--}}
{{--                                        <a href="#" class="button">READ MORE</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <hr>--}}
{{--                        <div class="mb-3" style="max-width: 540px;">--}}
{{--                            <div class="row g-0">--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <img src="{{asset('management/images/reg1.png')}}" class="w-100" alt="...">--}}
{{--                                </div>--}}
{{--                                <div class="col-md-8">--}}
{{--                                    <div class="card-body">--}}
{{--                                        <h5 class="card-title fw-bold fs-15">MODERN APARTMENT ADJACENT</h5>--}}
{{--                                        <p style="color:#707070;" class="card-text fw-bold">April 2023</p>--}}
{{--                                        <a href="#" class="button">READ MORE</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <hr>--}}
{{--                        <div class="mb-3" style="max-width: 540px;">--}}
{{--                            <div class="row g-0">--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <img src="{{asset('management/images/reg1.png')}}" class="w-100" alt="...">--}}
{{--                                </div>--}}
{{--                                <div class="col-md-8">--}}
{{--                                    <div class="card-body">--}}
{{--                                        <h5 class="card-title fw-bold fs-15">MODERN APARTMENT ADJACENT</h5>--}}
{{--                                        <p style="color:#707070;" class="card-text fw-bold">April 2023</p>--}}
{{--                                        <a href="#" class="button">READ MORE</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <hr>--}}
{{--                        <div class="mb-3" style="max-width: 540px;">--}}
{{--                            <div class="row g-0">--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <img src="{{asset('management/images/reg1.png')}}" class="w-100" alt="...">--}}
{{--                                </div>--}}
{{--                                <div class="col-md-8">--}}
{{--                                    <div class="card-body">--}}
{{--                                        <h5 class="card-title fw-bold fs-15">MODERN APARTMENT ADJACENT</h5>--}}
{{--                                        <p style="color:#707070;" class="card-text fw-bold">April 2023</p>--}}
{{--                                        <a href="#" class="button">READ MORE</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <hr>--}}
{{--                        <div class="mb-3" style="max-width: 540px;">--}}
{{--                            <div class="row g-0">--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <img src="{{asset('management/images/reg1.png')}}" class="w-100" alt="...">--}}
{{--                                </div>--}}
{{--                                <div class="col-md-8">--}}
{{--                                    <div class="card-body">--}}
{{--                                        <h5 class="card-title fw-bold fs-15">MODERN APARTMENT ADJACENT</h5>--}}
{{--                                        <p style="color:#707070;" class="card-text fw-bold">April 2023</p>--}}
{{--                                        <a href="#" class="button">READ MORE</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}
            </div>
        </div>
    </section>
{{--    <section class="banner-image">--}}
{{--        <div class="container ">--}}
{{--            <div class="row">--}}
{{--                <div class="col-lg-3 col-sm-12 col-md-6">--}}
{{--                    <div class="">--}}

{{--                        <div class="card-body">--}}
{{--                            <h5 class="card-title fw-bold fs-15">POPULAR SEARCHES</h5>--}}
{{--                            <p class="card-text">--}}
{{--                                <a href="" class="text-black text-decoration-none">Properties for rent in UAE</a>--}}
{{--                                <a href="" class="text-black text-decoration-none">Properties for sale in UAE</a>--}}
{{--                                <a href="" class="text-black text-decoration-none"> Apartments for sale in UAE </a>--}}
{{--                                <a href="" class="text-black text-decoration-none">Apartments for sale Dubai</a>--}}
{{--                                <a href="" class="text-black text-decoration-none">Properties for sale in Dubai</a>--}}
{{--                                <a href="" class="text-black text-decoration-none">Villas for sale in Dubai</a>--}}
{{--                            </p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-sm-12 col-md-6">--}}
{{--                    <div class="h-100">--}}
{{--                        <div class="card-body">--}}
{{--                            <h5 class="card-title fw-bold fs-15">POPULAR AREAS</h5>--}}
{{--                            <p class="card-text">--}}
{{--                                <a href="" class="text-black text-decoration-none">Properties for rent in UAE</a>--}}
{{--                                <a href="" class="text-black text-decoration-none">Properties for sale in UAE</a>--}}
{{--                                <a href="" class="text-black text-decoration-none"> Apartments for sale in UAE </a>--}}
{{--                                <a href="" class="text-black text-decoration-none">Apartments for sale Dubai</a>--}}
{{--                                <a href="" class="text-black text-decoration-none">Properties for sale in Dubai</a>--}}
{{--                                <a href="" class="text-black text-decoration-none">Villas for sale in Dubai</a>--}}
{{--                            </p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-sm-12 col-md-6">--}}
{{--                    <div class="h-100">--}}
{{--                        <div class="card-body">--}}
{{--                            <h5 class="card-title fw-bold fs-15">TRENDING AREAS</h5>--}}
{{--                            <p class="card-text">--}}
{{--                                <a href="" class="text-black text-decoration-none">Properties for rent in UAE</a>--}}
{{--                                <a href="" class="text-black text-decoration-none">Properties for sale in UAE</a>--}}
{{--                                <a href="" class="text-black text-decoration-none"> Apartments for sale in UAE </a>--}}
{{--                                <a href="" class="text-black text-decoration-none">Apartments for sale Dubai</a>--}}
{{--                                <a href="" class="text-black text-decoration-none">Properties for sale in Dubai</a>--}}
{{--                                <a href="" class="text-black text-decoration-none">Villas for sale in Dubai</a>--}}
{{--                            </p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 col-sm-12 col-md-6">--}}
{{--                    <div class="h-100">--}}
{{--                        <div class="card-body">--}}
{{--                            <h5 class="card-title fw-bold fs-15">TRENDING SEARCHES</h5>--}}
{{--                            <p class="card-text">--}}
{{--                                <a href="" class="text-black text-decoration-none">Properties for rent in UAE</a>--}}
{{--                                <a href="" class="text-black text-decoration-none">Properties for sale in UAE</a>--}}
{{--                                <a href="" class="text-black text-decoration-none"> Apartments for sale in UAE </a>--}}
{{--                                <a href="" class="text-black text-decoration-none">Apartments for sale Dubai</a>--}}
{{--                                <a href="" class="text-black text-decoration-none">Properties for sale in Dubai</a>--}}
{{--                                <a href="" class="text-black text-decoration-none">Villas for sale in Dubai</a>--}}
{{--                            </p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
@endsection
