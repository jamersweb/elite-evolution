@extends('management.layouts.master')
@section('title', 'Property Finder listing details')
@section('content')
<div class="card p-4">
    <a href="{{ route('property.index') }}">Back to properties</a>
    <h1 class="h4 mt-3">{{ $property->title }}</h1>
    <p>Property Finder reference {{ $property->reference_no }}</p>
    @foreach(json_decode($property->source_payload, true)['listing'] as $field => $value)
        <details class="border-bottom py-2">
            <summary>{{ \Illuminate\Support\Str::headline($field) }}</summary>
            <pre class="mt-2" style="white-space:pre-wrap;overflow-wrap:anywhere">{{ is_string($value) ? $value : json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
        </details>
    @endforeach
    <details class="py-2">
        <summary>Location lookup details</summary>
        <pre style="white-space:pre-wrap">{{ json_encode(json_decode($property->source_payload, true)['location'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    </details>
</div>
@endsection
