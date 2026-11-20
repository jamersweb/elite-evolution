@extends('frontend.layouts.master')
@section('title') {{ $market['name'] }} Property Guide | Elite Evolution @endsection
@section('meta_title') {{ $market['name'] }} Property Guide | Elite Evolution @endsection
@section('meta_description') {{ $market['summary'] }} @endsection
@section('guidance_title', 'Get professional property guidance')
@section('guidance_text', 'Looking in '.$market['name'].'? Tell us the budget and how you want to use the home.')

@section('content')
<style>@include('frontend.snippets.property-card-styles')</style>
<div class="gd-page">
    <section class="gd-hero" style="background-image: url('{{ $image }}')">
        <div class="gd-wrap">
            <p class="gd-crumbs"><a href="{{ url('areas') }}">Areas</a> <span> / {{ $market['name'] }}</span></p>
            <h1 class="gd-title">{{ $market['name'] }}</h1>
            <p class="gd-lead">{{ $market['summary'] }}</p>
            <div class="gd-stats">
                <div><strong>{{ number_format($stats['count']) }}</strong><span>Listings</span></div>
                <div><strong>{{ count($places) }}</strong><span>Communities</span></div>
                <div><strong>{{ $stats['median'] ? \App\Support\MarketGuide::money($stats['median']) : 'On request' }}</strong><span>Median asking price</span></div>
            </div>
        </div>
    </section>

    @if(count($places))
    <section class="gd-section">
        <div class="gd-wrap">
            <div class="gd-section-head">
                <div>
                    <p class="gd-kicker">{{ $market['name'] }}</p>
                    <h2>Areas in {{ $market['name'] }}</h2>
                </div>
            </div>
            <div class="gd-tools">
                <input id="gdAreaSearch" type="search" placeholder="Search areas in {{ $market['name'] }}" aria-label="Search areas">
                <select id="gdAreaSort" aria-label="Sort areas">
                    <option value="name">Name</option>
                    <option value="count">Most listings</option>
                </select>
            </div>
            <div class="gd-grid gd-grid-3" id="gdPlaceGrid">
                @foreach($places as $place)
                    <a class="gd-photo" data-place="{{ strtolower($place['name']) }}" data-count="{{ $place['count'] }}" href="{{ \App\Support\MarketGuide::placeUrl($place) }}" style="height: 230px;">
                        <img src="{{ $place['image'] }}" alt="{{ $place['name'] }}">
                        <div>
                            <h3>{{ $place['name'] }}</h3>
                            <p>{{ $place['count'] }} listings{{ $place['median'] ? ' · '.\App\Support\MarketGuide::money($place['median']) : '' }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <section class="gd-section {{ count($places) ? 'gd-section-cream' : '' }}">
        <div class="gd-wrap">
            <div class="gd-section-head">
                <div>
                    <p class="gd-kicker">On the market</p>
                    <h2>Latest projects in {{ $market['name'] }}</h2>
                </div>
                <a class="gd-link" href="{{ url('listing/sale') }}?location={{ urlencode($market['name']) }}">View all</a>
            </div>
            @if($projects->count())
                <div class="row g-4">
                    @foreach($projects as $item)
                        <div class="col-md-6 col-xl-4">@include('frontend.snippets.property-card', ['item' => $item])</div>
                    @endforeach
                </div>
            @else
                <p class="gd-empty">No published listings in {{ $market['name'] }} right now. Ask an advisor if you want this market watched.</p>
            @endif
        </div>
    </section>

    <section class="gd-section">
        <div class="gd-wrap gd-grid gd-grid-2">
            <div>
                <p class="gd-kicker">Overview</p>
                <h2 class="gd-section-head" style="margin-bottom: 12px;">Area overview</h2>
                <p style="color:#444; line-height:1.75; margin:0;">{{ $market['overview'] }}</p>
            </div>
            <aside class="gd-sticky">
                <h3 style="font-family: Avenir-Heavy, sans-serif; text-transform: uppercase;">Looking in {{ $market['name'] }}?</h3>
                <p>Share the brief and a licensed broker will tell you what we can open.</p>
                <a class="gd-btn" href="#guidance">Enquire</a>
                <a class="gd-btn-line" href="https://api.whatsapp.com/send?phone=971569700771&text={{ urlencode('I am looking in '.$market['name']) }}" target="_blank" rel="noopener">WhatsApp</a>
            </aside>
        </div>
    </section>

    @if($developers->count())
    <section class="gd-section gd-section-cream">
        <div class="gd-wrap">
            <div class="gd-section-head">
                <div>
                    <p class="gd-kicker">Builders</p>
                    <h2>Developers in {{ $market['name'] }}</h2>
                </div>
                <a class="gd-link" href="{{ url('developers') }}">All developers</a>
            </div>
            <div class="gd-grid gd-grid-3">
                @foreach($developers as $developer)
                    <a class="gd-card" href="{{ url('developer/'.$developer->slug) }}" style="text-decoration:none; color:inherit;">
                        <h3 style="margin:0 0 6px; font-size:20px;">{{ $developer->name }}</h3>
                        <p style="margin:0; color:#6f6f6f;">View the projects we list for this developer.</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @include('frontend.guides.partials.faq')

    @if(count($siblings))
    <section class="gd-section" style="padding-top:0;">
        <div class="gd-wrap">
            <div class="gd-section-head">
                <div>
                    <p class="gd-kicker">Keep looking</p>
                    <h2>{{ $market['kind'] === 'international' ? 'Other destinations' : 'Other emirates' }}</h2>
                </div>
            </div>
            <div class="gd-grid gd-grid-4">
                @foreach($siblings as $sibling)
                    <a class="gd-photo" href="{{ \App\Support\MarketGuide::marketUrl($sibling['slug']) }}" style="height: 180px;">
                        <img src="{{ $sibling['image'] }}" alt="{{ $sibling['name'] }}">
                        <div><h3>{{ $sibling['name'] }}</h3></div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
<script>
    (function () {
        var search = document.getElementById('gdAreaSearch');
        var sort = document.getElementById('gdAreaSort');
        var grid = document.getElementById('gdPlaceGrid');
        if (!grid) return;
        function apply() {
            var q = (search && search.value || '').toLowerCase();
            Array.prototype.forEach.call(grid.children, function (card) {
                card.style.display = card.dataset.place.indexOf(q) !== -1 ? '' : 'none';
            });
            if (sort && sort.value === 'count') {
                Array.prototype.slice.call(grid.children).sort(function (a, b) {
                    return (parseInt(b.dataset.count, 10) || 0) - (parseInt(a.dataset.count, 10) || 0);
                }).forEach(function (card) { grid.appendChild(card); });
            } else {
                Array.prototype.slice.call(grid.children).sort(function (a, b) {
                    return a.dataset.place.localeCompare(b.dataset.place);
                }).forEach(function (card) { grid.appendChild(card); });
            }
        }
        if (search) search.addEventListener('input', apply);
        if (sort) sort.addEventListener('change', apply);
    })();
</script>
@endsection
