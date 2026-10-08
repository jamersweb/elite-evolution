@extends('management.layouts.master')
@section('title')
    Add Licensed Agent - {{ config('app.dashboard') }}
@endsection

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="heading_font mb-0">Add Licensed Real Estate Broker</h2>
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
            <form action="{{ route('agents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">RERA BRN (Broker Reg. No.)</label>
                        <input type="text" name="brn" class="form-control" placeholder="e.g. 52410" value="{{ old('brn') }}">
                        <small class="text-muted">Mandatory for DLD compliance display</small>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Role Assignment</label>
                        <select name="role" class="form-control">
                            <option value="agent">Agent (Own listings & leads)</option>
                            <option value="eliteagent">Elite Agent (Full listings & blogs)</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="+971 50 123 4567" value="{{ old('phone') }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">WhatsApp Number</label>
                        <input type="text" name="whatsapp_no" class="form-control" placeholder="971501234567" value="{{ old('whatsapp_no') }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Designation / Occupation</label>
                        <input type="text" name="occupation" class="form-control" placeholder="e.g. Senior Luxury Property Advisor" value="{{ old('occupation') }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Years of Experience</label>
                        <input type="text" name="experience" class="form-control" placeholder="e.g. 8 Years in Dubai Market" value="{{ old('experience') }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Nationality</label>
                        <input type="text" name="nationality" class="form-control" placeholder="e.g. British, Emirati, German" value="{{ old('nationality') }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Account Status</label>
                        <select name="status" class="form-control">
                            <option value="active">Active (Visible on Website)</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Focus Communities (Comma Separated)</label>
                        <input type="text" name="area_tags" class="form-control" placeholder="Palm Jumeirah, Emirates Hills, Downtown Dubai" value="{{ old('area_tags') }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Languages Spoken (Select multiple)</label>
                        <select name="language_multi_select[]" class="form-control" multiple style="height: 100px;">
                            @foreach($languages as $lang)
                                <option value="{{ $lang }}">{{ $lang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Agent Headshot / Photo</label>
                        <input type="file" name="image" class="form-control-file" accept="image/*">
                        <small class="text-muted d-block">Recommended: square format (400x400px), JPG or PNG</small>
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">LinkedIn Profile URL</label>
                        <input type="url" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/in/username" value="{{ old('linkedin_url') }}">
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="font-weight-bold">Biography & Background</label>
                        <textarea name="about" class="form-control" rows="4" placeholder="Brief professional summary, notable transactions, client advisory focus...">{{ old('about') }}</textarea>
                    </div>

                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-check mr-1"></i> Save Licensed Agent
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
