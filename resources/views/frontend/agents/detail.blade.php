@extends('frontend.layouts.master')

@section('title')
    {{ $agent->meta_title ?: $agent->name . ' - Licensed Real Estate Broker | Elite Evolution' }}
@endsection

@section('meta_title')
    {{ $agent->meta_title ?: $agent->name . ' | DLD Licensed Advisor Dubai' }}
@endsection

@section('meta_description')
    {{ $agent->meta_description ?: 'Explore luxury properties represented by ' . $agent->name . ' (BRN #' . ($agent->brn ?? 'Certified') . ') at Elite Evolution Real Estate Dubai.' }}
@endsection

@section('content')
<style>
    .broker-header {
        background: #111;
        color: #fff;
        padding: 50px 0 40px;
    }
    .agent-detail-avatar {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        border: 4px solid #b38b47;
        object-fit: cover;
    }
    .badge-brn {
        background: #b38b47;
        color: #fff;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
        display: inline-block;
    }
    .btn-luxury-wa {
        background-color: #25D366;
        color: #fff !important;
        font-weight: 600;
        border-radius: 4px;
        padding: 10px 20px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-luxury-wa:hover {
        background-color: #1eb956;
    }
    .listing-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .listing-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }
    .listing-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }
</style>

<div class="broker-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 text-center mb-4 mb-md-0">
                @if($agent->image)
                    <img src="{{ asset('images/media/profile/' . $agent->image) }}" class="agent-detail-avatar" alt="{{ $agent->name }}">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($agent->name) }}&background=222222&color=b38b47&size=200" class="agent-detail-avatar" alt="{{ $agent->name }}">
                @endif
            </div>
            <div class="col-lg-6 col-md-5">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge-brn"><i class="fa-solid fa-shield-halved me-1"></i> BRN #{{ $agent->brn ?? 'Certified Broker' }}</span>
                    <span class="badge bg-secondary text-white px-3 py-2 rounded-pill">DLD Verified</span>
                </div>
                <h1 class="fw-bold text-white mb-1" style="font-family: serif;">{{ $agent->name }}</h1>
                <p class="text-warning mb-2 fs-5">{{ $agent->occupation ?? 'Senior Luxury Property Advisor' }}</p>
                <p class="text-white-50 small mb-0"><i class="fa-solid fa-building me-1"></i> Elite Evolution Real Estate Dubai</p>
            </div>
            <div class="col-lg-3 col-md-3 text-md-end text-start mt-3 mt-md-0">
                @if($agent->whatsapp_no)
                    <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/[^0-9]/', '', $agent->whatsapp_no) }}&text={{ urlencode('Hello ' . $agent->name . ', I would like to inquire about your Dubai luxury property portfolio.') }}" target="_blank" class="btn-luxury-wa d-inline-block w-100 text-center mb-2">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp Advisor
                    </a>
                @endif
                @if($agent->phone)
                    <a href="tel:{{ $agent->phone }}" class="btn btn-outline-light w-100 mb-2">
                        <i class="fa-solid fa-phone me-1"></i> Call Broker
                    </a>
                @endif
                @if($agent->email)
                    <a href="mailto:{{ $agent->email }}" class="btn btn-sm btn-link text-white-50 text-decoration-none d-block text-center">
                        <i class="fa-solid fa-envelope me-1"></i> {{ $agent->email }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<section class="py-5" style="background-color: #f7f7f7;">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar Bio & Credentials -->
            <div class="col-lg-4">
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <h5 class="fw-bold mb-3 pb-2 border-bottom" style="font-family: serif;">Broker Credentials</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">License Type</span>
                            <span class="fw-semibold text-dark">DLD Broker</span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">RERA BRN#</span>
                            <span class="fw-bold text-dark">{{ $agent->brn ?? 'Registered' }}</span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Experience</span>
                            <span class="fw-semibold text-dark">{{ $agent->experience ?? 'Prime Dubai Market' }}</span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Nationality</span>
                            <span class="fw-semibold text-dark">{{ $agent->nationality ?? 'International' }}</span>
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
                            <li class="py-2">
                                <span class="text-muted d-block mb-1">Focus Communities</span>
                                <div>
                                    @foreach($areas as $area)
                                        <span class="badge bg-light text-dark border me-1 mb-1">{{ $area }}</span>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>

                @if($agent->about)
                    <div class="bg-white p-4 rounded shadow-sm">
                        <h5 class="fw-bold mb-3 pb-2 border-bottom" style="font-family: serif;">About {{ $agent->name }}</h5>
                        <p class="text-muted small leading-relaxed mb-0">
                            {{ $agent->about }}
                        </p>
                    </div>
                @endif
            </div>

            <!-- Agent Listings -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-0" style="font-family: serif;">Active Portfolio</h4>
                        <p class="text-muted small mb-0">{{ $properties->total() ?? $properties->count() }} Verified Listings</p>
                    </div>
                </div>

                @if($properties->count() > 0)
                    <div class="row g-4">
                        @foreach($properties as $property)
                            <div class="col-md-6">
                                <div class="listing-card">
                                    <div class="position-relative">
                                        @if($property->featuredImage)
                                            <img src="{{ asset('images/media/' . $property->featuredImage->image) }}" class="listing-img" alt="{{ $property->title }}">
                                        @else
                                            <img src="{{ asset('management/images/11.png') }}" class="listing-img" alt="{{ $property->title }}">
                                        @endif

                                        <span class="badge bg-dark position-absolute top-0 start-0 m-3 text-uppercase">
                                            {{ $property->completion_status ?? ($property->type == 'rent' ? 'Luxury Rental' : 'Ready') }}
                                        </span>

                                        @if($property->reference_no)
                                            <span class="badge bg-light text-dark position-absolute bottom-0 start-0 m-2 font-monospace small">
                                                Ref: {{ $property->reference_no }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="p-3 d-flex flex-column flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-baseline mb-2">
                                            <span class="text-uppercase small text-muted">{{ $property->property_type }}</span>
                                            <h5 class="fw-bold text-dark mb-0">
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
                                            @if($agent->whatsapp_no)
                                                <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/[^0-9]/', '', $agent->whatsapp_no) }}&text={{ urlencode('Hello ' . $agent->name . ', I am inquiring about ' . $property->title . ' (Ref: ' . $property->reference_no . ')') }}" target="_blank" class="btn btn-success btn-sm" title="WhatsApp about this property">
                                                    <i class="fa-brands fa-whatsapp"></i>
                                                </a>
                                            @endif
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
                    <div class="bg-white p-5 rounded text-center">
                        <i class="fa-solid fa-house-chimney fa-3x text-muted mb-3"></i>
                        <h5>No Active Listings Currently Assigned</h5>
                        <p class="text-muted">New exclusive properties will appear here shortly.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
