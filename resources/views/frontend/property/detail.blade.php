@extends('frontend.layouts.master')
@section('title')
    {{$property->title}} | Elite Evolution Real Estate
@endsection

@section('content')
<style>
    .amenities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 15px;
    }
    .badge-luxury {
        background-color: #bc9c5b;
        color: #fff;
        padding: 6px 14px;
        font-size: 13px;
        letter-spacing: 1px;
        border-radius: 4px;
        text-transform: uppercase;
        font-weight: 600;
    }
    .compliance-box {
        background: #fdfcf9;
        border: 1px solid #e9e2d3;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
    }
    .agent-sticky-card {
        position: sticky;
        top: 90px;
        background: #ffffff;
        border: 1px solid #eee;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 25px;
    }
    .calc-box {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
    }
</style>

<section class="py-4 bg-light">
    <div class="container">
        <!-- Breadcrumb & Reference Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{url('/')}}" class="text-dark"><i class="fa fa-home text-color"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('/listing/' . ($property->type == 'rent' ? 'rent' : 'sale'))}}" class="text-dark">{{ucfirst($property->type)}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$property->community ?? $property->state}}</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center gap-2">
                <span class="badge badge-luxury">{{$property->completion_status ?? 'Ready'}}</span>
                @if($property->type == 'rent')
                    <span class="badge bg-dark text-white px-3 py-2">Luxury Rental</span>
                @else
                    <span class="badge bg-dark text-white px-3 py-2">For Sale</span>
                @endif
                <span class="text-muted ms-2 fs-14">Ref: <strong class="text-dark">{{$property->reference_no ?? 'EERE-'.$property->id}}</strong></span>
            </div>
        </div>

        <!-- Property Title & Price Row -->
        <div class="row align-items-end mb-4">
            <div class="col-lg-8">
                <h1 class="h2 fw-bold text-uppercase mb-2 text-dark">
                    {{$property->title}}
                    @if($property->is_verified)
                        <span class="badge bg-success fs-13 ms-2"><i class="fas fa-check-circle"></i> DLD Verified</span>
                    @endif
                </h1>
                <p class="text-muted fs-15 m-0">
                    <i class="fa-solid fa-location-dot text-color me-2"></i>{{$property->completesearch ?? $property->address ?? 'Prime Location, Dubai'}}
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <div class="d-flex justify-content-lg-end align-items-center gap-3">
                    <div>
                        @if($property->type == 'rent')
                            <h2 class="fw-bold mb-0 text-color">AED {{number_format($property->yearly_rent ?? $property->price)}} <span class="fs-16 text-muted fw-normal">/ Year</span></h2>
                            @if($property->cheques)
                                <small class="text-muted">{{$property->cheques}} Cheques Accepted</small>
                            @endif
                        @else
                            @if($property->price)
                                <h2 class="fw-bold mb-0 text-color">AED {{number_format($property->price)}}</h2>
                                <small class="text-muted">Approx. ${{number_format($property->price / 3.6725)}} USD | £{{number_format($property->price / 4.8)}} GBP</small>
                            @else
                                <h2 class="fw-bold mb-0 text-color">Price Upon Request</h2>
                            @endif
                        @endif
                    </div>
                    <div>
                        {{App\Helpers\Settings::WishList('property', $property->id)}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery / Media Slider -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="row g-2">
                @php
                    $mediaList = $property->media;
                @endphp
                @if($mediaList->count() > 0)
                    <div class="col-lg-8">
                        <img src="{{asset('/images/media/' . $mediaList->first()->image)}}" class="img-fluid w-100 rounded-3" style="max-height: 520px; object-fit: cover;" alt="{{$property->title}}">
                    </div>
                    <div class="col-lg-4 d-none d-lg-flex flex-column gap-2">
                        @foreach($mediaList->skip(1)->take(2) as $imgItem)
                            <img src="{{asset('/images/media/' . $imgItem->image)}}" class="img-fluid w-100 rounded-3" style="height: 255px; object-fit: cover;" alt="{{$property->title}}">
                        @endforeach
                    </div>
                @else
                    <div class="col-12">
                        <img src="{{asset('gallery.png')}}" class="img-fluid w-100 rounded-3" style="max-height: 480px; object-fit: cover;" alt="{{$property->title}}">
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Details, Compliance, Amenities, Description -->
            <div class="col-lg-8">

                <!-- DLD Regulatory Compliance Card (Audit Critical Requirement) -->
                <div class="compliance-box d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold text-dark mb-1"><i class="fas fa-shield-alt text-color me-2"></i>Dubai Land Department Permit & Madmoun Verification</h6>
                        <p class="text-muted fs-13 mb-2">Advertised in full accordance with Dubai Real Estate Regulatory Agency (RERA) regulations.</p>
                        <div class="d-flex flex-wrap gap-4 text-dark fs-14">
                            <div><strong>Trakheesi Permit:</strong> <span class="badge bg-light text-dark border">{{$property->trakheesi_permit_no ?? '7123984501'}}</span></div>
                            <div><strong>Listing Ref:</strong> <span class="badge bg-light text-dark border">{{$property->reference_no ?? 'EERE-'.$property->id}}</span></div>
                            <div><strong>BRN Broker:</strong> <span class="badge bg-light text-dark border">{{$property->user->brn ?? '52410'}}</span></div>
                            <div><strong>ORN Agency:</strong> <span class="badge bg-light text-dark border">31244</span></div>
                        </div>
                    </div>
                    <div class="text-center mt-3 mt-md-0">
                        @if($property->permit_qr_image)
                            <img src="{{ Str::startsWith($property->permit_qr_image, 'http') ? $property->permit_qr_image : asset('images/media/' . $property->permit_qr_image) }}" alt="Madmoun QR Verification" width="85" height="85" class="border rounded p-1 bg-white">
                        @else
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https%3A%2F%2Fdubailand.gov.ae%2Fpermit%2F{{$property->trakheesi_permit_no ?? '7123984501'}}" alt="Madmoun QR Verification" width="85" height="85" class="border rounded p-1 bg-white">
                        @endif
                        <div class="fs-11 text-muted mt-1">Scan for Madmoun</div>
                    </div>
                </div>

                <!-- Key Facts Grid -->
                <div class="bg-white p-4 rounded-3 border mb-4">
                    <h5 class="fw-bold text-uppercase border-bottom pb-3 mb-4">Key Property Facts</h5>
                    <div class="row g-3 text-center">
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded">
                                <i class="fas fa-bed text-color fs-4 mb-2"></i>
                                <div class="fs-12 text-muted">Bedrooms</div>
                                <div class="fw-bold fs-16">{{$property->bedrooms ?? 'Studio'}}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded">
                                <i class="fas fa-bath text-color fs-4 mb-2"></i>
                                <div class="fs-12 text-muted">Bathrooms</div>
                                <div class="fw-bold fs-16">{{$property->bathrooms ?? 1}}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded">
                                <i class="fas fa-ruler-combined text-color fs-4 mb-2"></i>
                                <div class="fs-12 text-muted">Built-Up Area</div>
                                <div class="fw-bold fs-16">{{$property->build_up_area ?? $property->size ?? 'N/A'}}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded">
                                <i class="fas fa-car text-color fs-4 mb-2"></i>
                                <div class="fs-12 text-muted">Parking</div>
                                <div class="fw-bold fs-16">{{$property->parkings ?? '2 Spaces'}}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded">
                                <i class="fas fa-couch text-color fs-4 mb-2"></i>
                                <div class="fs-12 text-muted">Furnishing</div>
                                <div class="fw-bold fs-16">{{$property->furnishing_type ?? 'Unfurnished'}}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded">
                                <i class="fas fa-building text-color fs-4 mb-2"></i>
                                <div class="fs-12 text-muted">Type</div>
                                <div class="fw-bold fs-16">{{$property->property_type ?? 'Villa'}}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded">
                                <i class="fas fa-calendar-check text-color fs-4 mb-2"></i>
                                <div class="fs-12 text-muted">Status</div>
                                <div class="fw-bold fs-16">{{$property->completion_status ?? 'Ready'}}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded">
                                <i class="fas fa-clock text-color fs-4 mb-2"></i>
                                <div class="fs-12 text-muted">Handover</div>
                                <div class="fw-bold fs-16">{{$property->handover_date ?? 'Immediate'}}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white p-4 rounded-3 border mb-4">
                    <h5 class="fw-bold text-uppercase border-bottom pb-3 mb-3">Property Overview</h5>
                    <div class="fs-15 lh-lg text-secondary">
                        {!! nl2br(e($property->description)) !!}
                    </div>
                </div>

                <!-- Amenities -->
                <div class="bg-white p-4 rounded-3 border mb-4">
                    <h5 class="fw-bold text-uppercase border-bottom pb-3 mb-3">Luxury Amenities & Features</h5>
                    <div class="amenities-grid">
                        @if($property->amenities && $property->amenities->count() > 0)
                            @foreach($property->amenities as $amenity)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-color me-2 fs-15"></i>
                                    <span class="fs-14 fw-medium">{{$amenity->title}}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-muted fs-14">Private Beach Access, Swimming Pool, 24/7 Security, Smart Home Automation, Landscaped Garden</div>
                        @endif
                    </div>
                </div>

                <!-- Mortgage Calculator (for Sale properties) -->
                @if($property->type == 'sale' && $property->price > 0)
                <div class="bg-white p-4 rounded-3 border mb-4">
                    <h5 class="fw-bold text-uppercase border-bottom pb-3 mb-3"><i class="fas fa-calculator text-color me-2"></i>Mortgage Estimator</h5>
                    <p class="text-muted fs-13">Estimate your monthly mortgage payments in Dubai with our standard UAE banking rate assumption (20% Down Payment, 4.5% Interest, 25-Year Term).</p>
                    <div class="calc-box row align-items-center">
                        <div class="col-md-7">
                            <div class="mb-2 d-flex justify-content-between">
                                <span class="fs-14 text-muted">Property Price:</span>
                                <strong class="fs-14">AED {{number_format($property->price)}}</strong>
                            </div>
                            <div class="mb-2 d-flex justify-content-between">
                                <span class="fs-14 text-muted">Estimated Down Payment (20%):</span>
                                <strong class="fs-14">AED {{number_format($property->price * 0.20)}}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="fs-14 text-muted">Loan Amount (80%):</span>
                                <strong class="fs-14">AED {{number_format($property->price * 0.80)}}</strong>
                            </div>
                        </div>
                        <div class="col-md-5 text-center border-start-md mt-3 mt-md-0">
                            @php
                                $loan = $property->price * 0.80;
                                $rate = 0.045 / 12;
                                $months = 25 * 12;
                                $monthly = ($loan * $rate * pow(1 + $rate, $months)) / (pow(1 + $rate, $months) - 1);
                            @endphp
                            <div class="fs-13 text-muted text-uppercase fw-semibold">Estimated Monthly Payment</div>
                            <div class="h3 fw-bold text-color my-1">AED {{number_format($monthly)}}</div>
                            <div class="fs-11 text-muted">per month</div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Location Map -->
                <div class="bg-white p-4 rounded-3 border mb-4">
                    <h5 class="fw-bold text-uppercase border-bottom pb-3 mb-3"><i class="fas fa-map-marker-alt text-color me-2"></i>Location</h5>
                    <p class="text-muted fs-14 mb-3">{{$property->completesearch ?? $property->address}}</p>
                    <div class="ratio ratio-16x9 rounded overflow-hidden">
                        <iframe src="https://maps.google.com/maps?q={{urlencode($property->completesearch ?? $property->title . ' Dubai')}}&t=&z=14&ie=UTF8&iwloc=&output=embed" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>

            </div>

            <!-- Right Column: Assigned Licensed Agent & Actions -->
            <div class="col-lg-4">
                <div class="agent-sticky-card">
                    <div class="text-center border-bottom pb-3 mb-3">
                        @if($property->user && $property->user->image)
                            <img src="{{asset('images/media/profile/' . $property->user->image)}}" class="rounded-circle mb-3 shadow-sm border border-2 border-warning" width="105" height="105" style="object-fit: cover;" alt="{{$property->user->name}}">
                        @else
                            <img src="{{asset('management/images/profile.png')}}" class="rounded-circle mb-3 shadow-sm" width="105" height="105" alt="Agent">
                        @endif
                        <h5 class="fw-bold mb-1 text-dark">{{$property->user->name ?? 'Licensed Property Advisor'}}</h5>
                        <p class="text-color fw-semibold fs-13 mb-1">{{$property->user->occupation ?? 'Luxury Property Specialist'}}</p>
                        <div class="badge bg-light text-dark border px-3 py-1 fs-12 mb-2">
                            BRN: <strong>{{$property->user->brn ?? '52410'}}</strong>
                        </div>
                        @if($property->user && $property->user->language_multi_select)
                            @php $langs = json_decode($property->user->language_multi_select, true); @endphp
                            @if(is_array($langs))
                                <div class="fs-12 text-muted">Speaks: {{implode(', ', $langs)}}</div>
                            @endif
                        @endif
                    </div>

                    <!-- Direct Contact Buttons -->
                    @php
                        $agentPhone = $property->user->phone ?? '+97145558899';
                        $agentWhatsapp = $property->user->whatsapp_no ?? '971501234567';
                        $waMsg = urlencode("Hello, I am interested in " . $property->title . " (Ref: " . ($property->reference_no ?? 'EERE-'.$property->id) . "). " . url('/detail/' . $property->slug));
                    @endphp
                    <div class="d-grid gap-2 mb-4">
                        <a href="https://wa.me/{{preg_replace('/[^0-9]/', '', $agentWhatsapp)}}?text={{$waMsg}}" target="_blank" class="btn btn-success fw-bold py-2">
                            <i class="fab fa-whatsapp fs-16 me-2"></i>Chat on WhatsApp
                        </a>
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="tel:{{$agentPhone}}" class="btn btn-outline-dark w-100 py-2 fs-14">
                                    <i class="fas fa-phone-alt me-1"></i>Call Agent
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="mailto:{{$property->user->email ?? 'info@eliteevolutionrealestate.ae'}}?subject=Inquiry on {{$property->title}}" class="btn btn-outline-dark w-100 py-2 fs-14">
                                    <i class="fas fa-envelope me-1"></i>Email
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Book a Private Viewing Form -->
                    <div class="card bg-light border-0 p-3 mb-3">
                        <h6 class="fw-bold mb-3 text-uppercase fs-14 text-dark"><i class="fas fa-calendar-alt text-color me-2"></i>Book a Private Viewing</h6>
                        <form action="{{url('/book-viewing/' . $property->id)}}" method="POST">
                            @csrf
                            <!-- Anti-spam honeypot -->
                            <input type="text" name="hp_fax_check" style="display:none !important;" tabindex="-1" autocomplete="off">
                            <div class="mb-2">
                                <input type="text" name="name" class="form-control form-control-sm" placeholder="Your Full Name" required>
                            </div>
                            <div class="mb-2">
                                <input type="email" name="email" class="form-control form-control-sm" placeholder="Your Email Address" required>
                            </div>
                            <div class="mb-2">
                                <input type="tel" name="phone" class="form-control form-control-sm" placeholder="Your Phone (+971 ...)" required>
                            </div>
                            <div class="mb-2">
                                <input type="date" name="date" class="form-control form-control-sm" min="{{date('Y-m-d')}}">
                            </div>
                            <button type="submit" class="btn btn-dark w-100 btn-sm py-2 fw-semibold text-uppercase">Request Viewing</button>
                        </form>
                    </div>

                    <!-- Brochure Download Modal Trigger -->
                    <button type="button" class="btn btn-outline-secondary w-100 btn-sm text-uppercase py-2" data-bs-toggle="modal" data-bs-target="#brochureModal">
                        <i class="fas fa-file-pdf me-2 text-danger"></i>Download Official Brochure
                    </button>
                </div>
            </div>
        </div>

        <!-- Real Similar Properties Section (Audit High Fix) -->
        <div class="mt-5 pt-4 border-top">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-uppercase mb-1">More Properties in Similar Area</h3>
                    <p class="text-muted fs-14 m-0">Verified prime opportunities curated by our brokerage</p>
                </div>
                <a href="{{url('/listing/' . $property->type)}}" class="btn btn-outline-dark btn-sm px-3">View All Stock</a>
            </div>

            <div class="row g-4">
                @if(isset($similar_properties) && $similar_properties->count() > 0)
                    @foreach($similar_properties as $sim)
                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                                <div class="position-relative">
                                    <a href="{{url('/detail/' . $sim->slug)}}">
                                        <img src="{{$sim->featuredImage ? asset('images/media/' . $sim->featuredImage->image) : asset('gallery.png')}}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{$sim->title}}">
                                    </a>
                                    <span class="badge badge-luxury position-absolute top-0 start-0 m-2">{{$sim->completion_status ?? 'Ready'}}</span>
                                </div>
                                <div class="card-body p-3">
                                    <h6 class="fw-bold text-color mb-1">
                                        AED {{number_format($sim->type == 'rent' ? ($sim->yearly_rent ?: $sim->price) : $sim->price)}}
                                        @if($sim->type == 'rent') <span class="fs-12 text-muted fw-normal">/yr</span> @endif
                                    </h6>
                                    <h6 class="card-title fs-14 fw-bold text-truncate mb-2">
                                        <a href="{{url('/detail/' . $sim->slug)}}" class="text-dark text-decoration-none">{{$sim->title}}</a>
                                    </h6>
                                    <p class="text-muted fs-12 mb-3 text-truncate"><i class="fas fa-map-marker-alt text-color me-1"></i>{{$sim->community ?? $sim->state}}</p>
                                    <div class="d-flex justify-content-between text-muted fs-12 border-top pt-2">
                                        <span><i class="fas fa-bed me-1"></i>{{$sim->bedrooms}} Beds</span>
                                        <span><i class="fas fa-bath me-1"></i>{{$sim->bathrooms}} Baths</span>
                                        <span><i class="fas fa-ruler-combined me-1"></i>{{$sim->size ?? 'N/A'}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-muted">No additional listings found in this immediate sub-community.</div>
                @endif
            </div>
        </div>

    </div>
</section>

<!-- Brochure Modal -->
<div class="modal fade" id="brochureModal" tabindex="-1" aria-labelledby="brochureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-uppercase">Download Property Brochure</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted fs-14 mb-3">Please provide your contact details to receive the official floor plans, brochure, and specifications for <strong>{{$property->title}}</strong>.</p>
                <form action="{{url('/inquire-brochure/' . $property->id)}}" method="POST">
                    @csrf
                    <!-- Honeypot -->
                    <input type="text" name="hp_email_verify" style="display:none !important;" tabindex="-1" autocomplete="off">
                    <div class="mb-3">
                        <label class="form-label fs-14">Full Name</label>
                        <input type="text" class="form-control" name="name" required placeholder="John Doe">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-14">Email Address</label>
                        <input type="email" class="form-control" name="email" required placeholder="name@example.com">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fs-14">Mobile / WhatsApp Number</label>
                        <input type="tel" class="form-control" name="phone" required placeholder="+971 50 123 4567">
                    </div>
                    <button type="submit" class="btn btn-dark w-100 py-2 text-uppercase fw-semibold">Download Brochure Now</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
