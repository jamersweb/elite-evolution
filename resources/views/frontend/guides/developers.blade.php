@extends('frontend.layouts.master')
@section('title') Property Developers in the UAE | Elite Evolution @endsection
@section('meta_title') Property Developers in the UAE | Elite Evolution @endsection
@section('meta_description') Browse the developers Elite Evolution works with across Dubai and the UAE. @endsection
@section('guidance_title', 'Get professional property guidance')
@section('guidance_text', 'Name the developer or the kind of project you want and we will tell you what is open.')

@section('content')
@php
    $byDeveloper = $meta->groupBy('developer_id');
@endphp
<div class="gd-page">
    <section class="gd-section" style="padding-bottom: 10px;">
        <div class="gd-wrap">
            <p class="gd-kicker">Developers</p>
            <h1 class="gd-title">Property developers in the UAE</h1>
            <p class="gd-lead">The developers on our books. Open a name to see the projects we currently list, or tell us who you want an introduction to.</p>
            <div class="gd-stats">
                <div><strong>{{ $developers->count() }}</strong><span>Developers</span></div>
                <div><strong>{{ number_format($listingCount) }}</strong><span>Listings tied to a developer</span></div>
                <div><strong>{{ number_format($communityCount) }}</strong><span>Communities with stock</span></div>
            </div>
            <form class="gd-search" method="get" action="{{ url('developers') }}">
                @if($activeSegment)<input type="hidden" name="segment" value="{{ $activeSegment }}">@endif
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Search developers" aria-label="Search developers">
                <button class="gd-btn" type="submit">Search</button>
            </form>
            <div class="gd-pills">
                <a class="{{ request('location') ? '' : 'is-on' }}" href="{{ url('developers') }}">All</a>
                @foreach($locations as $location)
                    <a class="{{ request('location') === $location ? 'is-on' : '' }}" href="{{ url('developers') }}?location={{ urlencode($location) }}">{{ $location }}</a>
                @endforeach
            </div>
            @if($developers->count())
                <div class="gd-grid gd-grid-3">
                    @foreach($developers as $developer)
                        @php
                            $logo = 'frontend/img/partners/'.basename($developer->slug).'.png';
                            $rows = $byDeveloper->get($developer->id, collect());
                            $tags = $rows->pluck('property_type')->filter()->unique()->take(3);
                            $areas = $rows->pluck('community')->filter()->unique()->count();
                        @endphp
                        <article class="gd-dev">
                            <a href="{{ url('developer/'.$developer->slug) }}" class="gd-logo">
                                @if(is_file(public_path($logo)))
                                    <img src="{{ asset($logo) }}" alt="{{ $developer->name }}">
                                @elseif($developer->image)
                                    <img src="{{ asset('images/media/developers/'.$developer->image) }}" alt="{{ $developer->name }}">
                                @else
                                    <strong>{{ $developer->name }}</strong>
                                @endif
                            </a>
                            <h2 style="font-size:20px; margin:0;"><a href="{{ url('developer/'.$developer->slug) }}" style="color:inherit; text-decoration:none;">{{ $developer->name }}</a></h2>
                            @if($tags->count())
                                <div class="gd-tags">
                                    @foreach($tags as $tag)<span>{{ $tag }}</span>@endforeach
                                </div>
                            @endif
                            <p>{{ \Illuminate\Support\Str::limit(trim(strip_tags($developer->description ?: 'Projects and ready homes we currently list for '.$developer->name.'.')), 140) }}</p>
                            <div class="gd-meta">
                                <span><b>{{ $developer->listings_count }}</b> listings</span>
                                <span><b>{{ $areas }}</b> areas</span>
                            </div>
                            <a class="gd-btn-line" href="https://api.whatsapp.com/send?phone=971569700771&text={{ urlencode('I am interested in '.$developer->name) }}" target="_blank" rel="noopener">WhatsApp</a>
                        </article>
                    @endforeach
                </div>
            @else
                <p class="gd-empty">No developer matches that search. Clear the filter or send us the name.</p>
            @endif
        </div>
    </section>

    <section class="gd-section">
        <div class="gd-wrap">
            <div class="gd-banner">
                <div>
                    <h2>Want to sell your property at the best price?</h2>
                    <p>We appraise and market homes across the communities on this site.</p>
                </div>
                <a class="gd-btn" href="{{ url('sell-your-property') }}">Book an appraisal</a>
            </div>
        </div>
    </section>

    <section class="gd-section" style="padding-top:0;">
        <div class="gd-wrap">
            <div class="gd-section-head">
                <div>
                    <p class="gd-kicker">By brief</p>
                    <h2>Curated segments</h2>
                </div>
            </div>
            <div class="gd-grid gd-grid-3">
                @foreach($segments as $segment)
                    <a class="gd-card" href="{{ url('developers') }}?segment={{ $segment['key'] }}" style="text-decoration:none; color:inherit;">
                        <p class="gd-kicker">Developers</p>
                        <h3 style="margin:8px 0;">{{ $segment['label'] }}</h3>
                        <p style="margin:0; color:#6f6f6f;">Developers with stock in these communities.</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    @include('frontend.guides.partials.faq')
</div>
@endsection
