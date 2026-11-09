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
        .partner-banner {
            background: radial-gradient(ellipse at center, #22201d, #090909 75%);
        }
        .partner-banner:before {
            content: none;
        }
        .partner-logo {
            width: min(76vw, 360px);
            height: auto;
        }
        .description_card{
            background:#161616;
        }
        @include('frontend.snippets.property-card-styles')
    </style>
    @php
        $logoSlug = basename($developer->slug ?? '');
        $partnerLogo = 'frontend/img/partners/'.$logoSlug.'.png';
    @endphp
    @if(is_file(public_path($partnerLogo)))
        <section class="hero-banner partner-banner px-3 py-4">
            <h1 class="position-relative m-0 text-center">
                <img class="partner-logo" src="{{ asset($partnerLogo) }}" alt="{{ $developer->name }}">
            </h1>
        </section>
    @else
    <section class="container-fluid hero-banner" style="background: url({{$developer->cover ? asset('images/media/developers/'.$developer->cover) : asset('frontend/img/banner_update.jpg')}});">
        <div class="row w-100 align-items-center jus h-100 py-4">
            <div class="col-md-4 col-sm-7 col-12 mx-auto text-center">
                @if($developer->image)
                <img class="cover_logo mx-auto" src="{{asset('images/media/developers').'/'.$developer->image}}" alt="">
                @endif
                <h2 class="text-center text-color my-3">{{$developer->name}}</h2>
            </div>
        </div>
    </section>
    @endif
    @if($developer->description)
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
    @endif


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
            <div class="row g-4 mb-4">
                @forelse($properties as $property)
                    <div class="col-12 col-md-6 col-xl-3">
                        @include('frontend.snippets.property-card', [
                            'item' => $property,
                            'cardUrl' => url('developer/'.$developer->slug.'/'.$property->slug),
                        ])
                    </div>
                @empty
                    <p class="text-center">There are currently no published listings for {{ $developer->name }}.</p>
                @endforelse
            </div>
            {{ $properties->links('pagination::bootstrap-4') }}
        </div>
    </section>
@endsection
