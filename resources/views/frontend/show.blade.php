@extends('layouts.frontend')

@section('title', $job->title)

@push('styles')
<style>
.job-details-page {
  background: #f4f7fb;
  color: #2C2D3F;
  font-size: 14px;
  min-height: 100vh;
}

.detail-hero {
  background:
    linear-gradient(135deg, rgba(31, 64, 121, 0.92), rgba(44, 45, 63, 0.74)),
    url('{{ asset("frontend/assets/img/slider3.webp") }}') center/cover;
  border-bottom-left-radius: 25px;
  border-bottom-right-radius: 25px;
  color: #fff;
  padding: 55px 0 95px;
}

.breadcrumb-row {
  align-items: center;
  color: rgba(255, 255, 255, 0.78);
  display: flex;
  flex-wrap: wrap;
  font-size: 14px;
  font-weight: 400;
  gap: 10px;
  margin-bottom: 25px;
}

.breadcrumb-row a {
  color: #fff;
  text-decoration: none;
}

.breadcrumb-row a:hover {
  color: #00c6ba;
}

.hero-card {
  align-items: center;
  background: rgba(255, 255, 255, 0.14);
  border: 1px solid rgba(255, 255, 255, 0.24);
  border-radius: 20px;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.16);
  display: grid;
  gap: 20px;
  grid-template-columns: auto 1fr auto;
  padding: 24px;
}

.role-mark {
  align-items: center;
  background: #fff;
  border-radius: 15px;
  color: #1f4079;
  display: flex;
  font-size: 20px;
  font-weight: 600;
  height: 70px;
  justify-content: center;
  width: 70px;
}

.meta-row {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-bottom: 12px;
}

.category-pill,
.code-pill,
.type-pill {
  border-radius: 999px;
  display: inline-flex;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0;
  padding: 6px 12px;
  text-transform: uppercase;
}

.category-pill {
  background: rgba(255, 255, 255, 0.18);
  color: #fff;
}

.code-pill {
  background: #fff;
  color: #1f4079;
}

.type-pill {
  background: #e11d48;
  color: #fff;
}

.role-intro h1 {
  font-size: 38px;
  font-weight: 700;
  letter-spacing: 0;
  line-height: 42px;
  margin-bottom: 14px;
}

.hero-facts {
  display: flex;
  flex-wrap: wrap;
  gap: 12px 24px;
}

.hero-facts span {
  color: rgba(255, 255, 255, 0.84);
  font-size: 14px;
  font-weight: 400;
}

.hero-facts i {
  color: #fff;
  margin-right: 8px;
}

.hero-apply,
.apply-button,
.submit-button {
  align-items: center;
  background: #1f4079;
  border: 0;
  border-radius: 40px;
  color: #fff;
  display: inline-flex;
  font-size: 14px;
  font-weight: 500;
  gap: 10px;
  justify-content: center;
  min-height: 46px;
  padding: 13px 25px;
  transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
}

.hero-apply {
  background: #fff;
  color: #1f4079;
  white-space: nowrap;
}

.hero-apply:hover,
.apply-button:hover,
.submit-button:hover {
  box-shadow: 0 10px 22px rgba(31, 64, 121, 0.2);
  transform: translateY(-2px);
}

.detail-content {
  margin-top: -62px;
  padding-bottom: 70px;
  position: relative;
}

.content-card,
.overview-card {
  background: #fff;
  border: 1px solid #e6edf5;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(32, 48, 73, 0.08);
}

.content-card {
  margin-bottom: 20px;
  padding: 28px;
}

.section-heading span,
.overview-header span {
  color: #1f4079;
  display: inline-block;
  font-size: 13px;
  font-weight: 600;
  letter-spacing: 0;
  margin-bottom: 8px;
  text-transform: uppercase;
}

.section-heading h2,
.overview-header h2 {
  font-size: 24px;
  font-weight: 600;
  margin-bottom: 20px;
}

.job-description {
  color: #526173;
  font-size: 14px;
  line-height: 24px;
}

.job-description ul,
.job-description ol {
  padding-left: 1.2rem;
}

.job-description li {
  margin-bottom: 8px;
}

