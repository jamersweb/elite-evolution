@extends('frontend.layouts.master')

@section('title')
    {{ $pageTitle ?? 'Luxury Properties in Dubai' }} | Elite Evolution Real Estate
@endsection

@section('meta_title')
    {{ $pageTitle ?? 'Properties for Sale and Rent in Dubai' }} | Elite Evolution
@endsection

@section('meta_description')
    {{ $pageSubtitle ?? 'Explore verified luxury properties in Dubai. Handpicked beachfront villas, luxury rentals, and iconic off-plan developments with DLD permit verification.' }}
@endsection

@section('content')
<style>
    .search-hero-bar {
        background: #111;
        padding: 30px 0;
        color: #fff;
    }
    .filter-card {
        background: #fff;
        border-radius: 8px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        margin-top: -20px;
        position: relative;
        z-index: 10;
        border: 1px solid #e8e8e8;
    }
    .prop-card-luxury {
        background: #fff;
        border: 1px solid #eaeaea;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .prop-card-luxury:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    }
    .prop-img-wrap {
        position: relative;
        height: 230px;
        overflow: hidden;
        background: #222;
    }
    .prop-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .prop-card-luxury:hover .prop-img {
        transform: scale(1.04);
    }
    .status-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #fff;
        z-index: 2;
    }
    .status-ready { background-color: #111; }
    .status-offplan { background-color: #8b6528; }
    .status-rental { background-color: #1d4ed8; }
    
    .ref-badge {
        position: absolute;
        bottom: 12px;
        left: 14px;
        background: rgba(0,0,0,0.65);
        color: #fff;
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 3px;
        font-family: monospace;
    }
    .btn-wa-gold {
        background-color: #25D366;
        color: #fff !important;
        font-size: 12px;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .btn-wa-gold:hover {
        background-color: #1eb956;
    }
    .filter-chip {
        display: inline-flex;
        align-items: center;
        background: #f0f0f0;
        color: #333;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 16px;
        margin-right: 6px;
        margin-bottom: 6px;
    }
    .filter-chip a {
        color: #777;
        margin-left: 6px;
        text-decoration: none;
    }
    .filter-chip a:hover {
        color: #000;
    }
</style>

<!-- Top Title Bar -->
<div class="search-hero-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="text-uppercase" style="letter-spacing: 2px; color: #b38b47; font-size: 12px; font-weight: 600;">Dubai Luxury Real Estate</span>
                <h1 class="fw-bold mt-1 mb-1" style="font-family: serif;">{{ $pageTitle ?? 'Properties in Dubai' }}</h1>
                <p class="text-white-50 small mb-0">{{ $pageSubtitle ?? 'Exclusive portfolio of verified luxury residences and premier investments' }}</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="btn-group">
                    <a href="{{ url('listing', $slug) }}" class="btn btn-sm btn-outline-light active"><i class="fa-solid fa-list me-1"></i> List View</a>
                    <a href="{{ url('map-view') }}" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-map-location-dot me-1"></i> Map View</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <!-- Filter Box -->
    <div class="filter-card">
        <form action="{{ url('listing', $slug) }}" method="get" id="filterForm">
            <div class="row g-3">
                <!-- Location Search -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-bold text-dark">Location / Community</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-location-dot text-muted"></i></span>
                        <input type="text" name="location" class="form-control border-start-0" placeholder="e.g. Palm Jumeirah, Emirates Hills" value="{{ request('location') }}">
                    </div>
                </div>

                <!-- Purpose / Completion -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-bold text-dark">Purpose / Status</label>
                    <select name="completion_status" class="form-select">
                        <option value="">Any Status</option>
                        <option value="Ready" {{ request('completion_status') == 'Ready' || $slug == 'ready' ? 'selected' : '' }}>Ready (Completed)</option>
                        <option value="Off-plan" {{ request('completion_status') == 'Off-plan' || $slug == 'off-plan' ? 'selected' : '' }}>Off-plan Projects</option>
                    </select>
                </div>

                <!-- Property Type -->
                <div class="col-lg-2 col-md-4">
                    <label class="form-label small fw-bold text-dark">Property Type</label>
                    <select name="property_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="Villa" {{ request('property_type') == 'Villa' ? 'selected' : '' }}>Villa</option>
                        <option value="Penthouse" {{ request('property_type') == 'Penthouse' ? 'selected' : '' }}>Penthouse</option>
                        <option value="Apartment" {{ request('property_type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                        <option value="Townhouse" {{ request('property_type') == 'Townhouse' ? 'selected' : '' }}>Townhouse</option>
                        <option value="Mansion" {{ request('property_type') == 'Mansion' ? 'selected' : '' }}>Mansion</option>
                    </select>
                </div>

                <!-- Bedrooms -->
                <div class="col-lg-2 col-md-4">
                    <label class="form-label small fw-bold text-dark">Bedrooms</label>
                    <select name="bedrooms" class="form-select">
                        <option value="">Any Beds</option>
                        <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1 Bed</option>
                        <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2 Beds</option>
                        <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3 Beds</option>
                        <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4 Beds</option>
                        <option value="5" {{ request('bedrooms') == '5' ? 'selected' : '' }}>5 Beds</option>
                        <option value="6+" {{ request('bedrooms') == '6+' ? 'selected' : '' }}>6+ Beds</option>
                    </select>
                </div>

                <!-- Min Price -->
                <div class="col-lg-3 col-md-4">
                    <label class="form-label small fw-bold text-dark">Price Range (AED)</label>
                    <div class="d-flex gap-2">
                        <input type="number" name="min_price" class="form-control" placeholder="Min Price" value="{{ request('min_price') }}">
                        <input type="number" name="max_price" class="form-control" placeholder="Max Price" value="{{ request('max_price') }}">
                    </div>
                </div>

                <!-- Sort & Actions -->
                <div class="col-lg-9 col-md-8 d-flex align-items-center flex-wrap gap-2 pt-2">
                    <span class="small fw-bold text-muted me-2">Quick Filter:</span>
                    <a href="{{ url('listing/ready') }}" class="btn btn-sm {{ $slug == 'ready' ? 'btn-dark' : 'btn-outline-secondary' }}">Buy Ready</a>
                    <a href="{{ url('listing/off-plan') }}" class="btn btn-sm {{ $slug == 'off-plan' ? 'btn-dark' : 'btn-outline-secondary' }}">Buy Off-Plan</a>
                    <a href="{{ url('luxury-rentals') }}" class="btn btn-sm {{ $slug == 'luxury-rentals' ? 'btn-dark' : 'btn-outline-secondary' }}">Luxury Rentals</a>
                    <a href="{{ url('listing/sale') }}?property_type=Villa" class="btn btn-sm btn-outline-secondary">Villas</a>
                    <a href="{{ url('listing/sale') }}?location=Palm+Jumeirah" class="btn btn-sm btn-outline-secondary">Palm Jumeirah</a>
                </div>

                <div class="col-lg-3 col-md-4 text-end pt-2">
                    <a href="{{ url('listing', $slug) }}" class="btn btn-outline-danger btn-sm me-1">Clear</a>
                    <button type="submit" class="btn btn-dark btn-sm px-4"><i class="fa-solid fa-magnifying-glass me-1"></i> Search</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Active Filters & Count Bar -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 mb-3">
        <div>
            <h5 class="fw-bold mb-1" style="font-family: serif;">
                Showing {{ $property->total() }} Properties
            </h5>
            <div class="d-flex flex-wrap align-items-center">
                @if(request('location'))
                    <span class="filter-chip">Location: {{ request('location') }} <a href="{{ request()->fullUrlWithQuery(['location' => null]) }}">&times;</a></span>
                @endif
                @if(request('bedrooms'))
                    <span class="filter-chip">Beds: {{ request('bedrooms') }} <a href="{{ request()->fullUrlWithQuery(['bedrooms' => null]) }}">&times;</a></span>
                @endif
                @if(request('property_type'))
                    <span class="filter-chip">Type: {{ request('property_type') }} <a href="{{ request()->fullUrlWithQuery(['property_type' => null]) }}">&times;</a></span>
                @endif
                @if(request('completion_status'))
                    <span class="filter-chip">Status: {{ request('completion_status') }} <a href="{{ request()->fullUrlWithQuery(['completion_status' => null]) }}">&times;</a></span>
                @endif
                @if(request('min_price'))
                    <span class="filter-chip">Min: AED {{ number_format(request('min_price')) }} <a href="{{ request()->fullUrlWithQuery(['min_price' => null]) }}">&times;</a></span>
                @endif
                @if(request('max_price'))
                    <span class="filter-chip">Max: AED {{ number_format(request('max_price')) }} <a href="{{ request()->fullUrlWithQuery(['max_price' => null]) }}">&times;</a></span>
                @endif
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
            <span class="small text-muted">Sort By:</span>
            <select name="sort" class="form-select form-select-sm w-auto" onchange="window.location.href = '{{ request()->fullUrlWithQuery(['sort' => '']) }}' + this.value">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Listings</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="row g-4">
        <!-- Listings Column -->
        <div class="col-lg-8">
            @if($property->count() > 0)
                <div class="row g-4">
                    @foreach($property as $item)
                        @php
                            $agentObj = $item->user;
                            $featured = $item->featuredImage;
                            $statusBadgeClass = 'status-ready';
                            $statusText = $item->completion_status ?? 'Ready';
                            if ($item->type == 'rent') {
                                $statusBadgeClass = 'status-rental';
                                $statusText = 'Luxury Rental';
                            } elseif ($item->completion_status == 'Off-plan' || $item->is_new_project) {
                                $statusBadgeClass = 'status-offplan';
                                $statusText = 'Off-plan';
                            }
                        @endphp
                        <div class="col-md-6">
                            <div class="prop-card-luxury">
                                <div class="prop-img-wrap">
                                    <a href="{{ url('detail', $item->slug) }}">
                                        @if($featured && $featured->image)
                                            <img src="{{ asset('images/media/' . $featured->image) }}" class="prop-img" alt="{{ $item->title }}">
                                        @else
                                            <img src="{{ asset('management/images/11.png') }}" class="prop-img" alt="{{ $item->title }}">
                                        @endif
                                    </a>

                                    <span class="status-badge {{ $statusBadgeClass }}">
                                        {{ $statusText }}
                                    </span>

                                    @if($item->reference_no)
                                        <span class="ref-badge">
                                            Ref: {{ $item->reference_no }}
                                        </span>
                                    @endif

                                    @if($item->trakheesi_permit_no)
                                        <span class="badge bg-success position-absolute top-0 end-0 m-2 font-monospace" style="font-size: 10px;" title="DLD Trakheesi Permit Verified">
                                            <i class="fa-solid fa-check-double me-1"></i> DLD Verified
                                        </span>
                                    @endif
                                </div>

                                <div class="p-3 d-flex flex-column flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-baseline mb-1">
                                        <span class="text-uppercase small text-muted">{{ $item->property_type }}</span>
                                        <h5 class="fw-bold text-dark mb-0" style="font-family: serif;">
                                            @if($item->type == 'rent')
                                                AED {{ number_format($item->yearly_rent ?: $item->price) }}<small class="text-muted fs-6">/year</small>
                                            @elseif($item->price)
                                                AED {{ number_format($item->price) }}
                                            @else
                                                <span class="fs-6 text-muted">Price on Request</span>
                                            @endif
                                        </h5>
                                    </div>

                                    <h6 class="fw-bold mb-1">
                                        <a href="{{ url('detail', $item->slug) }}" class="text-dark text-decoration-none">
                                            {{ Str::limit($item->title, 42) }}
                                        </a>
                                    </h6>

                                    <p class="text-muted small mb-3">
                                        <i class="fa-solid fa-location-dot me-1 text-warning"></i>
                                        {{ $item->community ?? $item->completesearch ?? 'Prime Dubai Address' }}
                                    </p>

                                    <div class="d-flex justify-content-between text-muted small py-2 border-top border-bottom mt-auto mb-3">
                                        <span><i class="fa-solid fa-bed me-1"></i> {{ $item->bedrooms }} Beds</span>
                                        <span><i class="fa-solid fa-bath me-1"></i> {{ $item->bathrooms }} Baths</span>
                                        <span><i class="fa-solid fa-ruler-combined me-1"></i> {{ $item->size }}</span>
                                    </div>

                                    <!-- Agent Attribution Bar -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-2">
                                            @if($agentObj && $agentObj->image)
                                                <img src="{{ asset('images/media/profile/' . $agentObj->image) }}" style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover;" alt="{{ $agentObj->name }}">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($agentObj ? $agentObj->name : 'Elite') }}&background=111&color=b38b47&size=68" style="width: 34px; height: 34px; border-radius: 50%;" alt="Agent">
                                            @endif
                                            <div>
                                                <small class="fw-bold d-block text-dark leading-tight">{{ $agentObj ? Str::limit($agentObj->name, 16) : 'Elite Advisor' }}</small>
                                                <small class="text-muted" style="font-size: 11px;">BRN #{{ $agentObj ? ($agentObj->brn ?? '52410') : 'Licensed' }}</small>
                                            </div>
                                        </div>

                                        <div class="d-flex gap-1">
                                            @if($agentObj && $agentObj->whatsapp_no)
                                                <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/[^0-9]/', '', $agentObj->whatsapp_no) }}&text={{ urlencode('Hello ' . $agentObj->name . ', I am inquiring about ' . $item->title . ' (Ref: ' . $item->reference_no . ')') }}" target="_blank" class="btn-wa-gold" title="WhatsApp Agent">
                                                    <i class="fa-brands fa-whatsapp"></i>
                                                </a>
                                            @endif
                                            <a href="{{ url('detail', $item->slug) }}" class="btn btn-outline-dark btn-sm">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{ $property->links() }}
                </div>
            @else
                <div class="bg-white p-5 rounded border text-center my-4">
                    <i class="fa-solid fa-house-chimney-crack fa-3x text-muted mb-3"></i>
                    <h4 class="fw-bold">No Matching Properties Found</h4>
                    <p class="text-muted mx-auto" style="max-width: 480px;">
                        We couldn't find listings matching your specific criteria. Try adjusting your filters or contact our concierge desk for off-market luxury inventory.
                    </p>
                    <a href="{{ url('listing', $slug) }}" class="btn btn-dark mt-2">Reset All Filters</a>
                </div>
            @endif
        </div>

        <!-- Right Sidebar (Real Community Landings & Popular Searches) -->
        <div class="col-lg-4">
            <!-- Popular Community Searches -->
            <div class="bg-white p-4 rounded border mb-4">
                <h6 class="fw-bold text-uppercase pb-2 border-bottom mb-3" style="font-family: serif; letter-spacing: 0.5px;">Prime Communities</h6>
                <div class="list-group list-group-flush">
                    <a href="{{ url('listing/sale') }}?location=Palm+Jumeirah" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0">
                        <span><i class="fa-solid fa-angles-right text-muted me-2 small"></i> Palm Jumeirah</span>
                        <span class="badge bg-light text-dark border">Villas & Mansions</span>
                    </a>
                    <a href="{{ url('listing/sale') }}?location=Jumeirah+Islands" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0">
                        <span><i class="fa-solid fa-angles-right text-muted me-2 small"></i> Jumeirah Islands</span>
                        <span class="badge bg-light text-dark border">Waterfront Living</span>
                    </a>
                    <a href="{{ url('listing/sale') }}?location=Emirates+Hills" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0">
                        <span><i class="fa-solid fa-angles-right text-muted me-2 small"></i> Emirates Hills</span>
                        <span class="badge bg-light text-dark border">Private Estates</span>
                    </a>
                    <a href="{{ url('listing/sale') }}?location=Palm+Jebel+Ali" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0">
                        <span><i class="fa-solid fa-angles-right text-muted me-2 small"></i> Palm Jebel Ali</span>
                        <span class="badge bg-light text-dark border">Off-Plan Growth</span>
                    </a>
                    <a href="{{ url('listing/sale') }}?location=Downtown+Dubai" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0">
                        <span><i class="fa-solid fa-angles-right text-muted me-2 small"></i> Downtown Dubai</span>
                        <span class="badge bg-light text-dark border">Penthouses</span>
                    </a>
                </div>
            </div>

            <!-- Categories / Purpose -->
            <div class="bg-white p-4 rounded border mb-4">
                <h6 class="fw-bold text-uppercase pb-2 border-bottom mb-3" style="font-family: serif; letter-spacing: 0.5px;">Curated Collections</h6>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ url('listing/ready') }}" class="text-decoration-none text-dark d-flex align-items-center justify-content-between py-1">
                        <span><i class="fa-solid fa-key text-warning me-2"></i> Move-in Ready Villas</span>
                        <i class="fa-solid fa-chevron-right text-muted small"></i>
                    </a>
                    <a href="{{ url('listing/off-plan') }}" class="text-decoration-none text-dark d-flex align-items-center justify-content-between py-1">
                        <span><i class="fa-solid fa-compass-drafting text-warning me-2"></i> Prime Off-Plan Projects</span>
                        <i class="fa-solid fa-chevron-right text-muted small"></i>
                    </a>
                    <a href="{{ url('luxury-rentals') }}" class="text-decoration-none text-dark d-flex align-items-center justify-content-between py-1">
                        <span><i class="fa-solid fa-gem text-warning me-2"></i> High-End Luxury Rentals</span>
                        <i class="fa-solid fa-chevron-right text-muted small"></i>
                    </a>
                    <a href="{{ url('agents') }}" class="text-decoration-none text-dark d-flex align-items-center justify-content-between py-1">
                        <span><i class="fa-solid fa-user-tie text-warning me-2"></i> Meet Our Licensed Brokers</span>
                        <i class="fa-solid fa-chevron-right text-muted small"></i>
                    </a>
                </div>
            </div>

            <!-- Concierge Box -->
            <div class="p-4 rounded text-white" style="background: linear-gradient(135deg, #111, #2a251e); border: 1px solid #b38b47;">
                <span class="text-uppercase small" style="color: #b38b47; font-weight: 600;">Private Client Desk</span>
                <h5 class="fw-bold mt-1 mb-2" style="font-family: serif;">Looking for Off-Market Inventory?</h5>
                <p class="text-white-50 small mb-3">
                    Many of our highest-tier beachfront villas and penthouses are held in private off-market collections for client discretion.
                </p>
                <a href="{{ url('contact') }}" class="btn btn-warning text-dark fw-bold btn-sm w-100">
                    Request Private Consultation
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
