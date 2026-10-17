@extends('frontend.layouts.master')
@section('title')
     {!! $developer->meta_title !!}
@endsection

@section('meta_description')
{!! $developer->meta_description !!}
@endsection

@section('meta_title')
{!! $developer->meta_title !!}
@endsection

@section('meta_tag')
{!! $developer->meta_tag !!}
@endsection

@section('content')
    <style>
        .blogs img {
            height: 200px;
            object-fit: cover;
        }
        .hero-banner{
            min-height:60vh;
            background-position: center !important;
            background-size: cover !important;
            background-repeat: no-repeat !important;
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
            justify-content: center;
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
            z-index: 1;
        }
        img.cover_logo {
            width: 100%;

            object-fit: contain;
        }
        .description_card{
            background:#161616;
        }
        .states img {
            border-top-left-radius: 30px;
            border-top-right-radius: 30px;
            height: 275px;
            object-fit: cover;
        }
    </style>
{{--    <section class="container-fluid hero-banner" style="background: url({{asset('frontend/img/blog.png')}});">--}}
{{--        <div class="row align-items-center h-100">--}}
{{--            <div class="col-12">--}}
{{--                <h1 class="text-center text-uppercase text-white"></h1>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    <section class="container-fluid hero-banner" style="background: url({{asset('images/media/developers').'/'.$developer->cover}});">
        <div class="row w-100 align-items-center jus h-100 py-4">
            <div class="col-md-4 col-sm-7 col-12 mx-auto text-center">
                <img class="cover_logo mx-auto" src="{{asset('images/media/developers').'/'.$developer->image}}" alt="">
                <h2 class="text-center text-color my-3">{{$developer->name}}</h2>
                <!-- Button trigger modal -->
{{--                <button type="button" class="btn-new mx-md-3 rounded-0 " data-bs-toggle="modal" data-bs-target="#staticBackdrop">--}}
{{--                    Download Brochure--}}
{{--                </button>--}}
            </div>
        </div>
    </section>
    <section>
        <div class="container px-md-5 py-5">
            <div class="row py-md-5">
                <div class="col-lg-8 mx-auto">
                   <div class="card description_card p-md-4">
                       <div class="card-body text-center text-white">
                           {!! $developer->description  !!}
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{url('inquire-developer',)}}" action="post">
                    @csrf
                    <input type="hidden" name="dev_id" value="{{$developer->id}}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Understood</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section>
        <div class="container px-md-5 py-5">
{{--            <div class="row py-md-5">--}}
{{--                <div class="col-lg-9 mx-auto">--}}
{{--                    <h1 class="text-uppercase mb-4">{{$developer->name}}</h1>--}}
{{--                    {!! $developer->description  !!}--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="row justify-content-center">
                @forelse($developer->property as $property)
                    <div class="col-md-3 states my-2">
                        <div class="position-relative">
                            <a class="text-dark text-decoration-none" href="{{url('/developer',$developer->slug).'/'.$property->slug}}">
                                <img class="w-100" src="{{ optional($property->featuredImage)->image ? asset('images/media/' . $property->featuredImage->image) : asset('frontend/img/banner_update.jpg') }}" alt="{{ $property->title }}">
                                <div class="">
                                     <div class="property-text">
                                     <h5 class="m-0">Dubai</h5>
                                     </div>
                                </div>
                                <div class="card-body card">
                                    <h5 class="card-title fw-bold fs-18">{{$property->title}}</h5>
{{--                                    <p class="card-text">{{$states['count']}} new properties for Sale</p>--}}
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    No Property Found
                @endforelse
            </div>
        </div>
    </section>
@endsection