.skill-cloud {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.skill-cloud span {
  background: #eef2fa;
  border-radius: 999px;
  color: #1f4079;
  font-size: 13px;
  font-weight: 500;
  padding: 8px 13px;
}

.overview-card {
  padding: 22px;
  position: sticky;
  top: 96px;
}

.overview-list {
  list-style: none;
  margin: 0;
  padding: 0;
}

.overview-list li {
  align-items: center;
  background: #f7f9fc;
  border: 1px solid #e8eef5;
  border-radius: 12px;
  display: flex;
  gap: 14px;
  margin-bottom: 12px;
  padding: 13px;
}

.overview-list i {
  align-items: center;
  background: #eef2fa;
  border-radius: 12px;
  color: #1f4079;
  display: flex;
  flex: 0 0 44px;
  height: 44px;
  justify-content: center;
  width: 44px;
}

.overview-list span {
  color: #718096;
  display: block;
  font-size: 12px;
  font-weight: 500;
  text-transform: uppercase;
}

.overview-list strong {
  color: #2C2D3F;
  display: block;
  font-size: 14px;
  margin-top: 2px;
}

.apply-button {
  margin-top: 12px;
  width: 100%;
}

.privacy-note {
  color: #718096;
  font-size: 13px;
  font-weight: 400;
  margin: 14px 0 0;
  text-align: center;
}

.privacy-note i {
  color: #1f4079;
  margin-right: 7px;
}

@media (max-width: 991px) {
  .detail-hero {
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
    padding-bottom: 88px;
  }

  .hero-card {
    grid-template-columns: 1fr;
  }

  .role-mark {
    height: 62px;
    width: 62px;
  }

  .overview-card {
    position: static;
  }
}

@media (max-width: 575px) {
  .role-intro h1 {
    font-size: 30px;
    line-height: 36px;
  }

  .content-card,
  .overview-card,
  .hero-card {
    border-radius: 15px;
  }

  .content-card,
  .overview-card {
    padding: 22px;
  }

  .detail-content {
    margin-top: -46px;
  }
}
</style>
@endpush

@section('content')
<div class="job-details-page">
    <!-- Hero Section -->
    <section class="detail-hero">
        <div class="container">
            <div class="breadcrumb-row">
                <a href="{{ url('/') }}">Home</a>
                <i class="fa fa-angle-right"></i>
                <a href="{{ url('/jobs') }}">Jobs</a>
                <i class="fa fa-angle-right"></i>
                <span>{{ $job->title }}</span>
            </div>

            <div class="hero-card">
                @php
                    $titleParts = array_filter(explode(' ', $job->title));
                    $initials = count($titleParts) > 0 ? strtoupper(substr($titleParts[0], 0, 1)) : 'B4';
                    if(count($titleParts) > 1) $initials .= strtoupper(substr($titleParts[1], 0, 1));
                @endphp
                <div class="role-mark">{{ $initials }}</div>
                <div class="role-intro">
                    <div class="meta-row">
                        @if($job->job_code)
                            <span class="code-pill"><i class="fa fa-hashtag me-1"></i>{{ $job->job_code }}</span>
                        @endif
                        <span class="category-pill">{{ $job->category ? $job->category->name : 'General' }}</span>
                        @if($job->jobType)
                            <span class="type-pill"><i class="fa fa-star me-1"></i>{{ $job->jobType->name }}</span>
                        @endif
                    </div>
                    <h1>{{ $job->title }}</h1>
                    <div class="hero-facts">
                        <span><i class="fa fa-map-marker"></i>{{ $job->location ?: 'Remote' }}</span>
                        <span><i class="fa fa-clock-o"></i>Posted {{ $job->created_at->diffForHumans() }}</span>
                        <span><i class="fa fa-briefcase"></i>
                            @if($job->experience_min !== null)
                                {{ $job->experience_min }}-{{ $job->experience_max ?: '+' }} Yrs
                            @else
                                Any experience
                            @endif
                        </span>
                        @if($job->industryType)
                            <span><i class="fa fa-building"></i>{{ $job->industryType->name }}</span>
                        @endif
                    </div>
                </div>
                <button class="hero-apply btn-apply-trigger" data-toggle="modal" data-target="#applyJobModal">
                    Apply Now
                    <i class="fa fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="detail-content">
        <div class="container">
            <div class="row g-4 align-items-start">
                <!-- Description Card -->
                <div class="col-lg-8">
                    <article class="content-card">
                        <div class="section-heading">
                            <span>Role Description</span>
                            <h2>Responsibilities and expectations</h2>
                        </div>
                        <div class="job-description">
                            {!! $job->roles_and_responsibility ?? 'No description provided.' !!}
                        </div>
                    </article>

                    <!-- Skills Card -->
                    @if($job->skills->count() > 0)
                        <article class="content-card skills-card">
                            <div class="section-heading">
                                <span>Required Skills</span>
                                <h2>What helps you succeed</h2>
                            </div>
                            <div class="skill-cloud">
                                @foreach($job->skills as $skill)
                                    <span>{{ $skill->name }}</span>
                                @endforeach
                            </div>
                        </article>
                    @endif
                </div>

                <!-- Sidebar Overview -->
                <aside class="col-lg-4">
                    <div class="overview-card">
                        <div class="overview-header">
                            <h2>Job Overview</h2>
                            <span>Quick details</span>
                        </div>

                        <ul class="overview-list">
                            <li>
                                <i class="fa fa-money"></i>
                                <div>
                                    <span>Salary Range</span>
                                    <strong>
                                        @if($job->salary_from && $job->salary_to)
                                            {{ $job->currency ? $job->currency->symbol : '$' }}{{ number_format($job->salary_from) }} - {{ number_format($job->salary_to) }}
                                        @else
                                            {{ $job->salary ?: 'Negotiable' }}
                                        @endif
                                    </strong>
                                </div>
                            </li>
                            <li>
                                <i class="fa fa-briefcase"></i>
                                <div>
                                    <span>Job Category</span>
                                    <strong>{{ $job->category ? $job->category->name : 'General' }}</strong>
                                </div>
                            </li>
                            @if($job->industryType)
                                <li>
                                    <i class="fa fa-building"></i>
                                    <div>
                                        <span>Industry Type</span>
                                        <strong>{{ $job->industryType->name }}</strong>
                                    </div>
                                </li>
                            @endif
                            @if($job->jobType)
                                <li>
                                    <i class="fa fa-star"></i>
                                    <div>
                                        <span>Employment Type</span>
                                        <strong>{{ $job->jobType->name }}</strong>
                                    </div>
                                </li>
                            @endif
                            <li>
                                <i class="fa fa-calendar"></i>
                                <div>
                                    <span>Closing Date</span>
                                    <strong>{{ $job->closing_date ? $job->closing_date->format('d/m/Y') : 'Ongoing' }}</strong>
                                </div>
                            </li>
                            <li>
                                <i class="fa fa-map-marker"></i>
                                <div>
                                    <span>Location</span>
                                    <strong>{{ $job->location ?: 'Remote' }}</strong>
                                </div>
                            </li>
                        </ul>

                        <button class="apply-button btn-apply-trigger" data-toggle="modal" data-target="#applyJobModal">
                            Apply for this role
                        </button>
                        <p class="privacy-note"><i class="fa fa-lock"></i>Your application is confidential</p>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</div>

<!-- Apply Job Modal -->
<div class="modal fade" id="applyJobModal" tabindex="-1" aria-labelledby="applyJobModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 20px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);">
            <div class="modal-header border-0 pb-0 pt-4 px-4 d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-uppercase fw-bold text-primary small d-block mb-1" style="font-size: 11px; letter-spacing: 1px;">Application</span>
                    <h3 class="modal-title fw-bold text-dark fs-4" id="applyJobModalLabel">Apply for {{ $job->title }}</h3>
                </div>
                <button type="button" class="close m-0 bg-light p-2 rounded-3 border-0" data-dismiss="modal" aria-label="Close" style="box-shadow: none; font-size: 24px; line-height: 1; opacity: 1;">&times;</button>
            </div>
            <div class="modal-body p-4">
                <form id="applyJobForm" action="{{ url('/apply') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small mb-2">Full Name</label>
                        <input type="text" name="name" class="form-control rounded-3 py-2.5 px-3 border" style="background: #f7f9fc; min-height: 46px;" required value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small mb-2">Email Address</label>
                        <input type="email" name="email" class="form-control rounded-3 py-2.5 px-3 border" style="background: #f7f9fc; min-height: 46px;" required value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small mb-2">Phone Number</label>
                        <input type="tel" name="phone" class="form-control rounded-3 py-2.5 px-3 border" style="background: #f7f9fc; min-height: 46px;" required value="{{ old('phone') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small mb-2">Upload Resume</label>
                        <input type="file" name="resume" class="form-control rounded-3 py-2 px-3 border" style="background: #f7f9fc; min-height: 46px;" accept=".pdf,.doc,.docx" required>
                    </div>
                    
                    <div class="d-flex gap-3 mt-4">
                        <button type="button" class="btn btn-light w-50 py-2.5 rounded-3 fw-semibold text-secondary border-0" data-dismiss="modal" style="background: #f3f6fa;">Cancel</button>
                        <button type="submit" class="btn btn-primary w-50 py-2.5 rounded-3 fw-semibold text-white border-0" style="background: #1f4079;">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#applyJobForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var $form = $(this);
        var $btn = $form.find('button[type="submit"]');
        var originalText = $btn.text();
        
        $btn.html('<span class="spinner-border spinner-border-sm me-2"></span> Processing...').prop('disabled', true);
        
        // Remove existing alerts in modal
        $form.find('.alert').remove();
        
        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'Accept': 'application/json'
            },
            success: function(response) {
                $btn.text(originalText.trim()).prop('disabled', false);
                $form.prepend('<div class="alert alert-success border-success-subtle mb-4"><i class="fa fa-check-circle me-2"></i> ' + response.message + '</div>');
                $form[0].reset();
                setTimeout(function() {
                    $('#applyJobModal').modal('hide');
                    $form.find('.alert').remove();
                }, 3000);
            },
            error: function(xhr) {
                $btn.text(originalText.trim()).prop('disabled', false);
                
                var errorHtml = '<div class="alert alert-danger border-danger-subtle mb-4"><ul class="mb-0">';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorHtml += '<li>' + xhr.responseJSON.message + '</li>';
                } else {
                    errorHtml += '<li>An error occurred. Please try again.</li>';
                }
                errorHtml += '</ul></div>';
                $form.prepend(errorHtml);
            }
        });
    });
});
</script>
@endpush
