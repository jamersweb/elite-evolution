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

@section('guidance_title', 'Get professional property guidance')
@section('guidance_text', 'Ask about '.$developer->name.' and a licensed advisor will come back with current availability.')

@section('content')
    <style>@include('frontend.snippets.property-card-styles')</style>
    @php
        $logoSlug = basename($developer->slug ?? '');
        $partnerLogo = 'frontend/img/partners/'.$logoSlug.'.png';
    @endphp
    <div class="gd-page">
        <section class="gd-section" style="padding-bottom: 20px;">
            <div class="gd-wrap gd-grid gd-grid-2">
                <div>
                    <p class="gd-crumbs"><a href="{{ url('developers') }}">Developers</a> / {{ $developer->name }}</p>
                    <h1 class="gd-title">{{ $developer->name }}</h1>
                    <p class="gd-lead">Dubai, UAE</p>
                    <div class="gd-tags">
                        @if($stats['offplan'])<span>Off-plan</span>@endif
                        @if($stats['count'] > $stats['offplan'])<span>Ready homes</span>@endif
                    </div>
                    <div class="gd-stats">
                        <div><strong>{{ number_format($stats['count']) }}</strong><span>Listings</span></div>
                        <div><strong>{{ $stats['communities'] }}</strong><span>Areas</span></div>
                        <div><strong>{{ $stats['offplan'] }}</strong><span>Off-plan</span></div>
                    </div>
                    <div class="gd-actions">
                        <a class="gd-btn" href="#guidance">Ask for details</a>
                        <a class="gd-btn-line" href="https://api.whatsapp.com/send?phone=971569700771&text={{ urlencode('I am interested in '.$developer->name.' properties') }}" target="_blank" rel="noopener">WhatsApp</a>
                    </div>
                </div>
                <div class="gd-card" style="min-height: 280px; display:flex; align-items:center; justify-content:center; background:#111;">
                    @if(is_file(public_path($partnerLogo)))
                        <img src="{{ asset($partnerLogo) }}" alt="{{ $developer->name }}" style="max-width: 70%; max-height: 160px; object-fit: contain;">
                    @elseif($developer->image)
                        <img src="{{ asset('images/media/developers/'.$developer->image) }}" alt="{{ $developer->name }}" style="max-width: 70%; max-height: 160px; object-fit: contain;">
                    @else
                        <strong style="color:#bb9e5b; font-size: 28px; letter-spacing: 1px;">{{ $developer->name }}</strong>
                    @endif
                </div>
            </div>
        </section>

        <section class="gd-section">
            <div class="gd-wrap">
                <div class="gd-section-head">
                    <div>
                        <p class="gd-kicker">Projects</p>
                        <h2>Latest projects by {{ $developer->name }}</h2>
                    </div>
                    <div class="gd-filters">
                        <button type="button" class="is-on" data-dev-filter="all">All</button>
                        <button type="button" data-dev-filter="offplan">Under construction</button>
                        <button type="button" data-dev-filter="ready">Ready</button>
                    </div>
                </div>
                <div class="row g-4" id="gdDevProjects">
                    @forelse($properties as $property)
                        @php
                            $isOffplan = $property->completion_status === 'Off-plan' || $property->is_new_project;
                        @endphp
                        <div class="col-md-6 col-xl-4" data-listing="{{ $isOffplan ? 'offplan' : 'ready' }}">
                            @include('frontend.snippets.property-card', [
                                'item' => $property,
                                'cardUrl' => url('developer/'.$developer->slug.'/'.$property->slug),
                            ])
                        </div>
                    @empty
                        <p class="gd-empty">There are currently no published listings for {{ $developer->name }}.</p>
                    @endforelse
                </div>
                <div style="margin-top: 28px;">{{ $properties->links('pagination::bootstrap-4') }}</div>
            </div>
        </section>

        @if($communities->count())
        <section class="gd-section gd-section-cream">
            <div class="gd-wrap">
                <div class="gd-section-head">
                    <div>
                        <p class="gd-kicker">Locations</p>
                        <h2>Where {{ $developer->name }} builds</h2>
                    </div>
                </div>
                <div class="gd-grid gd-grid-3">
                    @foreach($communities as $area)
                        <a class="gd-card" href="{{ url('areas/dubai/'.$area['slug']) }}" style="color:inherit; text-decoration:none;">
                            <h3 style="margin:0 0 8px;">{{ $area['name'] }}</h3>
                            <p style="margin:0; color:#6f6f6f;">{{ $area['count'] }} listings{{ $area['median'] ? ' · median '.\App\Support\MarketGuide::money($area['median']) : '' }}{{ $area['sqft'] ? ' · AED '.number_format($area['sqft']).'/sq.ft' : '' }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <section class="gd-section">
            <div class="gd-wrap gd-grid gd-grid-2">
                <div>
                    <p class="gd-kicker">About</p>
                    <h2 style="font-family: Avenir-Heavy, sans-serif; text-transform: uppercase;">About {{ $developer->name }}</h2>
                    @if($developer->description)
                        <div style="color:#444; line-height:1.7;">{!! $developer->description !!}</div>
                    @else
                        <p style="color:#444; line-height:1.7;">We list {{ $stats['count'] }} {{ \Illuminate\Support\Str::plural('home', $stats['count']) }} with {{ $developer->name }}{{ $stats['communities'] ? ' across '.$stats['communities'].' '.\Illuminate\Support\Str::plural('area', $stats['communities']) : '' }}. Ask for the buildings we can introduce.</p>
                    @endif
                </div>
                <aside class="gd-sticky">
                    <h3 style="font-family: Avenir-Heavy, sans-serif; text-transform: uppercase;">Interested in {{ $developer->name }} properties?</h3>
                    <p>Tell us the budget and whether you want ready or off-plan.</p>
                    <a class="gd-btn" href="#guidance">Ask for details</a>
                    <a class="gd-btn-line" href="https://api.whatsapp.com/send?phone=971569700771&text={{ urlencode('Interested in '.$developer->name) }}" target="_blank" rel="noopener">WhatsApp</a>
                </aside>
            </div>
        </section>

        @if($agents->count())
        <section class="gd-section gd-section-cream">
            <div class="gd-wrap">
                <div class="gd-section-head"><h2>Agents working with {{ $developer->name }}</h2></div>
                <div class="gd-grid gd-grid-4">
                    @foreach($agents as $agent)
                        <article class="gd-agent">
                            @if($agent->image)
                                <img src="{{ asset('images/media/profile/'.$agent->image) }}" alt="{{ $agent->name }}">
                            @else
                                <img src="{{ asset('frontend/img/banner_update.jpg') }}" alt="">
                            @endif
                            <h3><a href="{{ $agent->slug ? url('agents/'.$agent->slug) : url('agents') }}">{{ $agent->name }}</a></h3>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        @php
            $faqs = [
                ['q' => 'Does Elite Evolution sell every '.$developer->name.' project?', 'a' => 'We show the projects and ready homes currently on our books. If you have a specific building in mind, ask and we will say whether we can represent it.'],
                ['q' => 'Can I get a payment plan?', 'a' => 'Where the developer is still selling off-plan, we will send the plan that applies to that release, not a generic table.'],
                ['q' => 'Who do I speak to?', 'a' => 'Use the form on this page or WhatsApp. A licensed broker follows up. You do not need to find the developer’s call centre first.'],
            ];
        @endphp
        @include('frontend.guides.partials.faq')

        @if($others->count())
        <section class="gd-section" style="padding-top:0;">
            <div class="gd-wrap">
                <div class="gd-section-head">
                    <h2>Other developers</h2>
                    <a class="gd-link" href="{{ url('developers') }}">All developers</a>
                </div>
                <div class="gd-grid gd-grid-3">
                    @foreach($others as $other)
                        @php $otherLogo = 'frontend/img/partners/'.basename($other->slug).'.png'; @endphp
                        <a class="gd-card" href="{{ url('developer/'.$other->slug) }}" style="color:inherit; text-decoration:none; min-height: 140px; display:flex; align-items:center;">
                            @if(is_file(public_path($otherLogo)))
                                <img src="{{ asset($otherLogo) }}" alt="{{ $other->name }}" style="max-height: 56px; max-width: 150px; object-fit: contain;">
                            @else
                                <strong>{{ $other->name }}</strong>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    </div>
    <script>
        document.querySelectorAll('[data-dev-filter]').forEach(function (button) {
            button.addEventListener('click', function () {
                var filter = button.getAttribute('data-dev-filter');
                document.querySelectorAll('[data-dev-filter]').forEach(function (item) {
                    item.classList.toggle('is-on', item === button);
                });
                document.querySelectorAll('[data-listing]').forEach(function (card) {
                    card.style.display = (filter === 'all' || card.getAttribute('data-listing') === filter) ? '' : 'none';
                });
            });
        });
    </script>
@endsection
