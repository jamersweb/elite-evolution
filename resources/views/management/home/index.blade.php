@extends('management.layouts.master')
@section('title')
    Dashboard - Elite Evolution Real Estate Management
@endsection

@section('content')
<div class="container-fluid py-3">
    <div class="block-header mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h3 class="font-weight-bold mb-1" style="font-family: serif;">Executive Overview</h3>
                <p class="text-muted small mb-0">Elite Evolution Real Estate Dubai Portfolio & CRM Metrics</p>
            </div>
            <div class="d-flex gap-2 mt-2 mt-md-0">
                <a href="{{ route('property.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> New Listing
                </a>
                <a href="{{ route('agents.create') }}" class="btn btn-outline-dark btn-sm">
                    <i class="fas fa-user-plus mr-1"></i> Add Broker
                </a>
            </div>
        </div>
    </div>

    <!-- KPI Metric Cards -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
            <div class="card shadow-sm border-0 h-100" style="border-left: 4px solid #b38b47 !important;">
                <div class="body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase text-muted font-weight-bold" style="font-size: 11px;">Active Properties</span>
                            <h3 class="font-weight-bold mb-0 mt-1">{{ $metrics['active_properties'] ?? 0 }}</h3>
                            <small class="text-muted">{{ $metrics['sale_properties'] ?? 0 }} Sale | {{ $metrics['rent_properties'] ?? 0 }} Rent</small>
                        </div>
                        <div class="icon bg-light p-3 rounded-circle text-warning">
                            <i class="fas fa-building fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
            <div class="card shadow-sm border-0 h-100" style="border-left: 4px solid #111 !important;">
                <div class="body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase text-muted font-weight-bold" style="font-size: 11px;">Licensed Brokers</span>
                            <h3 class="font-weight-bold mb-0 mt-1">{{ $metrics['total_agents'] ?? 0 }}</h3>
                            <small class="text-muted">DLD Certified RERA BRN</small>
                        </div>
                        <div class="icon bg-light p-3 rounded-circle text-dark">
                            <i class="fas fa-id-badge fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
            <div class="card shadow-sm border-0 h-100" style="border-left: 4px solid #28a745 !important;">
                <div class="body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase text-muted font-weight-bold" style="font-size: 11px;">Property Inquiries</span>
                            <h3 class="font-weight-bold mb-0 mt-1">{{ $metrics['total_inquiries'] ?? 0 }}</h3>
                            <small class="text-muted">Viewings & Brochures</small>
                        </div>
                        <div class="icon bg-light p-3 rounded-circle text-success">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
            <div class="card shadow-sm border-0 h-100" style="border-left: 4px solid #17a2b8 !important;">
                <div class="body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase text-muted font-weight-bold" style="font-size: 11px;">CRM Leads</span>
                            <h3 class="font-weight-bold mb-0 mt-1">{{ $metrics['total_leads'] ?? 0 }}</h3>
                            <small class="text-muted">{{ $metrics['total_subscribers'] ?? 0 }} Subscribers</small>
                        </div>
                        <div class="icon bg-light p-3 rounded-circle text-info">
                            <i class="fas fa-user-friends fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row mt-2">
        <!-- Recent Viewing & Brochure Requests -->
        <div class="col-lg-7 col-md-12 mb-4">
            <div class="card shadow-sm h-100">
                <div class="header d-flex justify-content-between align-items-center p-3 border-bottom">
                    <h5 class="font-weight-bold mb-0"><i class="fas fa-inbox text-warning mr-2"></i> Recent Viewing & Property Inquiries</h5>
                    <a href="{{ url('admin/brochure-leads') }}" class="btn btn-sm btn-link text-dark font-weight-bold">View All</a>
                </div>
                <div class="body p-0 table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Client</th>
                                <th>Contact</th>
                                <th>Property</th>
                                <th>Type</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_inquiries as $inq)
                                <tr>
                                    <td>
                                        <strong class="text-dark">{{ $inq->name }}</strong>
                                    </td>
                                    <td>
                                        <small class="d-block">{{ $inq->phone }}</small>
                                        <small class="text-muted">{{ $inq->email }}</small>
                                    </td>
                                    <td>
                                        @if($inq->property)
                                            <a href="{{ url('detail', $inq->property->slug) }}" target="_blank" class="text-dark font-weight-bold">
                                                {{ Str::limit($inq->property->title, 24) }}
                                            </a>
                                            <small class="d-block text-muted">Ref: {{ $inq->property->reference_no ?? 'EERE' }}</small>
                                        @else
                                            <span class="text-muted">General Inquiry</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($inq->type == 'viewing')
                                            <span class="badge badge-success">Viewing</span>
                                        @else
                                            <span class="badge badge-info">Brochure</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $inq->created_at ? $inq->created_at->format('d M, H:i') : '-' }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No viewing requests received yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent CRM Leads -->
        <div class="col-lg-5 col-md-12 mb-4">
            <div class="card shadow-sm h-100">
                <div class="header d-flex justify-content-between align-items-center p-3 border-bottom">
                    <h5 class="font-weight-bold mb-0"><i class="fas fa-chart-line text-success mr-2"></i> CRM Leads</h5>
                    <a href="{{ route('lead.index') }}" class="btn btn-sm btn-link text-dark font-weight-bold">Manage CRM</a>
                </div>
                <div class="body p-0 table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Lead Name</th>
                                <th>Source</th>
                                <th>Status</th>
                                <th>Assigned</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_leads as $lead)
                                <tr>
                                    <td>
                                        <strong class="text-dark">{{ $lead->firstname }} {{ $lead->lastname }}</strong>
                                        <small class="d-block text-muted">{{ $lead->phone ?? $lead->email }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-light border">{{ $lead->source ?? 'Website' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">{{ $lead->status ?? 'new' }}</span>
                                    </td>
                                    <td>
                                        <small>{{ $lead->assignedAgent ? $lead->assignedAgent->name : 'Unassigned' }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No leads recorded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Inventory Summary -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="header d-flex justify-content-between align-items-center p-3 border-bottom">
                    <h5 class="font-weight-bold mb-0"><i class="fas fa-home text-dark mr-2"></i> Current Verified Inventory</h5>
                    <a href="{{ route('property.index') }}" class="btn btn-sm btn-link text-dark font-weight-bold">View All Listings</a>
                </div>
                <div class="body p-0 table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Ref #</th>
                                <th>Property Title</th>
                                <th>Community</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Trakheesi Permit</th>
                                <th>Assigned Broker</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_properties as $prop)
                                <tr>
                                    <td><code>{{ $prop->reference_no ?? 'EERE' }}</code></td>
                                    <td>
                                        <a href="{{ url('detail', $prop->slug) }}" target="_blank" class="font-weight-bold text-dark">
                                            {{ $prop->title }}
                                        </a>
                                    </td>
                                    <td>{{ $prop->community ?? 'Dubai' }}</td>
                                    <td>
                                        <strong>
                                            @if($prop->type == 'rent')
                                                AED {{ number_format($prop->yearly_rent ?: $prop->price) }} /yr
                                            @else
                                                AED {{ number_format($prop->price) }}
                                            @endif
                                        </strong>
                                    </td>
                                    <td>
                                        <span class="badge {{ $prop->completion_status == 'Ready' ? 'badge-dark' : 'badge-warning' }}">
                                            {{ $prop->completion_status ?? 'Ready' }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="badge badge-success font-weight-bold">
                                            <i class="fas fa-certificate mr-1"></i> {{ $prop->trakheesi_permit_no ?? 'Verified' }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>{{ $prop->user ? $prop->user->name : 'Brokerage Admin' }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No properties found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
