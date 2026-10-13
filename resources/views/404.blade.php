@extends('frontend.layouts.master')
@section('title')
   404 - Page Not Found | {{ config('app.name') }}
@endsection
@section('meta_title')
   Page Not Found | Elite Evolution Real Estate
@endsection
@section('meta_description')
   The requested page could not be found. Explore our licensed Dubai brokers or luxury properties for sale and rent.
@endsection
@section('content')

<section class="py-5 text-center" style="background-color: #fafafa; min-height: 60vh; display: flex; align-items: center;">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <span class="text-uppercase fw-bold" style="color: #b38b47; letter-spacing: 2px; font-size: 13px;">Error 404</span>
                <h1 class="display-4 fw-bold mt-2 mb-3" style="font-family: serif;">Page Not Found</h1>
                <p class="text-muted mb-4 fs-6">
                    The requested page or advisor profile is unavailable or may have been relocated.
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ url('/') }}" class="btn btn-dark px-4 py-2 text-uppercase fw-semibold" style="letter-spacing: 1px;">
                        Return Home
                    </a>
                    <a href="{{ url('/agents') }}" class="btn btn-outline-dark px-4 py-2 text-uppercase fw-semibold" style="letter-spacing: 1px;">
                        Meet Our Brokers
                    </a>
                    <a href="{{ url('/listing/sale') }}" class="btn btn-outline-secondary px-4 py-2 text-uppercase fw-semibold" style="letter-spacing: 1px;">
                        Browse Properties
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

