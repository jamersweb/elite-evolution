@extends('frontend.layouts.master')
@section('title') {{ $place['name'] }} Property Guide | Elite Evolution @endsection
@section('meta_title') {{ $place['name'] }}, {{ $market['name'] }} | Elite Evolution @endsection
@section('meta_description') {{ $place['summary'] }} @endsection
@section('guidance_title', 'Get professional property guidance')
@section('guidance_text', 'Tell us what you want in '.$place['name'].' and an advisor will reply with current availability.')

@section('content')
<style>@include('frontend.snippets.property-card-styles')</style>
@php
    $saleUrl = url('listing/sale').'?location='.urlencode($place['name']);
    $offplanUrl = url('listing/off-plan').'?location='.urlencode($place['name']);
@endphp
<div class="gd-page">
    <section class="gd-section" style="padding-bottom: 20px;">
        <div class="gd-wrap gd-grid gd-grid-2">
            <div>
                <p class="gd-crumbs">
                    <a href="{{ url('areas') }}">Areas</a> /
                    <a href="{{ \App\Support\MarketGuide::marketUrl($market['slug']) }}">{{ $market['name'] }}</a> /
                    {{ $place['name'] }}
                </p>
                <p class="gd-kicker">{{ \App\Support\MarketGuide::groupLabel($place['group'] ?? null) ?: $market['name'] }}</p>
                <h1 class="gd-title">{{ $place['name'] }}</h1>
                <p class="gd-lead">{{ $place['summary'] }}</p>
                <div class="gd-stats">
                    <div><strong>{{ number_format($stats['count']) }}</strong><span>Listings</span></div>
                    <div><strong>{{ $stats['developers'] }}</strong><span>Developers</span></div>
                    <div><strong>{{ $stats['median'] ? \App\Support\MarketGuide::money($stats['median']) : 'On request' }}</strong><span>Median asking price</span></div>
                </div>
                <div class="gd-actions">
                    <a class="gd-btn" href="#guidance">Enquire</a>
                    <a class="gd-btn-line" href="https://api.whatsapp.com/send?phone=971569700771&text={{ urlencode('I would like details on '.$place['name']) }}" target="_blank" rel="noopener">WhatsApp</a>
                </div>
            </div>
            <div class="gd-split-photo" style="background-image: url('{{ $image }}')" role="img" aria-label="{{ $place['name'] }}"></div>
        </div>
    </section>

    <section class="gd-section">
        <div class="gd-wrap">
            <div class="gd-section-head">
                <div>
                    <p class="gd-kicker">New projects</p>
                    <h2>Off-plan properties</h2>
                </div>
                <a class="gd-link" href="{{ $offplanUrl }}">View all</a>
            </div>
            @if($offplan->count())
                <div class="row g-4">
                    @foreach($offplan as $item)
                        <div class="col-md-6 col-xl-4">@include('frontend.snippets.property-card', ['item' => $item])</div>
                    @endforeach
                </div>
            @else
                <p class="gd-empty">No off-plan listings published in {{ $place['name'] }} at the moment.</p>
            @endif
        </div>
    </section>

    <section class="gd-section" style="padding-top:0;">
        <div class="gd-wrap">
            <div class="gd-section-head">
                <div>
                    <p class="gd-kicker">Ready homes</p>
                    <h2>Resale properties</h2>
                </div>
                <a class="gd-link" href="{{ $saleUrl }}">View all</a>
            </div>
            @if($resale->count())
                <div class="row g-4">
                    @foreach($resale as $item)
                        <div class="col-md-6 col-xl-4">@include('frontend.snippets.property-card', ['item' => $item])</div>
                    @endforeach
                </div>
            @else
                <p class="gd-empty">No resale listings published in {{ $place['name'] }} at the moment.</p>
            @endif
        </div>
    </section>

    <section class="gd-section gd-section-cream">
        <div class="gd-wrap">
            <div class="gd-section-head">
                <div>
                    <p class="gd-kicker">Map</p>
                    <h2>Explore projects</h2>
                </div>
                <div class="gd-pills" style="margin:0;">
                    <a href="{{ $offplanUrl }}">Off-plan</a>
                    <a href="{{ $saleUrl }}">Resale</a>
                </div>
            </div>
            <iframe class="gd-map" title="Map of {{ $place['name'] }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://maps.google.com/maps?q={{ urlencode($mapQuery) }}&z=13&output=embed"></iframe>
        </div>
    </section>

    <section class="gd-section">
        <div class="gd-wrap gd-grid gd-grid-2">
            <div>
                <p class="gd-kicker">Guide</p>
                <h2 style="font-family: Avenir-Heavy, sans-serif; text-transform: uppercase;">Area overview</h2>
                <div class="gd-tabs" role="tablist">
                    <button type="button" class="is-on" data-gd-tab="about">Description</button>
                    <button type="button" data-gd-tab="price">Price snapshot</button>
                    <button type="button" data-gd-tab="around">Getting around</button>
                </div>
                <div class="gd-panel is-on" data-gd-panel="about"><p>{{ $place['overview'] }}</p></div>
                <div class="gd-panel" data-gd-panel="price">
                    <p>
                        @if($stats['count'])
                            We currently publish {{ $stats['count'] }} {{ Str::plural('listing', $stats['count']) }} in {{ $place['name'] }}.
                            @if($stats['median']) The median asking price on that book is {{ \App\Support\MarketGuide::money($stats['median']) }}. @endif
                            That is our stock, not a closed transaction index.
                        @else
                            We do not have a published asking price in {{ $place['name'] }} today. An advisor can still talk through what has been trading.
                        @endif
                    </p>
                </div>
                <div class="gd-panel" data-gd-panel="around">
                    @if(!empty($place['infrastructure']))
                        <ul>
                            @foreach($place['infrastructure'] as $point)
                                <li>{{ $point }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>Ask us for the practical points: access, schools and what daily life in {{ $place['name'] }} actually feels like.</p>
                    @endif
                </div>
            </div>
            <aside class="gd-sticky">
                <h3 style="font-family: Avenir-Heavy, sans-serif; text-transform: uppercase;">Looking for property in this area?</h3>
                <p>A broker who covers {{ $place['name'] }} can shortlist from the live book.</p>
                <a class="gd-btn" href="#guidance">Enquire</a>
                <a class="gd-btn-line" href="https://api.whatsapp.com/send?phone=971569700771&text={{ urlencode('Looking in '.$place['name']) }}" target="_blank" rel="noopener">WhatsApp</a>
            </aside>
        </div>
    </section>

    @if($developers->count())
    <section class="gd-section gd-section-cream">
        <div class="gd-wrap">
            <div class="gd-section-head">
                <h2>Developers in {{ $place['name'] }}</h2>
                <a class="gd-link" href="{{ url('developers') }}">All developers</a>
            </div>
            <div class="gd-grid gd-grid-3">
                @foreach($developers as $developer)
                    <a class="gd-card" href="{{ url('developer/'.$developer->slug) }}" style="color:inherit; text-decoration:none;">
                        <h3 style="margin:0;">{{ $developer->name }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if($agents->count())
    <section class="gd-section">
        <div class="gd-wrap">
            <div class="gd-section-head">
                <h2>Area agents</h2>
                <a class="gd-link" href="{{ url('agents') }}">All brokers</a>
            </div>
            <div class="gd-grid gd-grid-4">
                @foreach($agents as $agent)
                    <article class="gd-agent">
                        @if($agent->image)
                            <img src="{{ asset('images/media/profile/'.$agent->image) }}" alt="{{ $agent->name }}">
                        @else
                            <img src="{{ asset('frontend/img/banner_update.jpg') }}" alt="">
                        @endif
                        <h3><a href="{{ $agent->slug ? url('agents/'.$agent->slug) : url('agents') }}">{{ $agent->name }}</a></h3>
                        @if($agent->brn)<p class="gd-chip">BRN {{ $agent->brn }}</p>@endif
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @include('frontend.guides.partials.faq')

    @if(count($similar))
    <section class="gd-section" style="padding-top:0;">
        <div class="gd-wrap">
            <div class="gd-section-head"><h2>Similar areas</h2></div>
            <div class="gd-grid gd-grid-3">
                @foreach($similar as $item)
                    <a class="gd-photo" href="{{ \App\Support\MarketGuide::placeUrl($item) }}" style="height: 210px;">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                        <div>
                            <h3>{{ $item['name'] }}</h3>
                            <p>{{ $item['count'] }} listings</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
<script>
    document.querySelectorAll('[data-gd-tab]').forEach(function (button) {
        button.addEventListener('click', function () {
            var name = button.getAttribute('data-gd-tab');
            document.querySelectorAll('[data-gd-tab]').forEach(function (item) { item.classList.toggle('is-on', item === button); });
            document.querySelectorAll('[data-gd-panel]').forEach(function (panel) {
                panel.classList.toggle('is-on', panel.getAttribute('data-gd-panel') === name);
            });
        });
    });
</script>
@endsection
