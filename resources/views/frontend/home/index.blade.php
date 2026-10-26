@extends('frontend.layouts.master')
@section('title')Elite Evolution: Premier Real Estate Company in Dubai
@endsection
@section('meta_description', 'Excellence with Elite Evolution, your trusted partner for premium real estate. Leading real estate company in Dubai, offering tailored solutions.')
@section('meta_title', 'Elite Evolution: Premier Real Estate Company in Dubai')
@section('content')
@php
    $collectionCover = function ($items) {
        $first = $items->first(function ($p) { return $p->featuredImage && $p->featuredImage->image; });
        return $first ? asset('images/media/' . $first->featuredImage->image) : asset('frontend/img/banner_update.jpg');
    };
    $priceSteps = [100000 => '100K', 250000 => '250K', 500000 => '500K', 1000000 => '1M', 2000000 => '2M', 5000000 => '5M', 10000000 => '10M', 20000000 => '20M', 50000000 => '50M'];
@endphp
<style>
    :root {
        --ee-gold: #bb9e5b;
        --ee-gold-dark: #9f8445;
        --ee-ink: #111111;
        --ee-muted: #6f6f6f;
        --ee-cream: #fbf9f4;
        --ee-line: #ebe5d8;
    }

    .ee-section { padding: 88px 0; }
    .ee-section-cream { background: var(--ee-cream); }
    .ee-eyebrow {
        display: inline-block;
        color: var(--ee-gold);
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-bottom: 10px;
    }
    .ee-heading {
        font-family: Avenir-Heavy;
        font-size: clamp(26px, 3vw, 38px);
        text-transform: uppercase;
        color: var(--ee-ink);
        margin: 0;
    }
    .ee-subheading { color: var(--ee-muted); font-size: 16px; margin: 12px 0 0; max-width: 560px; }
    .ee-section-head { display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 20px; margin-bottom: 44px; }
    .ee-link-arrow {
        color: var(--ee-ink);
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 1px;
        text-transform: uppercase;
        text-decoration: none;
        border-bottom: 2px solid var(--ee-gold);
        padding-bottom: 4px;
        white-space: nowrap;
    }
    .ee-link-arrow:hover { color: var(--ee-gold); }
    .ee-link-arrow i { margin-left: 8px; transition: transform .2s; }
    .ee-link-arrow:hover i { transform: translateX(4px); }

    .ee-btn-gold, .ee-btn-dark, .ee-btn-outline {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 28px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 1px;
        text-transform: uppercase;
        text-decoration: none;
        border: 2px solid transparent;
        transition: background .2s, color .2s, border-color .2s;
    }
    .ee-btn-gold { background: var(--ee-gold); color: #fff; }
    .ee-btn-gold:hover { background: var(--ee-gold-dark); color: #fff; }
    .ee-btn-dark { background: var(--ee-ink); color: var(--ee-gold); }
    .ee-btn-dark:hover { background: #000; color: #fff; }
    .ee-btn-outline { border-color: var(--ee-ink); color: var(--ee-ink); background: transparent; }
    .ee-btn-outline:hover { background: var(--ee-ink); color: var(--ee-gold); }

    /* Hero */
    .ee-hero {
        position: relative;
        min-height: 640px;
        display: flex;
        align-items: center;
        background: url('{{ asset('frontend/img/banner_update.jpg') }}') center / cover no-repeat;
        padding: 120px 0 150px;
    }
    .ee-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0,0,0,.6) 0%, rgba(0,0,0,.45) 45%, rgba(0,0,0,.7) 100%);
    }
    .ee-hero .container { position: relative; z-index: 1; }
    .ee-hero h1 {
        font-family: Avenir-Heavy;
        color: #fff;
        font-size: clamp(32px, 5vw, 58px);
        line-height: 1.1;
        text-transform: uppercase;
        max-width: 820px;
        margin: 0 auto;
    }
    .ee-hero h1 span { color: var(--ee-gold); font-family: inherit; }
    .ee-hero p.lead { color: rgba(255,255,255,.85); font-size: 18px; max-width: 620px; margin: 20px auto 0; }

    .ee-search-wrap { position: relative; z-index: 5; margin-top: -90px; }
    .ee-search {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 24px 60px rgba(0,0,0,.14);
        padding: 8px 28px 28px;
    }
    .ee-search-tabs { display: flex; gap: 28px; border-bottom: 1px solid var(--ee-line); margin-bottom: 22px; }
    .ee-search-tabs input { display: none; }
    .ee-search-tabs label {
        cursor: pointer;
        padding: 16px 2px 14px;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--ee-muted);
        border-bottom: 3px solid transparent;
        margin-bottom: -1px;
    }
    .ee-search-tabs input:checked + label { color: var(--ee-ink); border-bottom-color: var(--ee-gold); }
    .ee-search label.ee-field-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--ee-ink);
        margin-bottom: 8px;
    }
    .ee-search .form-select,
    .ee-search .ee-input {
        height: 50px;
        border: 1px solid var(--ee-line) !important;
        border-radius: 6px;
        background-color: #fff;
        font-size: 15px;
        color: var(--ee-ink);
        width: 100%;
    }
    .ee-search .ee-input { padding: 0 14px 0 40px; }
    .ee-search .ee-input:focus,
    .ee-search .form-select:focus { border-color: var(--ee-gold) !important; outline: none; box-shadow: 0 0 0 3px rgba(187,158,91,.15); }
    .ee-input-icon { position: relative; }
    .ee-input-icon > i { position: absolute; left: 15px; top: 17px; color: var(--ee-gold); }
    .ee-search .ee-btn-dark { height: 50px; width: 100%; }

    /* Trust band */
    .ee-trust { background: var(--ee-ink); padding: 34px 0; margin-top: 70px; }
    .ee-trust-item { display: flex; align-items: center; gap: 16px; color: #fff; }
    .ee-trust-item i {
        flex: 0 0 52px;
        height: 52px;
        border: 1px solid rgba(187,158,91,.5);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--ee-gold);
        font-size: 20px;
    }
    .ee-trust-item strong { display: block; font-size: 15px; letter-spacing: .5px; }
    .ee-trust-item span { font-size: 13px; color: rgba(255,255,255,.65); }

    /* Property cards */
    .ee-prop-card {
        background: #fff;
        border: 1px solid var(--ee-line);
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .ee-prop-card:hover { transform: translateY(-5px); box-shadow: 0 18px 40px rgba(0,0,0,.09); }
    .ee-prop-media { position: relative; display: block; height: 250px; overflow: hidden; background: #1a1a1a; }
    .ee-prop-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
    .ee-prop-card:hover .ee-prop-media img { transform: scale(1.05); }
    .ee-prop-status, .ee-prop-verified {
        position: absolute;
        top: 14px;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .ee-prop-status { left: 14px; background: var(--ee-ink); color: var(--ee-gold); }
    .ee-prop-status.is-offplan { background: var(--ee-gold); color: #fff; }
    .ee-prop-status.is-rent { background: #fff; color: var(--ee-ink); }
    .ee-prop-verified { right: 14px; background: rgba(255,255,255,.92); color: var(--ee-ink); }
    .ee-prop-verified i { color: var(--ee-gold); margin-right: 4px; }
    .ee-prop-body { padding: 22px; display: flex; flex-direction: column; flex-grow: 1; }
    .ee-prop-price { font-family: Avenir-Heavy; font-size: 21px; color: var(--ee-gold); }
    .ee-prop-price small { font-size: 13px; color: var(--ee-muted); margin-left: 3px; font-family: myFirstFont; }
    .ee-prop-title { font-family: Avenir-Heavy; font-size: 17px; margin: 6px 0 6px; line-height: 1.35; }
    .ee-prop-title a { color: var(--ee-ink); text-decoration: none; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .ee-prop-title a:hover { color: var(--ee-gold); }
    .ee-prop-location { color: var(--ee-muted); font-size: 14px; margin-bottom: 16px; }
    .ee-prop-location i { color: var(--ee-gold); margin-right: 7px; }
    .ee-prop-specs {
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        gap: 8px 18px;
        padding: 14px 0 0;
        margin: auto 0 0;
        border-top: 1px solid var(--ee-line);
        font-size: 13px;
        color: #444;
    }
    .ee-prop-specs i { color: var(--ee-gold); margin-right: 6px; }

    /* Collection tiles */
    .ee-tile {
        position: relative;
        display: block;
        height: 420px;
        border-radius: 12px;
        overflow: hidden;
        color: #fff;
        text-decoration: none;
    }
    .ee-tile img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s ease; }
    .ee-tile::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0) 35%, rgba(0,0,0,.82) 100%);
    }
    .ee-tile:hover img { transform: scale(1.06); }
    .ee-tile-body { position: absolute; left: 28px; right: 28px; bottom: 28px; z-index: 1; }
    .ee-tile-body i.ee-tile-icon { color: var(--ee-gold); font-size: 22px; margin-bottom: 12px; }
    .ee-tile-body h3 { font-family: Avenir-Heavy; font-size: 24px; text-transform: uppercase; margin: 0 0 6px; color: #fff; }
    .ee-tile-body p { color: rgba(255,255,255,.8); font-size: 14px; margin: 0 0 14px; }
    .ee-tile-body span { color: var(--ee-gold); font-weight: 700; font-size: 13px; letter-spacing: 1px; text-transform: uppercase; }
    .ee-tile:hover .ee-tile-body span i { transform: translateX(4px); }
    .ee-tile-body span i { transition: transform .2s; margin-left: 6px; }

    /* Developers */
    .ee-dev {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 110px;
        padding: 20px;
        background: #fff;
        border: 1px solid var(--ee-line);
        border-radius: 10px;
        text-decoration: none;
        color: var(--ee-ink);
        font-family: Avenir-Heavy;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-align: center;
        transition: border-color .2s, box-shadow .2s;
    }
    .ee-dev:hover { border-color: var(--ee-gold); box-shadow: 0 10px 24px rgba(0,0,0,.06); color: var(--ee-gold); }
    .ee-dev img { max-height: 60px; max-width: 100%; object-fit: contain; filter: grayscale(1); opacity: .8; transition: filter .2s, opacity .2s; }
    .ee-dev:hover img { filter: none; opacity: 1; }

    /* Agents */
    .ee-agent { background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid var(--ee-line); height: 100%; display: flex; flex-direction: column; }
    .ee-agent-photo { display: block; height: 320px; background: #161616; overflow: hidden; }
    .ee-agent-photo img { width: 100%; height: 100%; object-fit: cover; object-position: top center; transition: transform .5s; }
    .ee-agent-photo img.is-logo { object-fit: contain; padding: 40px; }
    .ee-agent:hover .ee-agent-photo img { transform: scale(1.04); }
    .ee-agent-body { padding: 22px; text-align: center; display: flex; flex-direction: column; flex-grow: 1; }
    .ee-agent-body h3 { font-family: Avenir-Heavy; font-size: 18px; margin: 0 0 4px; }
    .ee-agent-body h3 a { color: var(--ee-ink); text-decoration: none; }
    .ee-agent-role { color: var(--ee-gold); font-size: 14px; margin-bottom: 10px; }
    .ee-agent-brn { display: inline-block; font-size: 12px; color: var(--ee-muted); border: 1px solid var(--ee-line); border-radius: 20px; padding: 3px 12px; margin-bottom: 18px; }
    .ee-agent-actions { display: flex; gap: 8px; margin-top: auto; }
    .ee-agent-actions a { flex: 1; padding: 10px; font-size: 12px; }

    /* Sell CTA */
    .ee-cta {
        position: relative;
        border-radius: 14px;
        overflow: hidden;
        background: var(--ee-ink) url('{{ asset('frontend/img/sell_with_us.jpeg') }}') center / cover no-repeat;
        padding: 72px 56px;
    }
    .ee-cta::before { content: ""; position: absolute; inset: 0; background: linear-gradient(90deg, rgba(0,0,0,.88) 0%, rgba(0,0,0,.6) 60%, rgba(0,0,0,.3) 100%); }
    .ee-cta > * { position: relative; }
    .ee-cta h2 { font-family: Avenir-Heavy; color: #fff; font-size: clamp(26px, 3vw, 40px); text-transform: uppercase; margin: 0 0 14px; max-width: 560px; }
    .ee-cta p { color: rgba(255,255,255,.8); max-width: 520px; margin-bottom: 30px; }
    .ee-cta .ee-btn-outline { border-color: #fff; color: #fff; }
    .ee-cta .ee-btn-outline:hover { background: #fff; color: var(--ee-ink); }

    /* Blog */
    .ee-post { height: 100%; display: flex; flex-direction: column; }
    .ee-post-media { display: block; height: 240px; border-radius: 10px; overflow: hidden; background: #161616; margin-bottom: 20px; }
    .ee-post-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
    .ee-post-media img.is-logo { object-fit: contain; padding: 50px; }
    .ee-post:hover .ee-post-media img { transform: scale(1.05); }
    .ee-post-date { color: var(--ee-gold); font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; }
    .ee-post h3 { font-family: Avenir-Heavy; font-size: 19px; line-height: 1.35; margin: 8px 0 10px; }
    .ee-post h3 a { color: var(--ee-ink); text-decoration: none; }
    .ee-post h3 a:hover { color: var(--ee-gold); }
    .ee-post p { color: var(--ee-muted); font-size: 15px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .ee-post .ee-link-arrow { align-self: flex-start; margin-top: auto; }

    @media (max-width: 991px) {
        .ee-section { padding: 64px 0; }
        .ee-search-wrap { margin-top: -70px; }
        .ee-tile { height: 320px; }
        .ee-cta { padding: 48px 28px; }
    }
    @media (max-width: 575px) {
        .ee-hero { min-height: 560px; padding: 90px 0 130px; }
        .ee-search { padding: 4px 18px 20px; }
        .ee-search-tabs { gap: 20px; }
    }
</style>

{{-- Hero --}}
<section class="ee-hero">
    <div class="container text-center">
        <span class="ee-eyebrow">RERA Licensed Dubai Brokerage</span>
        <h1>Elevate Your Living Experience with <span>Elite Evolution</span></h1>
        <p class="lead">Prime ready homes, exclusive off-plan launches and waterfront villas across Dubai's most coveted addresses.</p>
    </div>
</section>

{{-- Search --}}
<div class="container ee-search-wrap">
    <form class="ee-search" id="eeHomeSearch" action="{{ url('/listing/sale') }}" method="get">
        <div class="ee-search-tabs" role="tablist">
            <input type="radio" name="purpose" id="eePurposeBuy" data-action="{{ url('/listing/sale') }}" checked>
            <label for="eePurposeBuy">Buy</label>
            <input type="radio" name="purpose" id="eePurposeRent" data-action="{{ url('/listing/rent') }}">
            <label for="eePurposeRent">Rent</label>
            <input type="radio" name="purpose" id="eePurposeOffplan" data-action="{{ url('/listing/off-plan') }}">
            <label for="eePurposeOffplan">Off-Plan</label>
        </div>
        <div class="row g-3 align-items-end">
            <div class="col-lg-4">
                <label class="ee-field-label" for="eeLocation">Location</label>
                <div class="ee-input-icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input class="ee-input search-location" id="eeLocation" type="text" name="location" placeholder="City, community or building" autocomplete="off">
                    <div class="position-relative">
                        <ul class="suggestionbar"></ul>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <label class="ee-field-label" for="eeType">Property Type</label>
                <select class="form-select" name="property_type" id="eeType">
                    <option value="">Any</option>
                    @foreach(['Apartment', 'Villa', 'Townhouse', 'Penthouse', 'Mansion', 'Duplex', 'Hotel Apartment', 'Office', 'Residential Plot', 'Commercial Plot'] as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-lg-2">
                <label class="ee-field-label" for="eeBeds">Bedrooms</label>
                <select class="form-select" name="bedrooms" id="eeBeds">
                    <option value="">Any</option>
                    @foreach(['1', '2', '3', '4', '5', '6+'] as $beds)
                        <option value="{{ $beds }}">{{ $beds }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-lg-1">
                <label class="ee-field-label" for="eeMin">Min (AED)</label>
                <select class="form-select" name="min_price" id="eeMin">
                    <option value="">Any</option>
                    @foreach($priceSteps as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-lg-1">
                <label class="ee-field-label" for="eeMax">Max (AED)</label>
                <select class="form-select" name="max_price" id="eeMax">
                    <option value="">Any</option>
                    @foreach($priceSteps as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2">
                <button type="submit" class="ee-btn-dark"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
            </div>
        </div>
    </form>
</div>

{{-- Trust band --}}
<section class="ee-trust">
    <div class="container">
        <div class="row g-4">
            <div class="col-sm-6 col-lg-3">
                <div class="ee-trust-item">
                    <i class="fa-solid fa-shield-halved"></i>
                    <div><strong>DLD &amp; RERA Licensed</strong><span>ORN 31244</span></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="ee-trust-item">
                    <i class="fa-solid fa-certificate"></i>
                    <div><strong>Trakheesi Permitted</strong><span>Verified advertising permits</span></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="ee-trust-item">
                    <i class="fa-solid fa-language"></i>
                    <div><strong>Multilingual Advisors</strong><span>Licensed BRN brokers</span></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="ee-trust-item">
                    <i class="fa-solid fa-passport"></i>
                    <div><strong>Golden Visa Guidance</strong><span>Investor-focused advisory</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Featured properties --}}
@if($featured_properties->count())
<section class="ee-section">
    <div class="container">
        <div class="ee-section-head">
            <div>
                <span class="ee-eyebrow">Handpicked Portfolio</span>
                <h2 class="ee-heading">Featured Properties</h2>
                <p class="ee-subheading">Verified prime listings curated by our licensed brokerage team.</p>
            </div>
            <a href="{{ url('/listing/all') }}" class="ee-link-arrow">View all properties<i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="row g-4">
            @foreach($featured_properties as $item)
                <div class="col-md-6 col-lg-4">
                    @include('frontend.snippets.property-card', ['item' => $item])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Collections --}}
<section class="ee-section ee-section-cream">
    <div class="container">
        <div class="ee-section-head">
            <div>
                <span class="ee-eyebrow">Explore Dubai</span>
                <h2 class="ee-heading">Find Your Next Move</h2>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <a href="{{ url('/listing/ready') }}" class="ee-tile">
                    <img src="{{ $collectionCover($ready_properties) }}" onerror="this.onerror=null;this.src='{{ asset('frontend/img/banner_update.jpg') }}'" alt="Ready properties in Dubai" loading="lazy">
                    <div class="ee-tile-body">
                        <i class="fa-solid fa-key ee-tile-icon"></i>
                        <h3>Ready Properties</h3>
                        <p>Move-in ready villas, penthouses and apartments.</p>
                        <span>Explore<i class="fa-solid fa-arrow-right"></i></span>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="{{ url('/listing/off-plan') }}" class="ee-tile">
                    <img src="{{ $collectionCover($offplan_projects) }}" onerror="this.onerror=null;this.src='{{ asset('frontend/img/banner_update.jpg') }}'" alt="Off-plan projects in Dubai" loading="lazy">
                    <div class="ee-tile-body">
                        <i class="fa-solid fa-compass-drafting ee-tile-icon"></i>
                        <h3>Off-Plan Projects</h3>
                        <p>Prime launches with flexible payment plans.</p>
                        <span>Explore<i class="fa-solid fa-arrow-right"></i></span>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="{{ url('/listing/sale') }}?location={{ urlencode('Jumeirah Islands') }}" class="ee-tile">
                    <img src="{{ asset('images/media/eere-v-105-10.jpg') }}" onerror="this.onerror=null;this.src='{{ asset('frontend/img/banner_update.jpg') }}'" alt="Jumeirah Islands villas in Dubai" loading="lazy">
                    <div class="ee-tile-body">
                        <i class="fa-solid fa-water ee-tile-icon"></i>
                        <h3>Jumeirah Islands</h3>
                        <p>Renovated waterfront villas in a private island community.</p>
                        <span>Explore<i class="fa-solid fa-arrow-right"></i></span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Off-plan launches --}}
@if($offplan_projects->count())
<section class="ee-section">
    <div class="container">
        <div class="ee-section-head">
            <div>
                <span class="ee-eyebrow">New Launches</span>
                <h2 class="ee-heading">Off-Plan Investments</h2>
                <p class="ee-subheading">Secure early access to Dubai's most anticipated developments.</p>
            </div>
            <a href="{{ url('/listing/off-plan') }}" class="ee-link-arrow">All off-plan projects<i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="row g-4">
            @foreach($offplan_projects as $item)
                <div class="col-md-6 col-lg-3">
                    @include('frontend.snippets.property-card', ['item' => $item])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Developers --}}
@if($developers->count())
<section class="ee-section ee-section-cream">
    <div class="container">
        <div class="ee-section-head">
            <div>
                <span class="ee-eyebrow">Trusted Partners</span>
                <h2 class="ee-heading">Leading Developers</h2>
            </div>
        </div>
        <div class="row g-3">
            @foreach($developers as $developer)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ url('developer', $developer->slug) }}" class="ee-dev" title="{{ $developer->name }}">
                        @if($developer->image)
                            <img src="{{ asset('images/media/developers/' . $developer->image) }}" alt="{{ $developer->name }}" loading="lazy"
                                 onerror="this.replaceWith(document.createTextNode(this.alt))">
                        @else
                            {{ $developer->name }}
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Agents --}}
@if(count($agent))
<section class="ee-section">
    <div class="container">
        <div class="ee-section-head">
            <div>
                <span class="ee-eyebrow">Licensed Brokers</span>
                <h2 class="ee-heading">Meet the Agents</h2>
                <p class="ee-subheading">Discreet, multilingual advisors registered with the Dubai Land Department.</p>
            </div>
            <a href="{{ url('/agents') }}" class="ee-link-arrow">All brokers<i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($agent->take(4) as $agents)
                <div class="col-sm-6 col-lg-3">
                    <div class="ee-agent">
                        <a href="{{ url('agents', $agents->slug) }}" class="ee-agent-photo">
                            @if($agents->image)
                                <img src="{{ asset('images/media/profile/' . $agents->image) }}" alt="{{ $agents->name }}" loading="lazy">
                            @else
                                <img src="{{ asset('frontend/img/logo.png') }}" class="is-logo" alt="{{ $agents->name }}" loading="lazy">
                            @endif
                        </a>
                        <div class="ee-agent-body">
                            <h3><a href="{{ url('agents', $agents->slug) }}">{{ $agents->name }}</a></h3>
                            <div class="ee-agent-role">{{ $agents->occupation ?: 'Property Advisor' }}</div>
                            @if($agents->brn)
                                <div><span class="ee-agent-brn">BRN {{ $agents->brn }}</span></div>
                            @endif
                            <div class="ee-agent-actions">
                                <a href="{{ url('agents', $agents->slug) }}" class="ee-btn-outline">Profile</a>
                                @if($agents->whatsapp_no)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $agents->whatsapp_no) }}" target="_blank" rel="noopener" class="ee-btn-dark">
                                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Sell CTA --}}
<section class="pb-5">
    <div class="container">
        <div class="ee-cta">
            <span class="ee-eyebrow">Owners &amp; Landlords</span>
            <h2>Thinking of Selling or Leasing Your Property?</h2>
            <p>Get a confidential valuation from our licensed advisors and reach qualified buyers and tenants across our global network.</p>
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ url('/sell-your-property') }}" class="ee-btn-gold">List Your Property</a>
                <a href="{{ url('/appraise-your-property') }}" class="ee-btn-outline">Free Valuation</a>
            </div>
        </div>
    </div>
</section>

{{-- Blog temporarily hidden until current market insights are published --}}

<script>
    document.querySelectorAll('#eeHomeSearch input[name="purpose"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            document.getElementById('eeHomeSearch').action = this.dataset.action;
        });
    });
    document.getElementById('eeHomeSearch').addEventListener('submit', function () {
        this.querySelectorAll('input[name="purpose"]').forEach(function (r) { r.disabled = true; });
        this.querySelectorAll('select, input[name="location"]').forEach(function (field) {
            if (!field.value) field.disabled = true;
        });
    });
</script>
@endsection
