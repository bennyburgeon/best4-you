@extends('layouts.admin')

@section('title', 'Post New Job')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<!-- Quill Theme CSS -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('public/admin/assets/css/jobs.css') }}" />
@endpush

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header border-bottom">
        <h5 class="mb-0 fw-bold">Create Job Vacancy</h5>
    </div>
    <div class="card-body pt-4">
        <form action="{{ route('jobs.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <!-- Row 1 -->
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;">Job Code</label>
                    <input type="text" class="form-control bg-light" readonly placeholder="Auto-generated on save" />
                </div>
                <div class="col-12 col-md-8 mb-3">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="title">Position Title *</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required />
                </div>

                <!-- Row 2 -->
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="industry_type_id">Industry Type</label>
                    <select class="form-select select2" id="industry_type_id" name="industry_type_id" data-placeholder="Choose Industry">
                        <option value=""></option>
                        @foreach($industryTypes as $ind)
                            <option value="{{ $ind->id }}" {{ old('industry_type_id') == $ind->id ? 'selected' : '' }}>{{ $ind->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="job_category_id">Job Category *</label>
                    <select class="form-select select2" id="job_category_id" name="job_category_id" required data-placeholder="Choose Category">
                        <option value=""></option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('job_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="job_type_id">Job Type</label>
                    <select class="form-select select2" id="job_type_id" name="job_type_id" data-placeholder="Choose Job Type">
                        <option value=""></option>
                        @foreach($jobTypes as $type)
                            <option value="{{ $type->id }}" {{ old('job_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Row 3 -->
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="gender_preference">Gender Preference</label>
                    <select class="form-select select2" id="gender_preference" name="gender_preference" data-minimum-results-for-search="Infinity">
                        <option value="No Preference" {{ old('gender_preference') == 'No Preference' ? 'selected' : '' }}>No Preference</option>
                        <option value="Male" {{ old('gender_preference') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender_preference') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="client_id">Linked Client</label>
                    <select class="form-select select2" id="client_id" name="client_id" data-placeholder="Choose Client">
                        <option value=""></option>
                        @foreach($clientsList as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="company">Fallback Company Name</label>
                    <input type="text" class="form-control" id="company" name="company" value="{{ old('company') }}" />
                </div>

                <!-- Row 4 -->
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" />
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="region_id">Job Region</label>
                    <select class="form-select select2" id="region_id" name="region_id" data-placeholder="Choose Region">
                        <option value=""></option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="opening_date">Opening Date</label>
                    <input type="date" class="form-control" id="opening_date" name="opening_date" value="{{ old('opening_date') }}" />
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="closing_date">Closing Date</label>
                    <input type="date" class="form-control" id="closing_date" name="closing_date" value="{{ old('closing_date') }}" />
                </div>

                <!-- Row 5 -->
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="currency_id">Salary Currency</label>
                    <select class="form-select select2" id="currency_id" name="currency_id" data-placeholder="Choose Currency">
                        <option value=""></option>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ old('currency_id') == $currency->id ? 'selected' : '' }}>{{ $currency->name }} ({{ $currency->symbol }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label text-uppercase text-muted w-100" style="font-size: 0.75rem; letter-spacing: 0.5px;">Experience Range (Yrs)</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="experience_min" placeholder="Min" value="{{ old('experience_min') }}">
                        <span class="input-group-text">to</span>
                        <input type="number" class="form-control" name="experience_max" placeholder="Max" value="{{ old('experience_max') }}">
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label text-uppercase text-muted w-100" style="font-size: 0.75rem; letter-spacing: 0.5px;">Salary Range</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="salary_from" placeholder="Min" value="{{ old('salary_from') }}">
                        <span class="input-group-text">to</span>
                        <input type="number" class="form-control" name="salary_to" placeholder="Max" value="{{ old('salary_to') }}">
                    </div>
                </div>

                <!-- Row 6 -->
                <div class="col-12 mb-3">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="skills">Key Skills</label>
                    <select class="form-select select2-tags" id="skills" name="skills[]" multiple="multiple" data-placeholder="Type and press enter to add new skills">
                        @foreach($skills as $skill)
                            <option value="{{ $skill->id }}" {{ (is_array(old('skills')) && in_array($skill->id, old('skills'))) ? 'selected' : '' }}>{{ $skill->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Row 7 -->
                <div class="col-12 mb-3">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="roles_and_responsibility">Roles and Responsibilities</label>
                    <textarea class="form-control" id="roles_and_responsibility" name="roles_and_responsibility" rows="5">{{ old('roles_and_responsibility') }}</textarea>
                </div>

                <!-- Row 8 -->
                <div class="col-12 col-md-6 mb-3">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="hr_incharge">In-charge HR Name</label>
                    <input type="text" class="form-control" id="hr_incharge" name="hr_incharge" value="{{ old('hr_incharge') }}" />
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="email">Contact Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" />
                </div>
            </div>
            
            <div class="border-top pt-3 d-flex justify-content-end gap-2">
                <a href="{{ route('jobs.index') }}" class="btn btn-label-secondary" style="background-color: #f5f5f9; color: #697a8d;">Cancel</a>
                <button type="submit" class="btn btn-primary">Publish Vacancy</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Quill JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="{{ asset('public/admin/assets/js/jobs.js') }}"></script>
@endpush
