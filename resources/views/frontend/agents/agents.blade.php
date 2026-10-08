@extends('frontend.layouts.master')
@section('title')
    Licensed Real Estate Brokers | Elite Evolution Real Estate Dubai
@endsection

@section('meta_title')
    Meet Our Licensed Dubai Real Estate Brokers | Elite Evolution
@endsection

@section('meta_description')
    Connect with Elite Evolution's DLD-registered real estate advisors. Certified luxury specialists for Palm Jumeirah, Emirates Hills, and exclusive off-plan developments.
@endsection

@section('content')
<style>
    .broker-banner {
        background: linear-gradient(rgba(10, 10, 10, 0.75), rgba(10, 10, 10, 0.75)), url('{{ asset("frontend/img/banner-bg.jpg") }}') center/cover no-repeat;
        padding: 90px 0 60px;
        color: #fff;
        text-align: center;
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
    }
    .broker-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.08);
    }
    .broker-avatar {
        width: 140px;
        height: 140px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #b38b47;
        margin: 25px auto 15px;
        display: block;
    }
    .brn-badge {
        background: #f5ede1;
        color: #8b6528;
        font-weight: 600;
        font-size: 12px;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-block;
        letter-spacing: 0.5px;
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
    }
    .broker-btn-profile:hover {
        background-color: #b38b47;
    }
</style>

<section class="broker-banner">
    <div class="container">
        <span class="text-uppercase" style="letter-spacing: 3px; color: #b38b47; font-size: 13px; font-weight: 600;">DLD Registered & Certified</span>
        <h1 class="fw-bold mt-2 mb-3" style="font-family: serif; letter-spacing: 1px;">MEET OUR LICENSED BROKERS</h1>
        <p class="text-white-50 mx-auto" style="max-width: 650px;">
            Elite Evolution represents private clients, international investors, and family offices with integrity, discreet counsel, and deep market intelligence across Dubai.
        </p>
    </div>
</section>

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

                                <h4 class="fw-bold text-dark mb-1" style="font-family: serif;">{{ $broker->name }}</h4>
                                <p class="text-muted small mb-2">{{ $broker->occupation ?? 'Luxury Property Advisor' }}</p>

                                @if($broker->nationality)
                                    <p class="text-secondary small mb-2"><i class="fa-solid fa-earth-americas me-1 text-warning"></i> {{ $broker->nationality }}</p>
                                @endif

                                <div class="p-2 my-3 rounded" style="background: #f4f4f4; font-size: 12px;">
                                    <div class="row g-1 text-center">
                                        <div class="col-6 border-end">
                                            <span class="d-block text-muted">Active Listings</span>
                                            <strong class="text-dark">{{ $broker->active_listings_count ?? $broker->properties()->where('status', 1)->count() }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <span class="d-block text-muted">Experience</span>
                                            <strong class="text-dark">{{ $broker->experience ? Str::limit($broker->experience, 15) : 'Prime Dubai' }}</strong>
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
                                    View Listings
                                </a>
                                <div class="d-flex gap-2">
                                    @if($broker->whatsapp_no)
                                        <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/[^0-9]/', '', $broker->whatsapp_no) }}&text={{ urlencode('Hello ' . $broker->name . ', I am inquiring about Dubai luxury properties through Elite Evolution.') }}" target="_blank" class="broker-btn-wa" title="WhatsApp Broker">
                                            <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                        </a>
                                    @elseif($broker->phone)
                                        <a href="tel:{{ $broker->phone }}" class="btn btn-outline-dark btn-sm">
                                            <i class="fa-solid fa-phone"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fa-solid fa-user-tie fa-3x text-muted mb-3"></i>
                <h3 class="fw-bold">No Licensed Brokers Currently Listed</h3>
                <p class="text-muted">Please contact our central concierge desk for private advisory.</p>
                <a href="{{ url('/contact') }}" class="btn btn-dark mt-2">Contact Brokerage</a>
            </div>
        @endif
    </div>
</section>
@endsection
