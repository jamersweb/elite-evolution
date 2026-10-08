@extends('frontend.layouts.master')
@section('title')
    House_price - Admin Control Panel
@endsection
@section('content')
    <div style="background-color:#F5F5F5;" class="">
        <section class="banner position-relative"  style=" background-image: url('{{asset('management/images/banner.png')}}');">
            <div class="d-flex align-items-center justify-content-center">
                <div class="fn px-md-5 py-md-4 bg-white px-3 py-3">
                    <h1 class="text-color font-weihgt text-center">HOUSE PRICE</h1>
                    <p style="color:#707070;" class="text-center font-weihgt fs-size">See house values in different communities and compare asking<br> prices, actual transaction prices and rental yields.<br> DUBAI</p>
                </div>
            </div>
            <div class="wfr mx-md-5">
                <form action="">
                    <div class="row m-0 g-3 needs-validation" novalidate>

                        <div class="col-md-10 px-md-3">

                            <label for="validationCustom03" class="form-label">Search</label>
                            <div class="input-icons">
                                <i class="fa fa-search icon">
                                </i>
                                <input class="input-field" type="search" placeholder="City, community or building">
                            </div>

                        </div>



                        <div style="background-color: black;height: 130px; margin: 0px !important;"
                             class="col-md-2 m-0 btn-mbl d-flex justify-content-center align-items-center">
                            <a type="submit" href="" class="button">Search</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <section>
            <div class="container">
                <h1 class="text-center py-md-5 py-3 fw-bold">HOUSE PRICE IN DUBAI MARINA</h1>
                <div class="shadow px-md-4 py-md-5 px-3 py-5">
                    <div class="row m-0">
                        <div class="col-lg-4">
                            <label for="validationCustom04" class="form-label">Property Type</label>
                            <select class="form-select" id="validationCustom04" required>
                                <option selected disabled value="">Apartment</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="validationCustom04" class="form-label">Number Of Bed</label>
                            <select class="form-select" id="validationCustom04" required>
                                <option selected disabled value="">1 Bedroom</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="validationCustom04" class="form-label">Completion status</label>
                            <select class="form-select" id="validationCustom04" required>
                                <option selected disabled value="">Completed Properties</option>
                                <option>...</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <h1 class="py-md-5 fw-bold py-4">LAST 3 MONTHS</h1>
                <div class="row px-md-5">
                    <div class="col-lg-3 d-flex justify-content-center align-items-center">
                        <div class="shadow text-center average p-5">
                            <p style="color:#707070;" class="font-weihgt m-0">Average asking sales<br> price<br><strong class="text-color">1,450,000 AED</strong><br>Starting from 100,000<br> AED</p>
                        </div>
                    </div>
                    <div class="col-lg-3 d-flex justify-content-center align-items-center">
                        <div class="shadow text-center average p-5 mt-md-0 mt-3">
                            <p style="color:#707070;" class="font-weihgt m-0">Average transaction<br> sales price<br><strong class="text-color">1,180,000 AED</strong><br>SStarting from 21,975 <br> AED</p>
                        </div>
                    </div>
                    <div class="col-lg-3 d-flex justify-content-center align-items-center">
                        <div class="shadow text-center average p-5 mt-md-0 mt-3">
                            <p style="color:#707070;" class="font-weihgt m-0">Average rental price<br> <strong class="text-color">110,000 AED</strong><br>Starting from 21,975 <br> AED</p>
                        </div>
                    </div>
                    <div class="col-lg-3 d-flex justify-content-center align-items-center">
                        <div class="shadow text-center average p-5 mt-md-0 mt-3">
                            <p style="color:#707070;" class="font-weihgt m-0">Average gross yield <br> <strong class="text-color">7.60%</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="pt-md-5">

            <div class="bg-white p-4 mt-md-0 mt-3">
                <div class="container">
                <img src="{{asset('management/images/graf.png')}}" class="w-100" alt="...">
                </div>
            </div>
        </section>
    </div>
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