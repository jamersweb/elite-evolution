@extends('management.layouts.master')
@section('title')
    Edit Agent - {{ $agent->name }} - {{ config('app.dashboard') }}
@endsection

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="heading_font mb-0">Edit Licensed Agent: {{ $agent->name }}</h2>
        <a class="btn btn-secondary" href="{{ route('agents.index') }}">
            <i class="fas fa-arrow-left mr-1"></i> Back to Agents
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="body">
            <form action="{{ route('agents.update', $agent->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $agent->name) }}" required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $agent->email) }}" required>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Leave empty to keep current password">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">RERA BRN (Broker Reg. No.)</label>
                        <input type="text" name="brn" class="form-control" placeholder="e.g. 52410" value="{{ old('brn', $agent->brn) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Role Assignment</label>
                        <select name="role" class="form-control">
                            <option value="agent" {{ $agent->hasRole('agent') ? 'selected' : '' }}>Agent</option>
                            <option value="eliteagent" {{ $agent->hasRole('eliteagent') ? 'selected' : '' }}>Elite Agent</option>
                            <option value="Admin" {{ $agent->hasRole('Admin') ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $agent->phone) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">WhatsApp Number</label>
                        <input type="text" name="whatsapp_no" class="form-control" value="{{ old('whatsapp_no', $agent->whatsapp_no) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Designation / Occupation</label>
                        <input type="text" name="occupation" class="form-control" value="{{ old('occupation', $agent->occupation) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Years of Experience</label>
                        <input type="text" name="experience" class="form-control" value="{{ old('experience', $agent->experience) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Nationality</label>
                        <input type="text" name="nationality" class="form-control" value="{{ old('nationality', $agent->nationality) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Account Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ $agent->status == 'active' ? 'selected' : '' }}>Active (Visible on Website)</option>
                            <option value="inactive" {{ $agent->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    @php
                        $currentAreas = '';
                        if (!empty($agent->area_tags)) {
                            $decoded = is_string($agent->area_tags) ? json_decode($agent->area_tags, true) : $agent->area_tags;
                            $currentAreas = is_array($decoded) ? implode(', ', $decoded) : $agent->area_tags;
                        }
                    @endphp
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Focus Communities</label>
                        <input type="text" name="area_tags" class="form-control" value="{{ old('area_tags', $currentAreas) }}">
                    </div>

                    @php
                        $selectedLangs = [];
                        if (!empty($agent->language_multi_select)) {
                            $decoded = is_string($agent->language_multi_select) ? json_decode($agent->language_multi_select, true) : $agent->language_multi_select;
                            $selectedLangs = is_array($decoded) ? $decoded : [];
                        }
                    @endphp
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Languages Spoken</label>
                        <select name="language_multi_select[]" class="form-control" multiple style="height: 100px;">
                            @foreach($languages as $lang)
                                <option value="{{ $lang }}" {{ in_array($lang, $selectedLangs) ? 'selected' : '' }}>{{ $lang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Agent Headshot / Photo</label>
                        <input type="file" name="image" class="form-control-file" accept="image/*">
                        @if($agent->image)
                            <div class="mt-2">
                                <img src="{{ asset('images/media/profile/' . $agent->image) }}" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover;">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">LinkedIn Profile URL</label>
                        <input type="url" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $agent->linkedin_url) }}">
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="font-weight-bold">Biography & Background</label>
                        <textarea name="about" class="form-control" rows="4">{{ old('about', $agent->about) }}</textarea>
                    </div>

                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save mr-1"></i> Update Agent Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
