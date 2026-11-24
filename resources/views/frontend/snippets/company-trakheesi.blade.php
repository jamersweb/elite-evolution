@php
    $permit = config('compliance.company_trakheesi');
    $tone = $tone ?? 'dark';
    $placement = $placement ?? null;
@endphp
@once
<style>
    .ee-company-permit {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-top: 14px;
        max-width: 280px;
    }
    .ee-company-permit img {
        background: #fff;
        border-radius: 8px;
        padding: 4px;
        width: 92px;
        height: 92px;
        flex: 0 0 92px;
        object-fit: contain;
    }
    .ee-company-permit strong {
        display: block;
        font-size: 11px;
        letter-spacing: .6px;
        text-transform: uppercase;
    }
    .ee-company-permit-no {
        display: block;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .4px;
        margin: 3px 0 6px;
    }
    .ee-company-permit p {
        margin: 0;
        font-size: 11px;
        line-height: 1.45;
    }
    .ee-company-permit--dark { max-width: 560px; margin: 4px 0 18px; }
    .ee-company-permit--dark strong,
    .ee-company-permit--dark .ee-company-permit-no { color: #fff; }
    .ee-company-permit--dark p { color: rgba(255,255,255,.65); }
    .ee-company-permit--footer-column {
        flex-direction: column;
        align-items: flex-start;
        max-width: none;
        margin: 36px 0 28px;
        gap: 10px;
    }
    .ee-company-permit--footer-column p {
        max-width: 220px;
    }
    .ee-company-permit--light { max-width: 440px; margin: 22px 0 28px; }
    .ee-company-permit--light strong,
    .ee-company-permit--light .ee-company-permit-no { color: #161616; }
    .ee-company-permit--light p { color: #6f6f6f; }
    .ee-company-permit--light img { border: 1px solid #ebe5d8; }
</style>
@endonce
<aside class="ee-company-permit ee-company-permit--{{ $tone }}{{ $placement ? ' ee-company-permit--'.$placement : '' }}" aria-label="Company Trakheesi permit {{ $permit['permit_no'] }}">
    <img src="{{ asset($permit['qr_image']) }}" width="92" height="92" alt="Official company Trakheesi QR code, permit {{ $permit['permit_no'] }}">
    <div>
        <strong>Company Trakheesi Permit</strong>
        <span class="ee-company-permit-no">{{ $permit['permit_no'] }}</span>
        <p>General company promotion only. Each property advertisement needs its own Trakheesi permit and QR code.</p>
    </div>
</aside>
