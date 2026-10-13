@extends('management.layouts.master')
@section('title')
    Licensed Real Estate Agents Management - {{ config('app.dashboard') }}
@endsection

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
            <h2 class="heading_font mb-1">Licensed Real Estate Agents & Brokers</h2>
            <p class="text-muted small mb-0">Manage licensed brokers, DLD BRN numbers, bio information, and custom vanity profile links.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a class="btn btn-primary" href="{{ route('agents.create') }}">
                <i class="fas fa-plus mr-1"></i> Add New Agent
            </a>
            <a class="btn btn-outline-dark ml-1" href="{{ url('/agents') }}" target="_blank">
                <i class="fas fa-external-link-alt mr-1"></i> View Frontend Directory
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="fas fa-check-circle mr-2"></i> {!! session('success') !!}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <!-- Quick Stats Overview -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card bg-dark text-white shadow-sm mb-0">
                <div class="body py-3 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 text-uppercase small d-block">Configured Agents</span>
                        <h3 class="mb-0 font-weight-bold text-white">{{ $stats['total_agents'] ?? $agents->total() }}</h3>
                    </div>
                    <i class="fas fa-id-badge fa-2x text-warning"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow-sm mb-0">
                <div class="body py-3 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 text-uppercase small d-block">Active on Website</span>
                        <h3 class="mb-0 font-weight-bold text-white">{{ $stats['active_agents'] ?? $agents->count() }}</h3>
                    </div>
                    <i class="fas fa-user-check fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white shadow-sm mb-0">
                <div class="body py-3 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 text-uppercase small d-block">Assigned Listings</span>
                        <h3 class="mb-0 font-weight-bold text-white">{{ $stats['total_listings'] ?? '-' }}</h3>
                    </div>
                    <i class="fas fa-home fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="card shadow-sm mb-3">
        <div class="body py-3">
            <form method="GET" action="{{ route('agents.index') }}" class="row g-2 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
                        </div>
                        <input type="text" name="search" class="form-control" placeholder="Search by name, email, BRN, or custom slug..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Only</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex">
                    <button type="submit" class="btn btn-secondary mr-2 flex-grow-1">Filter</button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('agents.index') }}" class="btn btn-outline-secondary" title="Reset Filters"><i class="fas fa-undo"></i></a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Agents Table -->
    <div class="card shadow-sm">
        <div class="body table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="65px">Headshot</th>
                        <th>Agent Profile</th>
                        <th>Custom URL / Slug</th>
                        <th>RERA BRN #</th>
                        <th>Contact Numbers</th>
                        <th>Specialization</th>
                        <th>Properties</th>
                        <th>Status</th>
                        <th width="200px" class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agents as $agent)
                        <tr>
                            <td>
                                @if($agent->image)
                                    <img src="{{ asset('images/media/profile/' . $agent->image) }}" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid #b38b47;" alt="{{ $agent->name }}">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($agent->name) }}&background=111&color=b38b47&size=96" style="width: 48px; height: 48px; border-radius: 50%;" alt="{{ $agent->name }}">
                                @endif
                            </td>
                            <td>
                                <strong class="d-block text-dark font-weight-bold">{{ $agent->name }}</strong>
                                <small class="text-muted">{{ $agent->email }}</small>
                            </td>
                            <td>
                                <a href="{{ url($agent->slug) }}" target="_blank" class="badge badge-light border text-primary p-2 text-decoration-none" title="Click to view live page on frontend">
                                    <i class="fas fa-link mr-1"></i> /{{ $agent->slug }}
                                    <i class="fas fa-external-link-alt ml-1 small text-muted"></i>
                                </a>
                            </td>
                            <td>
                                @if($agent->brn)
                                    <span class="badge badge-warning text-dark font-weight-bold font-monospace px-2 py-1">
                                        BRN #{{ $agent->brn }}
                                    </span>
                                @else
                                    <span class="badge badge-light text-muted">Unassigned</span>
                                @endif
                            </td>
                            <td>
                                @if($agent->phone)
                                    <small class="d-block"><i class="fas fa-phone text-muted mr-1"></i> {{ $agent->phone }}</small>
                                @endif
                                @if($agent->whatsapp_no)
                                    <small class="text-success d-block font-weight-bold"><i class="fab fa-whatsapp mr-1"></i> {{ $agent->whatsapp_no }}</small>
                                @endif
                            </td>
                            <td>
                                <small class="d-block font-weight-bold text-dark">{{ $agent->occupation ?? 'Property Advisor' }}</small>
                                <small class="text-muted">{{ $agent->experience ? Str::limit($agent->experience, 22) : ($agent->nationality ?? 'Prime Dubai') }}</small>
                            </td>
                            <td>
                                <a href="{{ url('admin/property?agent_id=' . $agent->id) }}" class="badge badge-info p-2" title="View listings assigned to this agent">
                                    {{ $agent->active_properties_count }} Active
                                </a>
                            </td>
                            <td>
                                @if($agent->status == 'active')
                                    <span class="badge badge-success px-2 py-1">Active</span>
                                @else
                                    <span class="badge badge-secondary px-2 py-1">Inactive</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ url($agent->slug) }}" target="_blank" class="btn btn-sm btn-outline-info" title="View Live Page on Frontend">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('agents.edit', $agent->id) }}" class="btn btn-sm btn-dark ml-1" title="Edit Agent">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('agents.destroy', $agent->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to remove broker {{ addslashes($agent->name) }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger ml-1" title="Delete Agent">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fas fa-user-slash fa-3x mb-3 d-block text-muted"></i>
                                <h5>No Licensed Agents Found</h5>
                                <p class="small text-muted mb-3">Add your first licensed real estate agent to display on the frontend.</p>
                                <a href="{{ route('agents.create') }}" class="btn btn-primary btn-sm">Add New Agent</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $agents->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
