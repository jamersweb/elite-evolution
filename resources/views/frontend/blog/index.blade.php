@extends('frontend.layouts.master')
@section('title')
    blog - Admin Control Panel
@endsection
@section('content')

<section>
    <div class="">
        <img src="{{asset('management/images/blog.png')}}" class="w-100" alt="...">
    </div>
</section>
<section>
    <div class="container px-md-5 py-md-5 py-3">
        <h1 class="text-center fw-bold pb-md-5">THE BLOGS</h1>
        <div class="row">
            <div class="col-lg-8">
                <div class="row row-cols-1 row-cols-md-1 g-4">
                    <div class="col">
                        <div class="">
                            <img src="{{asset('management/images/reg1.png')}}" class="post-img" alt="...">
                            <div class="card-body">
                                <h5 class="card-title fw-bold fs-15">MODERN APARTMENT ADJACENT</h5>
                                <p style="color:#707070;" class="card-text fw-bold">April 2023</p>
                                <p>Massa tempor nec feugiat nisl pretium. Egestas fringilla phasellus faucibus scelerisque eleifend donec. Porta nibh venenatis cras sed felis eget velit aliquet. Neque volutpat ac tincidunt vitae semper quis lectus. Turpis in eu mi bibendum neque egestas congue quisque. Sed elementum tempus egestas sed…
                                </p>
                                <a href="#" class="button">READ MORE</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div class="col pb-md-3">
                        <div class="">
                            <img src="{{asset('management/images/reg1.png')}}" class="" alt="...">

                        </div>
                    </div>
                    <div class="col pb-md-3">
                        <div class="">
                            <img src="{{asset('management/images/reg2.png')}}" class="w-100" alt="...">

                        </div>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-md-1 g-4 py-md-0 py-3">
                    <div class="col">
                        <div class="">
                            <img src="{{asset('management/images/reg1.png')}}" class="post-img" alt="...">
                            <div class="card-body">
                                <h5 class="card-title fw-bold fs-15">HOUSING MARKETS THAT CHANGED THE MOST THIS DECADE</h5>
                                <p class="card-text">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laboruLorem ipsum dolor sit amet datat non proident, sunt in culpa qui officia deserunt mollit anim id est laboruore Duis autem vel eum iriure dolor in hendvelit esse molestie consequat, est usus legentis vel illum dolore eu feugiat nulla…
                                </p>
                                <a href="#" class="button">READ MORE</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div class="col pt-md-3">
                        <div class="">
                            <img src="{{asset('management/images/reg1.png')}}" class="w-100" alt="...">

                        </div>
                    </div>
                    <div class="col pt-md-3">
                        <div class="">
                            <img src="{{asset('management/images/reg2.png')}}" class="w-100" alt="...">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="border p-2">
                    <h1 class="text-center py-md-3 fw-bold">LATEST POSTS</h1>
                    <!-- <div class="row">
                    <div class="col-lg-6">

                    </div>
                    <div class="col-lg-6"></div>
                </div> -->
                    <div class=" mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{asset('management/images/reg1.png')}}" class="w-100" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold fs-15">MODERN APARTMENT ADJACENT</h5>
                                    <p style="color:#707070;" class="card-text fw-bold">April 2023</p>
                                    <a href="#" class="button">READ MORE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{asset('management/images/reg1.png')}}" class="w-100" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold fs-15">MODERN APARTMENT ADJACENT</h5>
                                    <p style="color:#707070;" class="card-text fw-bold">April 2023</p>
                                    <a href="#" class="button">READ MORE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{asset('management/images/reg1.png')}}" class="w-100" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold fs-15">MODERN APARTMENT ADJACENT</h5>
                                    <p style="color:#707070;" class="card-text fw-bold">April 2023</p>
                                    <a href="#" class="button">READ MORE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{asset('management/images/reg1.png')}}" class="w-100" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold fs-15">MODERN APARTMENT ADJACENT</h5>
                                    <p style="color:#707070;" class="card-text fw-bold">April 2023</p>
                                    <a href="#" class="button">READ MORE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{asset('management/images/reg1.png')}}" class="w-100" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold fs-15">MODERN APARTMENT ADJACENT</h5>
                                    <p style="color:#707070;" class="card-text fw-bold">April 2023</p>
                                    <a href="#" class="button">READ MORE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<section class="banner-image">
    <div class="container py-md-5">
        <div class="row">
            <div class="col-lg-3 col-sm-12 col-md-6">
                <div class="">

                    <div class="card-body">
                        <h5 class="card-title fw-bold fs-15">POPULAR SEARCHES</h5>
                        <p class="card-text">
                            <a href="" class="text-black text-decoration-none">Properties for rent in UAE</a>
                            <a href="" class="text-black text-decoration-none">Properties for sale in UAE</a>
                            <a href="" class="text-black text-decoration-none"> Apartments for sale in UAE </a>
                            <a href="" class="text-black text-decoration-none">Apartments for sale Dubai</a>
                            <a href="" class="text-black text-decoration-none">Properties for sale in Dubai</a>
                            <a href="" class="text-black text-decoration-none">Villas for sale in Dubai</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12 col-md-6">
                <div class="h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold fs-15">POPULAR AREAS</h5>
                        <p class="card-text">
                            <a href="" class="text-black text-decoration-none">Properties for rent in UAE</a>
                            <a href="" class="text-black text-decoration-none">Properties for sale in UAE</a>
                            <a href="" class="text-black text-decoration-none"> Apartments for sale in UAE </a>
                            <a href="" class="text-black text-decoration-none">Apartments for sale Dubai</a>
                            <a href="" class="text-black text-decoration-none">Properties for sale in Dubai</a>
                            <a href="" class="text-black text-decoration-none">Villas for sale in Dubai</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12 col-md-6">
                <div class="h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold fs-15">TRENDING AREAS</h5>
                        <p class="card-text">
                            <a href="" class="text-black text-decoration-none">Properties for rent in UAE</a>
                            <a href="" class="text-black text-decoration-none">Properties for sale in UAE</a>
                            <a href="" class="text-black text-decoration-none"> Apartments for sale in UAE </a>
                            <a href="" class="text-black text-decoration-none">Apartments for sale Dubai</a>
                            <a href="" class="text-black text-decoration-none">Properties for sale in Dubai</a>
                            <a href="" class="text-black text-decoration-none">Villas for sale in Dubai</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12 col-md-6">
                <div class="h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-bold fs-15">TRENDING SEARCHES</h5>
                        <p class="card-text">
                            <a href="" class="text-black text-decoration-none">Properties for rent in UAE</a>
                            <a href="" class="text-black text-decoration-none">Properties for sale in UAE</a>
                            <a href="" class="text-black text-decoration-none"> Apartments for sale in UAE </a>
                            <a href="" class="text-black text-decoration-none">Apartments for sale Dubai</a>
                            <a href="" class="text-black text-decoration-none">Properties for sale in Dubai</a>
                            <a href="" class="text-black text-decoration-none">Villas for sale in Dubai</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection