@extends('frontend.layouts.master')

@section('title')
    Interactive Map Search | Elite Evolution Real Estate Dubai
@endsection

@section('meta_title')
    Dubai Property Map Search | Elite Evolution Luxury Real Estate
@endsection

@section('meta_description')
    Explore luxury properties across Dubai on an interactive map. Pinpoint beachfront villas in Palm Jumeirah, lakefront estates in Jumeirah Islands, and prime off-plan towers.
@endsection

@section('content')
<!-- Leaflet CSS & JS for Interactive Map with Zero API Key Dependency -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
    .map-header {
        background: #111;
        color: #fff;
        padding: 20px 0;
    }
    .map-container-wrapper {
        height: calc(100vh - 180px);
        min-height: 600px;
        position: relative;
    }
    #propertyMap {
        width: 100%;
        height: 100%;
        border-radius: 8px;
        z-index: 1;
    }
    .map-listings-sidebar {
        height: calc(100vh - 180px);
        min-height: 600px;
        overflow-y: auto;
        padding-right: 12px;
    }
    .map-card {
        background: #fff;
        border: 1px solid #eaeaea;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 16px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }
    .map-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }
    .map-card img {
        height: 140px;
        width: 100%;
        object-fit: cover;
    }
    .custom-map-popup .leaflet-popup-content-wrapper {
        border-radius: 8px;
        padding: 0;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .custom-map-popup .leaflet-popup-content {
        margin: 0;
        line-height: 1.4;
    }
</style>

<div class="map-header">
    <div class="container-fluid px-md-5">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <span class="text-uppercase small" style="color: #b38b47; font-weight: 600; letter-spacing: 1px;">Geographic Discovery</span>
                <h3 class="fw-bold text-white mb-0" style="font-family: serif;">Interactive Map Search</h3>
            </div>
            <div class="d-flex gap-2 mt-2 mt-md-0">
                <a href="{{ url('listing/sale') }}" class="btn btn-outline-light btn-sm">
                    <i class="fa-solid fa-list me-1"></i> Switch to Grid View
                </a>
                <a href="{{ url('luxury-rentals') }}" class="btn btn-outline-warning btn-sm">
                    Luxury Rentals
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-md-5 py-4" style="background: #f8f9fa;">
    <div class="row g-4">
        <!-- Listings Side Scroll -->
        <div class="col-lg-5 col-xl-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-muted">{{ count($properties) }} Properties on Map</h6>
                <span class="badge bg-dark">Dubai, UAE</span>
            </div>

            <div class="map-listings-sidebar">
                @forelse($properties as $item)
                    @php
                        $img = $item->featuredImage ? asset('images/media/' . $item->featuredImage->image) : asset('management/images/11.png');
                        $priceStr = $item->type == 'rent' ? 'AED ' . number_format($item->yearly_rent ?: $item->price) . ' /yr' : 'AED ' . number_format($item->price);
                    @endphp
                    <div class="map-card" onclick="focusProperty({{ $item->lat }}, {{ $item->lng }}, '{{ addslashes($item->title) }}')">
                        <div class="row g-0">
                            <div class="col-5">
                                <img src="{{ $img }}" alt="{{ $item->title }}">
                            </div>
                            <div class="col-7 p-3 d-flex flex-column justify-content-between">
                                <div>
                                    <span class="badge bg-secondary mb-1" style="font-size: 10px;">{{ $item->completion_status ?? 'Ready' }}</span>
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">{{ Str::limit($item->title, 26) }}</h6>
                                    <p class="text-muted small mb-1"><i class="fa-solid fa-location-dot text-warning me-1"></i> {{ $item->community }}</p>
                                    <h6 class="fw-bold text-dark mb-0" style="font-family: serif;">{{ $priceStr }}</h6>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-2">
                                    <small class="text-muted">{{ $item->bedrooms }} Beds | {{ $item->bathrooms }} Baths</small>
                                    <a href="{{ url('detail', $item->slug) }}" class="btn btn-sm btn-outline-dark py-0 px-2" style="font-size: 11px;">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-4 rounded text-center">
                        <p class="text-muted mb-0">No geocoded properties currently available.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Interactive Map View -->
        <div class="col-lg-7 col-xl-8">
            <div class="map-container-wrapper shadow-sm rounded">
                <div id="propertyMap"></div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var defaultLat = 25.1189;
        var defaultLng = 55.1386;

        var properties = [
            @foreach($properties as $prop)
                @if($prop->lat && $prop->lng)
                {
                    id: {{ $prop->id }},
                    title: "{{ addslashes($prop->title) }}",
                    slug: "{{ $prop->slug }}",
                    lat: {{ (float)$prop->lat }},
                    lng: {{ (float)$prop->lng }},
                    community: "{{ addslashes($prop->community ?? 'Dubai') }}",
                    price: "{{ $prop->type == 'rent' ? 'AED ' . number_format($prop->yearly_rent ?: $prop->price) . '/year' : 'AED ' . number_format($prop->price) }}",
                    beds: "{{ $prop->bedrooms }}",
                    baths: "{{ $prop->bathrooms }}",
                    ref: "{{ $prop->reference_no ?? 'EERE' }}",
                    image: "{{ $prop->featuredImage ? asset('images/media/' . $prop->featuredImage->image) : asset('management/images/11.png') }}",
                    url: "{{ url('detail', $prop->slug) }}"
                },
                @endif
            @endforeach
        ];

        var map = L.map('propertyMap').setView([defaultLat, defaultLng], 12);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://carto.com/">CARTO</a> | Elite Evolution',
            maxZoom: 19
        }).addTo(map);

        var markers = {};
        var bounds = [];

        properties.forEach(function (prop) {
            var customIcon = L.divIcon({
                className: 'custom-pin',
                html: '<div style="background: #111; color: #fff; padding: 4px 8px; border-radius: 14px; font-weight: bold; font-size: 11px; border: 2px solid #b38b47; box-shadow: 0 4px 10px rgba(0,0,0,0.3); white-space: nowrap;"><i class="fa-solid fa-gem text-warning me-1"></i>' + prop.price + '</div>',
                iconSize: [110, 30],
                iconAnchor: [55, 15]
            });

            var marker = L.marker([prop.lat, prop.lng], { icon: customIcon }).addTo(map);

            var popupContent = `
                <div style="width: 250px; font-family: sans-serif;">
                    <img src="${prop.image}" style="width: 100%; height: 130px; object-fit: cover; display: block;">
                    <div style="padding: 12px;">
                        <span style="font-size: 10px; color: #888; font-family: monospace;">Ref: ${prop.ref}</span>
                        <h6 style="margin: 4px 0 6px; font-weight: 700; font-size: 13px; color: #111;">${prop.title}</h6>
                        <div style="font-size: 14px; font-weight: 700; color: #b38b47; margin-bottom: 6px;">${prop.price}</div>
                        <div style="font-size: 11px; color: #555; margin-bottom: 10px;">${prop.beds} Beds | ${prop.baths} Baths | ${prop.community}</div>
                        <a href="${prop.url}" style="display: block; text-align: center; background: #111; color: #fff; text-decoration: none; padding: 6px; font-size: 12px; font-weight: 600; border-radius: 4px;">View Listing</a>
                    </div>
                </div>
            `;

            marker.bindPopup(popupContent, { className: 'custom-map-popup' });
            markers[prop.id] = marker;
            bounds.push([prop.lat, prop.lng]);
        });

        if (bounds.length > 0) {
            map.fitBounds(bounds, { padding: [40, 40] });
        }

        window.focusProperty = function (lat, lng, title) {
            map.flyTo([lat, lng], 14, { duration: 1.2 });
            properties.forEach(function (p) {
                if (p.lat === lat && p.lng === lng) {
                    markers[p.id].openPopup();
                }
            });
        };
    });
</script>
@endsection
