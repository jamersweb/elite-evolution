@extends('management.layouts.master')
@section('title')
    Add Licensed Agent - {{ config('app.dashboard') }}
@endsection

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="heading_font mb-1">Add Licensed Real Estate Broker</h2>
            <p class="text-muted small mb-0">Create a new licensed agent profile. It will automatically publish to the website directory and create their custom vanity landing page.</p>
        </div>
        <a class="btn btn-secondary" href="{{ route('agents.index') }}">
            <i class="fas fa-arrow-left mr-1"></i> Back to Agents
        </a>
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
        <div class="card-header bg-dark text-white py-3">
            <h6 class="mb-0 font-weight-bold text-white"><i class="fas fa-user-plus text-warning mr-2"></i> Agent Identity & Regulatory Information</h6>
        </div>
        <div class="body p-4">
            <form action="{{ route('agents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Basic Info -->
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="agent_name" class="form-control" placeholder="e.g. Graeme Stewart" value="{{ old('name') }}" required>
                        <small class="text-muted">Displayed prominently across listing cards and detail pages.</small>
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Custom Vanity Slug / URL Key</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light text-muted small">{{ url('/') }}/</span>
                            </div>
                            <input type="text" name="slug" id="agent_slug" class="form-control" placeholder="graeme" value="{{ old('slug') }}">
                        </div>
                        <small class="text-muted">Direct public URL (e.g. <code>{{ url('/') }}/graeme</code>). Leave empty to auto-generate from name.</small>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="graeme@eliteevolutionrealestate.ae" value="{{ old('email') }}" required>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required minlength="6">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">RERA BRN (Broker Reg. Number)</label>
                        <input type="text" name="brn" class="form-control" placeholder="e.g. 78334" value="{{ old('brn') }}">
                        <small class="text-muted">Required by Dubai Land Department (DLD) for compliance.</small>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Designation / Occupation</label>
                        <input type="text" name="occupation" class="form-control" placeholder="e.g. Senior Luxury Property Advisor" value="{{ old('occupation') }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="+971 56 970 0771" value="{{ old('phone') }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">WhatsApp Number</label>
                        <input type="text" name="whatsapp_no" class="form-control" placeholder="971569700771" value="{{ old('whatsapp_no') }}">
                        <small class="text-muted">Numeric with country code (no '+' or spaces), used for 1-click WhatsApp buttons.</small>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Years of Dubai Experience</label>
                        <input type="text" name="experience" class="form-control" placeholder="e.g. 8+ Years in Prime Dubai Real Estate" value="{{ old('experience') }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Nationality</label>
                        <input type="text" name="nationality" class="form-control" placeholder="e.g. British, Emirati, French" value="{{ old('nationality') }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Account / Publishing Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active (Immediately Visible on Website)</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive (Hidden from Public Website)</option>
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Role Assignment</label>
                        <select name="role" class="form-control">
                            <option value="agent">Agent (Manages assigned listings & leads)</option>
                            <option value="eliteagent">Elite Agent (Full listings & blog access)</option>
                            <option value="Admin">Admin (Full system administrator)</option>
                        </select>
                    </div>

                    <div class="col-md-8 form-group">
                        <label class="font-weight-bold">Focus Communities / Prime Enclaves (Comma Separated)</label>
                        <input type="text" name="area_tags" class="form-control" placeholder="Palm Jumeirah, DAMAC Lagoons, Emirates Hills, Dubai Marina" value="{{ old('area_tags') }}">
                        <small class="text-muted">These appear as filter tags and badges on the broker's profile.</small>
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Languages Spoken (Select multiple)</label>
                        <select name="language_multi_select[]" class="form-control" multiple style="height: 120px;">
                            @foreach($languages as $lang)
                                <option value="{{ $lang }}" {{ is_array(old('language_multi_select')) && in_array($lang, old('language_multi_select')) ? 'selected' : '' }}>{{ $lang }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple languages.</small>
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">Agent Headshot / Portrait Photo</label>
                        <input type="file" name="image" class="form-control-file" accept="image/*" onchange="previewAgentImage(this)">
                        <small class="text-muted d-block mb-2">High-resolution square portrait recommended (e.g. 600x600px, JPG/PNG/WebP, max 3MB).</small>
                        <div id="image_preview_box" style="display:none;">
                            <img id="image_preview" src="" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #b38b47;">
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="font-weight-bold">LinkedIn Profile URL</label>
                        <input type="url" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/in/username" value="{{ old('linkedin_url') }}">
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="font-weight-bold">Biography & Professional Summary</label>
                        <textarea name="about" class="form-control" rows="5" placeholder="Specializing in ultra-prime residential assets, waterfront villas, and bespoke off-plan investments across Dubai's most coveted communities...">{{ old('about') }}</textarea>
                        <small class="text-muted">Appears in the "About the Broker" section on the frontend agent profile.</small>
                    </div>

                    <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                        <span class="text-muted small">
                            <i class="fas fa-info-circle text-primary mr-1"></i> Once saved, this agent will automatically appear in the public <strong>Brokers & Agents</strong> directory and their personal vanity page will be accessible.
                        </span>
                        <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold">
                            <i class="fas fa-check mr-1"></i> Save & Publish Agent Profile
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
