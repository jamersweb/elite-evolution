@extends('management.layouts.master')
@section('title')
    Edit Agent - {{ $agent->name }} - {{ config('app.dashboard') }}
@endsection

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Top Action Bar -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
            <h2 class="heading_font mb-1">Edit Agent Profile: {{ $agent->name }}</h2>
            <p class="text-muted small mb-0">Changes saved here are instantly reflected on the public website and direct vanity landing page.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ url($agent->slug) }}" target="_blank" class="btn btn-info mr-1 text-white font-weight-bold" title="Open live public profile in new window">
                <i class="fas fa-external-link-alt mr-1"></i> View Live Page (/{{ $agent->slug }})
            </a>
            <a class="btn btn-secondary" href="{{ route('agents.index') }}">
                <i class="fas fa-arrow-left mr-1"></i> Back to Agents
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger shadow-sm">
            <h6 class="font-weight-bold mb-1"><i class="fas fa-exclamation-triangle mr-1"></i> Please fix the following errors:</h6>
            <ul class="mb-0 small pl-3">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 font-weight-bold text-white">
                <i class="fas fa-user-edit text-warning mr-2"></i> Update Broker Profile & Licensing Credentials
            </h6>
            @if(isset($propertiesCount))
                <span class="badge badge-warning text-dark font-weight-bold">
                    {{ $propertiesCount }} Active Assigned Listings
                </span>
            @endif
        </div>
        <div class="body p-4">
            <form action="{{ route('agents.update', $agent->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Name & Slug -->
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $agent->name) }}" required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Custom Vanity Slug / URL Key</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light text-muted small">{{ url('/') }}/</span>
                            </div>
                            <input type="text" name="slug" class="form-control font-weight-bold text-primary" value="{{ old('slug', $agent->slug) }}" placeholder="graeme">
                        </div>
                        <small class="text-muted">Controls the direct public URL (e.g. <code>{{ url('/') }}/{{ $agent->slug }}</code>).</small>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $agent->email) }}" required>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Leave empty to keep existing password">
                        <small class="text-muted">Only fill if you wish to reset their account password.</small>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">RERA BRN (Broker Reg. Number)</label>
                        <input type="text" name="brn" class="form-control" placeholder="e.g. 78334" value="{{ old('brn', $agent->brn) }}">
                        <small class="text-muted">Required for DLD compliance display.</small>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Designation / Occupation</label>
                        <input type="text" name="occupation" class="form-control" placeholder="e.g. Senior Luxury Property Advisor" value="{{ old('occupation', $agent->occupation) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="+971 56 970 0771" value="{{ old('phone', $agent->phone) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">WhatsApp Number</label>
                        <input type="text" name="whatsapp_no" class="form-control" placeholder="971569700771" value="{{ old('whatsapp_no', $agent->whatsapp_no) }}">
                        <small class="text-muted">Numeric with country code (e.g. 971569700771).</small>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Years of Dubai Experience</label>
                        <input type="text" name="experience" class="form-control" placeholder="e.g. 8+ Years in Prime Dubai Real Estate" value="{{ old('experience', $agent->experience) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Nationality</label>
                        <input type="text" name="nationality" class="form-control" placeholder="e.g. British, Emirati, French" value="{{ old('nationality', $agent->nationality) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Account / Publishing Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ old('status', $agent->status) == 'active' ? 'selected' : '' }}>Active (Visible on Website)</option>
                            <option value="inactive" {{ old('status', $agent->status) == 'inactive' ? 'selected' : '' }}>Inactive (Hidden from Public Website)</option>
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Role Assignment</label>
                        <select name="role" class="form-control">
                            <option value="agent" {{ $agent->hasRole('agent') ? 'selected' : '' }}>Agent (Assigned listings & leads)</option>
                            <option value="eliteagent" {{ $agent->hasRole('eliteagent') ? 'selected' : '' }}>Elite Agent (Full listings & blog access)</option>
                            <option value="Admin" {{ $agent->hasRole('Admin') ? 'selected' : '' }}>Admin (Full system administrator)</option>
                        </select>
                    </div>

                    @php
                        $currentAreas = '';
                        if (!empty($agent->area_tags)) {
                            $decoded = is_string($agent->area_tags) ? json_decode($agent->area_tags, true) : $agent->area_tags;
                            $currentAreas = is_array($decoded) ? implode(', ', $decoded) : $agent->area_tags;
                        }
                    @endphp
                    <div class="col-md-8 form-group">
                        <label class="font-weight-bold">Focus Communities / Prime Enclaves (Comma Separated)</label>
                        <input type="text" name="area_tags" class="form-control" placeholder="Palm Jumeirah, DAMAC Lagoons, Emirates Hills, Dubai Marina" value="{{ old('area_tags', $currentAreas) }}">
                        <small class="text-muted">Separate multiple communities with commas.</small>
                    </div>

                    @php
                        $selectedLangs = [];
                        if (!empty($agent->language_multi_select)) {
                            $decoded = is_string($agent->language_multi_select) ? json_decode($agent->language_multi_select, true) : $agent->language_multi_select;
                            $selectedLangs = is_array($decoded) ? $decoded : [];
                        }
                    @endphp
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Languages Spoken (Select multiple)</label>
                        <select name="language_multi_select[]" class="form-control" multiple style="height: 120px;">
                            @foreach($languages as $lang)
                                <option value="{{ $lang }}" {{ in_array($lang, old('language_multi_select', $selectedLangs)) ? 'selected' : '' }}>{{ $lang }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple languages.</small>
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Agent Headshot / Portrait Photo</label>
                        <div class="d-flex align-items-center mb-2">
                            @if($agent->image)
                                <div class="mr-3 text-center">
                                    <img src="{{ asset('images/media/profile/' . $agent->image) }}" id="current_agent_image" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 2px solid #b38b47;">
                                    <div class="form-check mt-1">
                                        <input type="checkbox" name="remove_image" value="1" id="remove_image" class="form-check-input">
                                        <label for="remove_image" class="form-check-label text-danger small">Remove</label>
                                    </div>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <input type="file" name="image" class="form-control-file" accept="image/*" onchange="previewAgentImage(this)">
                                <small class="text-muted d-block mt-1">Upload new photo to replace current image (JPG, PNG, WebP, max 3MB).</small>
                            </div>
                        </div>
                        <div id="image_preview_box" style="display:none;" class="mt-2">
                            <span class="small text-success d-block mb-1">New Image Preview:</span>
                            <img id="image_preview" src="" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 2px solid #28a745;">
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="font-weight-bold">LinkedIn Profile URL</label>
                        <input type="url" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/in/username" value="{{ old('linkedin_url', $agent->linkedin_url) }}">
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="font-weight-bold">Biography & Professional Summary</label>
                        <textarea name="about" class="form-control" rows="5" placeholder="Specializing in ultra-prime residential assets, waterfront villas, and bespoke off-plan investments across Dubai's most coveted communities...">{{ old('about', $agent->about) }}</textarea>
                        <small class="text-muted">Displays directly on their public profile page.</small>
                    </div>

                    <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                        <a href="{{ url('admin/property?agent_id=' . $agent->id) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-home mr-1"></i> View Assigned Listings ({{ $agent->properties()->count() }})
                        </a>
                        <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold">
                            <i class="fas fa-save mr-1"></i> Save Changes & Update Frontend
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewAgentImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('image_preview').src = e.target.result;
            document.getElementById('image_preview_box').style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
