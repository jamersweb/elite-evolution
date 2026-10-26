@extends('frontend.layouts.master')
@section('title')
    Licensed Real Estate Brokers & Advisors | Elite Evolution Real Estate Dubai
@endsection

@section('meta_title')
    Meet Our Licensed Dubai Real Estate Brokers | Elite Evolution
@endsection

@section('meta_description')
    Connect with Elite Evolution's DLD-registered real estate advisors. Certified luxury specialists for Palm Jumeirah, DAMAC Lagoons, Emirates Hills, and exclusive off-plan developments.
@endsection

@section('content')
<style>
    .broker-banner {
        background: linear-gradient(rgba(10, 10, 10, 0.8), rgba(10, 10, 10, 0.8)), url('{{ asset("frontend/img/banner-bg.jpg") }}') center/cover no-repeat;
        padding: 90px 0 65px;
        color: #fff;
        text-align: center;
        border-bottom: 2px solid #b38b47;
    }
    .broker-card {
        background: #fff;
        border: 1px solid #eaeaea;
        border-radius: 8px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .broker-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 32px rgba(0,0,0,0.09);
    }
    .broker-avatar {
        width: 140px;
        height: 140px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #b38b47;
        margin: 25px auto 15px;
        display: block;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .brn-badge {
        background: #f5ede1;
        color: #8b6528;
        font-weight: 700;
        font-size: 12px;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-block;
        letter-spacing: 0.5px;
    }
    .featured-ribbon {
        position: absolute;
        top: 14px;
        right: 14px;
        background: #b38b47;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 3px 10px;
        border-radius: 12px;
    }
    .broker-btn-wa {
        background-color: #25D366;
        color: #fff !important;
        font-size: 13px;
        font-weight: 600;
        border-radius: 4px;
        padding: 8px 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .broker-btn-wa:hover {
        background-color: #1eb956;
    }
    .broker-btn-profile {
        background-color: #111;
        color: #fff !important;
        font-size: 13px;
        font-weight: 600;
        border-radius: 4px;
        padding: 8px 14px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .broker-btn-profile:hover {
        background-color: #b38b47;
    }
    .filter-bar {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        padding: 16px 20px;
        margin-top: -30px;
        position: relative;
        z-index: 10;
        box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    }
</style>

<section class="broker-banner">
    <div class="container">
        <span class="text-uppercase" style="letter-spacing: 3px; color: #b38b47; font-size: 13px; font-weight: 700;">DLD Registered & Certified</span>
        <h1 class="fw-bold mt-2 mb-3" style="font-family: serif; letter-spacing: 1px;">MEET OUR LICENSED BROKERS</h1>
        <p class="text-white-50 mx-auto fs-6" style="max-width: 680px;">
            Elite Evolution represents private clients, international investors, and family offices with integrity, discreet counsel, and deep market intelligence across Dubai prime enclaves.
        </p>
    </div>
</section>

<!-- Filter Section -->
<div class="container">
    <div class="filter-bar">
        <form method="GET" action="{{ url('/agents') }}" class="row g-2 align-items-center">
            <div class="col-lg-4 col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search broker by name or specialty..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <select name="area" class="form-select form-select-sm">
                    <option value="">All Dubai Communities</option>
                    <option value="Palm Jumeirah" {{ request('area') == 'Palm Jumeirah' ? 'selected' : '' }}>Palm Jumeirah</option>
                    <option value="DAMAC Lagoons" {{ request('area') == 'DAMAC Lagoons' ? 'selected' : '' }}>DAMAC Lagoons</option>
                    <option value="Emirates Hills" {{ request('area') == 'Emirates Hills' ? 'selected' : '' }}>Emirates Hills</option>
                    <option value="Jumeirah Islands" {{ request('area') == 'Jumeirah Islands' ? 'selected' : '' }}>Jumeirah Islands</option>
                    <option value="Downtown Dubai" {{ request('area') == 'Downtown Dubai' ? 'selected' : '' }}>Downtown Dubai</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-3">
                <select name="language" class="form-select form-select-sm">
                    <option value="">All Spoken Languages</option>
                    <option value="English" {{ request('language') == 'English' ? 'selected' : '' }}>English</option>
                    <option value="French" {{ request('language') == 'French' ? 'selected' : '' }}>French</option>
                    <option value="Arabic" {{ request('language') == 'Arabic' ? 'selected' : '' }}>Arabic</option>
                    <option value="Russian" {{ request('language') == 'Russian' ? 'selected' : '' }}>Russian</option>
                    <option value="German" {{ request('language') == 'German' ? 'selected' : '' }}>German</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-dark btn-sm flex-grow-1">Filter</button>
                @if(request()->hasAny(['search', 'area', 'language']))
                    <a href="{{ url('/agents') }}" class="btn btn-outline-secondary btn-sm" title="Clear Filters"><i class="fa-solid fa-rotate-left"></i></a>
                @endif
            </div>
        </form>
    </div>
</div>

<section class="py-5" style="background-color: #f9f9f9;">
    <div class="container px-md-4">
        @php
            $list = isset($agents) && $agents->isNotEmpty() ? $agents : (isset($agent) && $agent->isNotEmpty() ? $agent : collect());
        @endphp

        @if($list->count() > 0)
            <div class="row g-4">
                @foreach($list as $broker)
                    <div class="col-lg-4 col-md-6">
                        <div class="broker-card p-4">
                            @if(Str::contains(strtolower($broker->slug), 'graeme') || Str::contains(strtolower($broker->name), 'graeme'))
                                <span class="featured-ribbon">
                                    <i class="fa-solid fa-star me-1"></i> Featured Advisor
                                </span>
                            @endif

                            <div class="text-center">
                                @if($broker->image)
                                    <img src="{{ asset('images/media/profile/' . $broker->image) }}" class="broker-avatar" alt="{{ $broker->name }}">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($broker->name) }}&background=111111&color=b38b47&size=200" class="broker-avatar" alt="{{ $broker->name }}">
                                @endif

                                @if($broker->brn)
                                    <div class="mb-2">
                                        <span class="brn-badge"><i class="fa-solid fa-certificate me-1"></i> BRN #{{ $broker->brn }}</span>
                                    </div>
                                @endif

                                <h4 class="fw-bold text-dark mb-1" style="font-family: serif;">
                                    <a href="{{ url('agents', $broker->slug) }}" class="text-dark text-decoration-none">
                                        {{ $broker->name }}
                                    </a>
                                </h4>
                                <p class="text-muted small mb-2">{{ $broker->occupation ?? 'Luxury Property Advisor' }}</p>

                                @if($broker->nationality)
                                    <p class="text-secondary small mb-2"><i class="fa-solid fa-earth-americas me-1 text-warning"></i> {{ $broker->nationality }}</p>
                                @endif

                                <div class="p-2 my-3 rounded" style="background: #f4f4f4; font-size: 12px;">
                                    <div class="row g-1 text-center">
                                        <div class="col-12">
                                            <span class="d-block text-muted">Experience</span>
                                            <strong class="text-dark">{{ $broker->experience ? Str::limit($broker->experience, 28) : 'Prime Dubai' }}</strong>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $langs = [];
                                    if (!empty($broker->language_multi_select)) {
                                        $decoded = is_string($broker->language_multi_select) ? json_decode($broker->language_multi_select, true) : $broker->language_multi_select;
                                        if (is_array($decoded)) {
                                            $langs = $decoded;
                                        }
                                    }
                                @endphp
                                @if(!empty($langs))
                                    <p class="text-muted small mb-3">
                                        <i class="fa-solid fa-language text-muted me-1"></i>
                                        Speaks: {{ implode(', ', $langs) }}
                                    </p>
                                @endif
                            </div>

                            <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                <a href="{{ url('agents', $broker->slug) }}" class="broker-btn-profile">
                                    View Profile & Stock
                                </a>
                                <div class="d-flex gap-2">
                                    @php
                                        $waNum = preg_replace('/[^0-9]/', '', $broker->whatsapp_no ?: '971569700771');
                                        $waMsg = urlencode('Hello ' . $broker->name . ', I am inquiring about Dubai luxury properties through Elite Evolution.');
                                    @endphp
                                    <a href="https://api.whatsapp.com/send?phone={{ $waNum }}&text={{ $waMsg }}" target="_blank" class="broker-btn-wa" title="WhatsApp Broker">
                                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fa-solid fa-user-tie fa-3x text-muted mb-3"></i>
                <h3 class="fw-bold">No Licensed Brokers Found</h3>
                <p class="text-muted">No brokers matched your filter criteria. Try clearing your filters or contact our concierge.</p>
                <a href="{{ url('/agents') }}" class="btn btn-dark mt-2">View All Brokers</a>
            </div>
        @endif
    </div>
</section>
@endsection
