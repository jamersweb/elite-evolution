@extends('frontend.layouts.master')

@section('title')
    {{ $agent->name }} - Licensed Real Estate Advisor | Elite Evolution Real Estate Dubai
@endsection

@section('meta_title')
    {{ $agent->name }} | DLD Licensed Real Estate Broker (BRN #{{ $agent->brn ?? '78334' }}) Dubai
@endsection

@section('meta_description')
    Connect with {{ $agent->name }} (BRN #{{ $agent->brn ?? '78334' }}), Senior Real Estate Advisor at Elite Evolution Real Estate Dubai. Specializing in Palm Jumeirah, DAMAC Lagoons, and prime luxury properties.
@endsection

@section('content')
<style>
    .broker-detail-hero {
        background: radial-gradient(circle at top right, #1f1f1f 0%, #0d0d0d 100%);
        color: #fff;
        padding: 55px 0 45px;
        position: relative;
        border-bottom: 2px solid #b38b47;
    }
    .agent-avatar-wrap {
        position: relative;
        display: inline-block;
    }
    .agent-avatar {
        width: 190px;
        height: 190px;
        border-radius: 50%;
        border: 4px solid #b38b47;
        object-fit: cover;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }
    .badge-verified-seal {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: #25D366;
        color: #fff;
        border-radius: 50%;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid #111;
        font-size: 16px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
    .brn-pill {
        background: linear-gradient(135deg, #b38b47 0%, #8b6528 100%);
        color: #fff;
        font-weight: 700;
        font-size: 13px;
        padding: 5px 14px;
        border-radius: 30px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        letter-spacing: 0.5px;
    }
    .btn-wa-action {
        background-color: #25D366;
        color: #fff !important;
        font-weight: 700;
        font-size: 14px;
        border-radius: 6px;
        padding: 11px 20px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(37, 211, 102, 0.3);
    }
    .btn-wa-action:hover {
        background-color: #1eb956;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.45);
    }
    .btn-call-action {
        background-color: transparent;
        color: #fff !important;
        border: 1px solid rgba(255,255,255,0.4);
        font-weight: 600;
        font-size: 14px;
        border-radius: 6px;
        padding: 10px 18px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.25s ease;
    }
    .btn-call-action:hover {
        background-color: #fff;
        color: #111 !important;
    }
    .btn-vcard-action {
        background-color: rgba(179, 139, 71, 0.15);
        color: #e5c378 !important;
        border: 1px solid #b38b47;
        font-weight: 600;
        font-size: 13px;
        border-radius: 6px;
        padding: 8px 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-vcard-action:hover {
        background-color: #b38b47;
        color: #fff !important;
    }
    .stat-box {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        padding: 12px 18px;
        text-align: center;
    }
    .stat-number {
        font-size: 22px;
        font-weight: 700;
        color: #b38b47;
        font-family: serif;
    }
    .stat-label {
        font-size: 11px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.6);
        letter-spacing: 0.5px;
    }
    .listing-card-premium {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .listing-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
    }
    .listing-thumb {
        width: 100%;
        height: 230px;
        object-fit: cover;
    }
    .mobile-sticky-bar {
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #111;
        border-top: 2px solid #b38b47;
        padding: 10px 16px;
        z-index: 1050;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.3);
    }
    @media (max-width: 768px) {
        .mobile-sticky-bar {
            display: flex;
            gap: 8px;
        }
        body {
            padding-bottom: 60px;
        }
    }
</style>

<!-- Hero Section -->
<section class="broker-detail-hero">
    <div class="container">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small text-white-50 m-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/agents') }}" class="text-white-50 text-decoration-none">Brokers & Agents</a></li>
                <li class="breadcrumb-item active text-warning" aria-current="page">{{ $agent->name }}</li>
            </ol>
        </nav>

        <div class="row align-items-center g-4">
            <div class="col-lg-3 col-md-4 text-center">
                <div class="agent-avatar-wrap">
                    @if($agent->image)
                        <img src="{{ asset('images/media/profile/' . $agent->image) }}" class="agent-avatar" alt="{{ $agent->name }}">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($agent->name) }}&background=222222&color=b38b47&size=250" class="agent-avatar" alt="{{ $agent->name }}">
                    @endif
                    <div class="badge-verified-seal" title="DLD Licensed & Verified">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-8">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <span class="brn-pill">
                        <i class="fa-solid fa-certificate"></i> RERA BRN #{{ $agent->brn ?? '78334' }}
                    </span>
                    <span class="badge bg-dark border border-secondary text-white-50 px-3 py-2 rounded-pill">
                        <i class="fa-solid fa-shield-halved text-warning me-1"></i> DLD Licensed Broker
                    </span>
                    <span class="badge bg-dark border border-secondary text-white-50 px-3 py-2 rounded-pill">
                        <i class="fa-solid fa-building me-1 text-warning"></i> Elite Evolution Real Estate
                    </span>
                </div>

                <h1 class="display-6 fw-bold text-white mb-1" style="font-family: serif; letter-spacing: 0.5px;">{{ $agent->name }}</h1>
                <p class="text-warning fs-5 mb-3">{{ $agent->occupation ?? 'Senior Luxury Property Advisor' }}</p>

                <!-- Stat Counters -->
                <div class="row g-2 mb-3" style="max-width: 520px;">
                    <div class="col-4">
                        <div class="stat-box">
                            <div class="stat-number">{{ $properties->total() ?? $properties->count() }}</div>
                            <div class="stat-label">Active Listings</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-box">
                            <div class="stat-number">{{ Str::contains($agent->experience, '8') ? '8+' : '6+' }}</div>
                            <div class="stat-label">Years Exp.</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-box">
                            <div class="stat-number">100%</div>
                            <div class="stat-label">Verified Stock</div>
                        </div>
                    </div>
                </div>

                <p class="text-white-50 small mb-0">
                    <i class="fa-solid fa-location-dot me-1 text-warning"></i> Saeed Haseeb Building, Port Saeed, Deira, Dubai, UAE
                </p>
            </div>

            <div class="col-lg-3 text-center text-lg-end">
                <div class="d-flex flex-column gap-2" style="max-width: 260px; margin: 0 auto 0 auto;">
                    @php
                        $waNumber = preg_replace('/[^0-9]/', '', $agent->whatsapp_no ?: '971569700771');
                        $waText = urlencode('Hello ' . $agent->name . ', I am inquiring about Dubai luxury properties on Elite Evolution.');
                    @endphp
                    <a href="https://api.whatsapp.com/send?phone={{ $waNumber }}&text={{ $waText }}" target="_blank" class="btn-wa-action">
                        <i class="fa-brands fa-whatsapp fs-5"></i> WhatsApp Advisor
                    </a>

                    @if($agent->phone)
                        <a href="tel:{{ $agent->phone }}" class="btn-call-action">
                            <i class="fa-solid fa-phone"></i> Call {{ $agent->phone }}
                        </a>
                    @endif

                    <div class="d-flex gap-2">
                        <a href="{{ url('agents/' . $agent->slug . '/vcard') }}" class="btn-vcard-action flex-grow-1" title="Download Contact Card">
                            <i class="fa-solid fa-address-card"></i> Save Contact
                        </a>
                        <button type="button" class="btn btn-outline-light btn-sm px-3" onclick="shareAgentProfile()" title="Share Profile">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-5" style="background-color: #f7f7f7;">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Sidebar Credentials & Advisory Form -->
            <div class="col-lg-4">
                <!-- Credentials Card -->
                <div class="bg-white p-4 rounded shadow-sm mb-4 border">
                    <h5 class="fw-bold mb-3 pb-2 border-bottom" style="font-family: serif; color: #111;">
                        <i class="fa-solid fa-award text-warning me-2"></i> Official Credentials
                    </h5>
                    <ul class="list-unstyled mb-0 small">
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">License Authority</span>
                            <span class="fw-semibold text-dark">Dubai Land Department (DLD)</span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">RERA BRN Number</span>
                            <span class="fw-bold text-dark font-monospace">#{{ $agent->brn ?? '78334' }}</span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Market Experience</span>
                            <span class="fw-semibold text-dark">{{ $agent->experience ?? '8+ Years Prime Dubai' }}</span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Nationality</span>
                            <span class="fw-semibold text-dark">{{ $agent->nationality ?? 'British' }}</span>
                        </li>
                        @php
                            $languages = [];
                            if (!empty($agent->language_multi_select)) {
                                $decoded = is_string($agent->language_multi_select) ? json_decode($agent->language_multi_select, true) : $agent->language_multi_select;
                                if (is_array($decoded)) {
                                    $languages = $decoded;
                                }
                            }
                        @endphp
                        @if(!empty($languages))
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Languages</span>
                                <span class="fw-semibold text-dark">{{ implode(', ', $languages) }}</span>
                            </li>
                        @endif

                        @php
                            $areas = [];
                            if (!empty($agent->area_tags)) {
                                $decoded = is_string($agent->area_tags) ? json_decode($agent->area_tags, true) : $agent->area_tags;
                                if (is_array($decoded)) {
                                    $areas = $decoded;
                                }
                            }
                        @endphp
                        @if(!empty($areas))
                            <li class="pt-3">
                                <span class="text-muted d-block mb-2 fw-semibold">Specialized Enclaves:</span>
                                <div>
                                    @foreach($areas as $area)
                                        <span class="badge bg-light text-dark border me-1 mb-1 px-2 py-1">{{ $area }}</span>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>

                <!-- Bio Card -->
                @if($agent->about)
                    <div class="bg-white p-4 rounded shadow-sm mb-4 border">
                        <h5 class="fw-bold mb-3 pb-2 border-bottom" style="font-family: serif; color: #111;">
                            <i class="fa-solid fa-user text-warning me-2"></i> About {{ $agent->name }}
                        </h5>
                        <p class="text-muted small leading-relaxed mb-0" style="line-height: 1.7;">
                            {{ $agent->about }}
                        </p>
                    </div>
                @endif

                <!-- Direct Advisory Inquiry Form -->
                <div class="bg-white p-4 rounded shadow-sm border">
                    <h5 class="fw-bold mb-1" style="font-family: serif; color: #111;">Request Private Consultation</h5>
                    <p class="text-muted small mb-3">Connect directly with {{ $agent->name }} for off-market access and private viewings.</p>

                    <form action="{{ url('agents/' . $agent->slug . '/inquire') }}" method="POST">
                        @csrf
                        <!-- Honeypot anti-spam -->
                        <div style="display:none;">
                            <input type="text" name="hp_contact_check" value="">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">Full Name *</label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Your name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">Email Address *</label>
                            <input type="email" name="email" class="form-control form-control-sm" placeholder="name@domain.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">WhatsApp / Phone *</label>
                            <input type="tel" name="phone" class="form-control form-control-sm" placeholder="+971 50 000 0000" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-muted">Inquiry Details</label>
                            <textarea name="message" class="form-control form-control-sm" rows="3" placeholder="Tell {{ $agent->name }} about your preferred areas, budget, or specific properties..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 btn-sm py-2 text-uppercase fw-semibold" style="letter-spacing: 0.5px;">
                            <i class="fa-solid fa-paper-plane me-1"></i> Send Direct Inquiry
                        </button>
                    </form>
                </div>
            </div>

            <!-- Active Listings Showcase -->
            <div class="col-lg-8">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <div>
                        <h4 class="fw-bold mb-0" style="font-family: serif; color: #111;">Active Property Portfolio</h4>
                        <p class="text-muted small mb-0">{{ $properties->total() ?? $properties->count() }} Verified Listings Handled by {{ $agent->name }}</p>
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-2 mt-sm-0">
                        <span class="badge bg-warning text-dark"><i class="fa-solid fa-certificate me-1"></i> DLD Trakheesi Permitted</span>
                    </div>
                </div>

                @if($properties->count() > 0)
                    <div class="row g-4">
                        @foreach($properties as $property)
                            <div class="col-md-6">
                                <div class="listing-card-premium">
                                    <div class="position-relative">
                                        @if($property->featuredImage)
                                            <img src="{{ asset('images/media/' . $property->featuredImage->image) }}" class="listing-thumb" alt="{{ $property->title }}">
                                        @else
                                            <img src="{{ asset('management/images/11.png') }}" class="listing-thumb" alt="{{ $property->title }}">
                                        @endif

                                        <span class="badge bg-dark position-absolute top-0 start-0 m-3 text-uppercase font-monospace small">
                                            {{ $property->completion_status ?? ($property->type == 'rent' ? 'Luxury Rental' : 'Ready') }}
                                        </span>

                                        @if($property->reference_no)
                                            <span class="badge bg-white text-dark shadow-sm position-absolute bottom-0 start-0 m-2 font-monospace small">
                                                Ref: {{ $property->reference_no }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="p-3 d-flex flex-column flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-baseline mb-2">
                                            <span class="text-uppercase small text-muted fw-semibold">{{ $property->property_type }}</span>
                                            <h5 class="fw-bold text-dark mb-0 font-monospace">
                                                @if($property->type == 'rent')
                                                    AED {{ number_format($property->yearly_rent ?: $property->price) }}<small class="text-muted fs-6">/yr</small>
                                                @else
                                                    AED {{ number_format($property->price) }}
                                                @endif
                                            </h5>
                                        </div>

                                        <h6 class="fw-bold mb-1">
                                            <a href="{{ url('detail', $property->slug) }}" class="text-dark text-decoration-none">
                                                {{ Str::limit($property->title, 42) }}
                                            </a>
                                        </h6>

                                        <p class="text-muted small mb-3">
                                            <i class="fa-solid fa-location-dot me-1 text-warning"></i>
                                            {{ $property->community ?? $property->address }}
                                        </p>

                                        <div class="d-flex justify-content-between text-muted small py-2 border-top border-bottom mt-auto mb-3">
                                            <span><i class="fa-solid fa-bed me-1"></i> {{ $property->bedrooms }} Beds</span>
                                            <span><i class="fa-solid fa-bath me-1"></i> {{ $property->bathrooms }} Baths</span>
                                            <span><i class="fa-solid fa-ruler-combined me-1"></i> {{ $property->size }}</span>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <a href="{{ url('detail', $property->slug) }}" class="btn btn-outline-dark btn-sm flex-grow-1">
                                                View Details
                                            </a>
                                            @php
                                                $propWaText = urlencode('Hello ' . $agent->name . ', I am inquiring about ' . $property->title . ' (Ref: ' . $property->reference_no . ') on Elite Evolution.');
                                            @endphp
                                            <a href="https://api.whatsapp.com/send?phone={{ $waNumber }}&text={{ $propWaText }}" target="_blank" class="btn btn-success btn-sm px-3" title="WhatsApp about this listing">
                                                <i class="fa-brands fa-whatsapp"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if(method_exists($properties, 'links'))
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $properties->links() }}
                        </div>
                    @endif
                @else
                    <div class="bg-white p-5 rounded text-center border">
                        <i class="fa-solid fa-house-chimney fa-3x text-muted mb-3"></i>
                        <h5 class="fw-bold">Exclusive Off-Market & Private Inventory</h5>
                        <p class="text-muted mb-3">
                            {{ $agent->name }} manages prime confidential listings on Palm Jumeirah and DAMAC Lagoons. Contact directly for private portfolio access.
                        </p>
                        <a href="https://api.whatsapp.com/send?phone={{ $waNumber }}&text={{ $waText }}" target="_blank" class="btn btn-success btn-sm px-4">
                            <i class="fa-brands fa-whatsapp me-1"></i> WhatsApp {{ $agent->name }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Mobile Sticky Quick Bar -->
<div class="mobile-sticky-bar">
    <a href="https://api.whatsapp.com/send?phone={{ $waNumber }}&text={{ $waText }}" target="_blank" class="btn btn-success btn-sm flex-grow-1 fw-bold">
        <i class="fa-brands fa-whatsapp me-1"></i> WhatsApp
    </a>
    @if($agent->phone)
        <a href="tel:{{ $agent->phone }}" class="btn btn-light btn-sm flex-grow-1 fw-bold">
            <i class="fa-solid fa-phone me-1"></i> Call
        </a>
    @endif
    <a href="{{ url('agents/' . $agent->slug . '/vcard') }}" class="btn btn-outline-light btn-sm">
        <i class="fa-solid fa-address-card"></i>
    </a>
</div>

<script>
function shareAgentProfile() {
    const shareData = {
        title: '{{ $agent->name }} - Elite Evolution Real Estate',
        text: 'Licensed Real Estate Advisor at Elite Evolution Real Estate Dubai.',
        url: window.location.href,
    };
    if (navigator.share) {
        navigator.share(shareData).catch((err) => console.log('Share canceled', err));
    } else {
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Advisor profile link copied to clipboard!');
        });
    }
}
</script>
@endsection
