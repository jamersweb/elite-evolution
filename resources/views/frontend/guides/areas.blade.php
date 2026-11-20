@extends('frontend.layouts.master')
@section('title') Areas to Live and Invest | Elite Evolution Real Estate @endsection
@section('meta_title') Areas to Live and Invest | Elite Evolution Real Estate @endsection
@section('meta_description') Explore Dubai communities, other emirates and international destinations with Elite Evolution. @endsection
@section('guidance_title', 'Get professional property guidance')
@section('guidance_text', 'Tell us the city or community you have in mind and a licensed advisor will come back with what we can actually show you.')

@section('content')
<div class="gd-page">
    <section class="gd-section" style="padding-top: 54px;">
        <div class="gd-wrap">
            <p class="gd-kicker">Areas</p>
            <h1 class="gd-title">Find your place to live and invest</h1>
            <p class="gd-lead">A straight look at the emirates, communities and destinations our clients ask about, tied to the listings we have on the books.</p>
            <div class="gd-stats">
                <div><strong>{{ count($emirates) }}</strong><span>Emirates</span></div>
                <div><strong>{{ $placeCount }}</strong><span>Communities in the guide</span></div>
                <div><strong>{{ number_format($listingCount) }}</strong><span>Published listings</span></div>
            </div>
        </div>
    </section>

    <section class="gd-section" style="padding-top: 0;">
        <div class="gd-wrap">
            <div class="gd-section-head">
                <div>
                    <p class="gd-kicker">United Arab Emirates</p>
                    <h2>Explore the UAE</h2>
                </div>
            </div>
            <div class="gd-grid gd-grid-3">
                @foreach($emirates as $market)
                    <a class="gd-photo" href="{{ \App\Support\MarketGuide::marketUrl($market['slug']) }}" style="height: 240px;">
                        <img src="{{ $market['image'] }}" alt="{{ $market['name'] }}">
                        <div>
                            <h3>{{ $market['name'] }}</h3>
                            <p>{{ $market['region'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="gd-section gd-section-cream">
        <div class="gd-wrap">
            <div class="gd-section-head">
                <div>
                    <p class="gd-kicker">Further afield</p>
                    <h2>International destinations</h2>
                </div>
            </div>
            <div class="gd-grid gd-grid-3">
                @foreach($international as $market)
                    <a class="gd-photo" href="{{ \App\Support\MarketGuide::marketUrl($market['slug']) }}" style="height: 220px;">
                        <img src="{{ $market['image'] }}" alt="{{ $market['name'] }}">
                        <div>
                            <h3>{{ $market['name'] }}</h3>
                            <p>{{ $market['summary'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    @include('frontend.guides.partials.faq')
</div>
@endsection
