@extends('management.layouts.master')
@section('title')
    Licensed Agents Management - {{ config('app.dashboard') }}
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center my-3">
        <h2 class="heading_font mb-0">Licensed Real Estate Agents <span class="badge badge-dark">{{ $agents->total() }}</span></h2>
        <a class="btn btn-primary" href="{{ route('agents.create') }}">
            <i class="fas fa-plus mr-1"></i> Add Licensed Agent
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="thead-light">
                    <tr>
                        <th width="70px">Photo</th>
                        <th>Agent Name</th>
                        <th>BRN #</th>
                        <th>Contact</th>
                        <th>Specialization</th>
                        <th>Active Listings</th>
                        <th>Status</th>
                        <th width="220px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agents as $agent)
                        <tr>
                            <td>
                                @if($agent->image)
                                    <img src="{{ asset('images/media/profile/' . $agent->image) }}" style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover;" alt="{{ $agent->name }}">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($agent->name) }}&background=111&color=b38b47&size=90" style="width: 45px; height: 45px; border-radius: 50%;" alt="{{ $agent->name }}">
                                @endif
                            </td>
                            <td>
                                <strong class="d-block text-dark">{{ $agent->name }}</strong>
                                <small class="text-muted">{{ $agent->email }}</small>
                            </td>
                            <td>
                                <span class="badge badge-warning text-dark font-weight-bold">
                                    {{ $agent->brn ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <small class="d-block"><i class="fas fa-phone text-muted mr-1"></i> {{ $agent->phone ?? '-' }}</small>
                                @if($agent->whatsapp_no)
                                    <small class="text-success"><i class="fab fa-whatsapp mr-1"></i> {{ $agent->whatsapp_no }}</small>
                                @endif
                            </td>
                            <td>
                                <small class="d-block font-weight-bold">{{ $agent->occupation ?? 'Advisor' }}</small>
                                <small class="text-muted">{{ $agent->nationality ?? 'UAE' }}</small>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $agent->active_properties_count }} Active</span>
                            </td>
                            <td>
                                @if($agent->status == 'active')
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('agents/' . $agent->slug) }}" target="_blank" class="btn btn-sm btn-outline-info" title="View Public Profile">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="{{ route('agents.edit', $agent->id) }}" class="btn btn-sm btn-dark" title="Edit Agent">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('agents.destroy', $agent->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to remove this broker?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                No licensed agents configured yet. Click "Add Licensed Agent" above.
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
