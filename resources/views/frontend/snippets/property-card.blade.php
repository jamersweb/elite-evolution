@php
    $isRent = $item->type == 'rent';
    $isOffplan = !$isRent && ($item->completion_status == 'Off-plan' || $item->is_new_project);
    $statusText = $isRent ? 'Luxury Rental' : ($isOffplan ? 'Off-Plan' : ($item->completion_status ?? 'Ready'));
    $cover = $item->featuredImage && $item->featuredImage->image
        ? asset('images/media/' . $item->featuredImage->image)
        : asset('frontend/img/banner_update.jpg');
@endphp
<article class="ee-prop-card">
    <a href="{{ url('detail', $item->slug) }}" class="ee-prop-media">
        <img src="{{ $cover }}" alt="{{ $item->title }}" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('frontend/img/banner_update.jpg') }}'">
        <span class="ee-prop-status {{ $isRent ? 'is-rent' : ($isOffplan ? 'is-offplan' : '') }}">{{ $statusText }}</span>
        @if($item->trakheesi_permit_no)
            <span class="ee-prop-verified" title="DLD Trakheesi permit {{ $item->trakheesi_permit_no }}">
                <i class="fa-solid fa-shield-halved"></i> DLD Verified
            </span>
        @endif
    </a>
    <div class="ee-prop-body">
        <div class="ee-prop-price">
            @if($isRent)
                AED {{ number_format($item->yearly_rent ?: $item->price) }}<small>/year</small>
            @elseif($item->price)
                AED {{ number_format($item->price) }}
            @else
                Price on Request
            @endif
        </div>
        <h3 class="ee-prop-title">
            <a href="{{ url('detail', $item->slug) }}">{{ $item->title }}</a>
        </h3>
        <p class="ee-prop-location">
            <i class="fa-solid fa-location-dot"></i>{{ $item->community ?? $item->completesearch ?? $item->state ?? 'Dubai' }}
        </p>
        <ul class="ee-prop-specs">
            @if($item->bedrooms)
                <li><i class="fa-solid fa-bed"></i>{{ $item->bedrooms }} Beds</li>
            @endif
            @if($item->bathrooms)
                <li><i class="fa-solid fa-bath"></i>{{ $item->bathrooms }} Baths</li>
            @endif
            @if($item->build_up_area || $item->size)
                <li><i class="fa-solid fa-ruler-combined"></i>{{ $item->build_up_area ?: $item->size }}</li>
            @endif
            @if($isOffplan && $item->handover_date)
                <li><i class="fa-solid fa-calendar-check"></i>{{ $item->handover_date }}</li>
            @endif
        </ul>
    </div>
</article>
