@extends('layouts.frontend')

@section('title', 'Jobs')

@push('styles')
<style>
.jobs-page {
  background: #f4f7fb;
  color: #2C2D3F;
  font-size: 14px;
  min-height: 100vh;
}

.jobs-hero {
  background:
    linear-gradient(135deg, rgba(31, 64, 121, 0.92), rgba(44, 45, 63, 0.74)),
    url('{{ asset('frontend/assets/img/slider3.webp') }}') center/cover;
  border-bottom-left-radius: 25px;
  border-bottom-right-radius: 25px;
  color: #fff;
  padding: 70px 0 95px;
  position: relative;
}

.hero-kicker,
.eyebrow {
  color: #1f4079;
  display: inline-flex;
  font-size: 13px;
  font-weight: 600;
  letter-spacing: 0;
  text-transform: uppercase;
}

.jobs-hero .hero-kicker {
  color: #fff;
  margin-bottom: 12px;
}

.jobs-hero h1 {
  font-size: 38px;
  font-weight: 700;
  letter-spacing: 0;
  line-height: 42px;
  margin-bottom: 15px;
  max-width: 650px;
}

.jobs-hero p {
  color: rgba(255, 255, 255, 0.82);
  font-size: 14px;
  line-height: 24px;
  margin: 0;
  max-width: 560px;
}

.hero-stats {
  background: rgba(255, 255, 255, 0.14);
  border: 1px solid rgba(255, 255, 255, 0.24);
  border-radius: 20px;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.16);
  display: grid;
  gap: 12px;
  grid-template-columns: repeat(3, 1fr);
  padding: 12px;
}

.hero-stats div {
  background: rgba(255, 255, 255, 0.13);
  border-radius: 15px;
  padding: 16px 10px;
  text-align: center;
}

.hero-stats strong,
.hero-stats span {
  display: block;
}

.hero-stats strong {
  font-size: 28px;
  line-height: 1;
}

.hero-stats span {
  color: rgba(255, 255, 255, 0.78);
  font-size: 13px;
  margin-top: 7px;
}

.search-dock {
  align-items: stretch;
  background: #fff;
  border-radius: 50px;
  box-shadow: 0 15px 35px rgba(18, 45, 78, 0.18);
  display: grid;
  gap: 6px;
  grid-template-columns: 1fr 1fr auto;
  margin-top: 35px;
  padding: 6px 6px 6px 20px;
}

.search-field {
  align-items: center;
  background: #f3f7fb;
  border: 1px solid #e6eef6;
  border-radius: 40px;
  display: grid;
  gap: 2px 12px;
  grid-template-columns: auto 1fr;
  margin: 0;
  padding: 10px 14px;
}

.search-field i {
  color: #1f4079;
  grid-row: span 2;
}

.search-field span,
.panel-input span {
  color: #718096;
  font-size: 12px;
  font-weight: 500;
  text-transform: uppercase;
}

.search-field input,
.panel-input input {
  background: transparent;
  border: 0;
  color: #2C2D3F;
  font-size: 14px;
  font-weight: 400;
  min-width: 0;
  outline: 0;
  width: 100%;
}

.search-button,
.panel-button,
.empty-state button,
.details-button {
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
  padding: 13px 25px;
  text-decoration: none;
  transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
}

.search-button:hover,
.panel-button:hover,
.empty-state button:hover,
.details-button:hover {
  background: #2C2D3F;
  box-shadow: 0 10px 22px rgba(31, 64, 121, 0.2);
  color: #fff;
  transform: translateY(-2px);
}

.jobs-content {
  margin-top: -62px;
  padding-bottom: 70px;
  position: relative;
}

.filter-panel,
.job-card,
.empty-state,
.results-toolbar {
  background: #fff;
  border: 1px solid #e6edf5;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(32, 48, 73, 0.08);
}

.filter-panel {
  padding: 20px;
  position: sticky;
  top: 96px;
}

.panel-heading,
.results-toolbar,
.job-meta-top,
.job-facts,
.skills-row {
  align-items: center;
  display: flex;
  flex-wrap: wrap;
}

.panel-heading {
  justify-content: space-between;
  margin-bottom: 18px;
}

.panel-heading span {
  font-size: 18px;
  font-weight: 600;
}

.panel-heading button {
  background: #fff1f1;
  border: 0;
  border-radius: 999px;
  color: #d64242;
  font-size: 13px;
  font-weight: 500;
  padding: 6px 12px;
}

.panel-input {
  background: #f7f9fc;
  border: 1px solid #e8eef5;
  border-radius: 12px;
  display: block;
  margin-bottom: 14px;
  padding: 11px 14px;
}

.panel-category {
  margin-bottom: 14px;
}

.panel-category > span {
  color: #718096;
  display: block;
  font-size: 12px;
  font-weight: 500;
  margin-bottom: 9px;
  text-transform: uppercase;
}

.category-options {
  display: grid;
  gap: 8px;
  max-height: 230px;
  overflow-y: auto;
  padding-right: 3px;
}

.category-options a {
  align-items: center;
  background: #f7f9fc;
  border: 1px solid #e8eef5;
  border-radius: 12px;
  color: #526173;
  display: flex;
  font-size: 14px;
  font-weight: 500;
  justify-content: space-between;
  line-height: 20px;
  min-height: 42px;
  padding: 10px 13px;
  text-align: left;
  transition: all 0.2s ease;
  width: 100%;
}

.category-options a::after {
  border: 1px solid #cbd5e1;
  border-radius: 50%;
  content: "";
  flex: 0 0 14px;
  height: 14px;
  margin-left: 10px;
  width: 14px;
}

.category-options a:hover {
  border-color: rgba(31, 64, 121, 0.35);
  color: #1f4079;
}

.category-options a.active {
  background: #eef2fa;
  border-color: rgba(31, 64, 121, 0.35);
  color: #1f4079;
}

.category-options a.active::after {
  background: #1f4079;
  border-color: #1f4079;
  box-shadow: inset 0 0 0 3px #fff;
}

.panel-button {
  min-height: 46px;
  width: 100%;
}

.support-card {
  background: #f6f8fb;
  border-radius: 15px;
  margin-top: 20px;
  padding: 20px;
}

.support-card i {
  color: #1f4079;
  font-size: 24px;
}

.support-card h3 {
  font-size: 18px;
  font-weight: 600;
  margin: 12px 0 8px;
}

.support-card p {
  color: #65758b;
  font-size: 14px;
  line-height: 24px;
}

.support-card a {
  color: #1f4079;
  font-weight: 500;
}

.results-toolbar {
  justify-content: space-between;
  margin-bottom: 18px;
  padding: 18px 22px;
}

.results-toolbar h2 {
  font-size: 24px;
  font-weight: 600;
  margin: 5px 0 0;
}

.toolbar-note {
  background: #f0fbf5;
  border-radius: 999px;
  color: #228a53;
  font-size: 13px;
  font-weight: 500;
  padding: 8px 14px;
}

.job-list {
  display: grid;
  gap: 18px;
}

.job-card {
  display: grid;
  gap: 22px;
  grid-template-columns: auto 1fr auto;
  overflow: hidden;
  padding: 22px;
  position: relative;
  transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}

.job-card:hover {
  border-color: rgba(31, 64, 121, 0.25);
  box-shadow: 0 15px 35px rgba(32, 48, 73, 0.12);
  transform: translateY(-3px);
}

.job-card-accent {
  background: linear-gradient(180deg, #1f4079, #d81f34);
  border-radius: 0 999px 999px 0;
  bottom: 22px;
  left: 0;
  position: absolute;
  top: 22px;
  width: 6px;
}

.company-mark {
  align-items: center;
  background: #eef2fa;
  border: 1px solid #dfe6f2;
  border-radius: 15px;
  color: #1f4079;
  display: flex;
  font-weight: 600;
  height: 56px;
  justify-content: center;
  width: 56px;
}

.job-meta-top {
  gap: 12px;
  margin-bottom: 12px;
}

.job-meta-top span:not(.category-pill) {
  color: #718096;
  font-size: 13px;
  font-weight: 400;
}

.job-meta-top i,
.job-facts i {
  color: #1f4079;
  margin-right: 7px;
}

.category-pill,
.code-pill,
.type-pill {
  border-radius: 999px;
  font-size: 12px;
  font-weight: 600;
  padding: 7px 12px;
  text-transform: uppercase;
}

.category-pill {
  background: #eef2fa;
  color: #1f4079;
}

.code-pill {
  background: #f1f5f9;
  color: #475569;
}

.type-pill {
  background: #fff1f2;
  color: #e11d48;
}

.job-card h3 {
  font-size: 20px;
  font-weight: 600;
  margin-bottom: 11px;
}

.job-card h3 a {
  color: #2C2D3F;
  text-decoration: none;
}

.job-card h3 a:hover {
  color: #1f4079;
}

.job-facts {
  color: #526173;
  gap: 12px 22px;
  font-size: 14px;
  font-weight: 400;
  margin-bottom: 16px;
}

.skills-row {
  gap: 8px;
}

.skills-row span {
  background: #f3f6fa;
  border-radius: 999px;
  color: #536275;
  font-size: 13px;
  font-weight: 500;
  padding: 7px 11px;
}

.skills-row .more-skills {
  background: #fff7e7;
  color: #9a6a09;
}

.skills-row .muted-skill {
  background: transparent;
  color: #8a98a8;
  padding-left: 0;
}

.job-card-action {
  align-items: center;
  display: flex;
}

.details-button {
  min-height: 44px;
  padding: 10px 18px;
  white-space: nowrap;
}
.empty-state {
    padding: 60px 20px;
    text-align: center;
}
.empty-icon {
    font-size: 40px;
    color: #cbd5e1;
    margin-bottom: 20px;
}

/* Responsive Design Adaptations */

@media (max-width: 991px) {
  .jobs-hero {
    padding: 50px 0 80px;
    text-align: center;
    border-bottom-left-radius: 15px;
    border-bottom-right-radius: 15px;
  }

  .jobs-hero h1 {
    font-size: 30px;
    line-height: 36px;
    margin: 0 auto 15px;
  }

  .jobs-hero p {
    margin: 0 auto;
  }

  .hero-stats {
    margin-top: 25px;
  }

  .search-dock {
    grid-template-columns: 1fr;
    border-radius: 20px;
    padding: 15px;
    gap: 12px;
  }

  .search-field {
    padding: 12px 16px;
  }

  .search-button {
    width: 100%;
    border-radius: 40px;
  }

  .jobs-content {
    margin-top: -40px;
  }

  .filter-toggle-btn {
    align-items: center;
    background: #1f4079;
    border: 0;
    border-radius: 12px;
    color: #fff;
    display: flex;
    font-size: 15px;
    font-weight: 600;
    gap: 10px;
    justify-content: center;
    padding: 12px 20px;
    width: 100%;
    margin-bottom: 16px;
    box-shadow: 0 4px 12px rgba(31, 64, 121, 0.15);
    transition: background 0.2s ease, transform 0.2s ease;
  }

  .filter-toggle-btn:hover,
  .filter-toggle-btn:focus {
    background: #2C2D3F;
    color: #fff;
    text-decoration: none;
    outline: none;
  }

  .filter-toggle-btn i {
    font-size: 14px;
  }

  .filter-toggle-btn[aria-expanded="true"] .toggle-text::before {
    content: "Hide ";
  }

  .filter-toggle-btn[aria-expanded="false"] .toggle-text::before {
    content: "Show ";
  }
}

@media (max-width: 767px) {
  .job-card {
    grid-template-columns: auto 1fr;
    gap: 16px;
    padding: 20px;
  }

  .job-card-accent {
    bottom: 0;
    top: 0;
    border-radius: 0;
  }

  .company-mark {
    height: 48px;
    width: 48px;
    font-size: 14px;
  }

  .job-card-action {
    grid-column: span 2;
    margin-top: 8px;
    width: 100%;
  }

  .details-button {
    width: 100%;
    justify-content: center;
  }

  .job-facts {
    gap: 8px 14px;
    font-size: 13px;
    margin-bottom: 12px;
  }
  
  .job-meta-top {
    gap: 8px;
    margin-bottom: 8px;
  }
}

@media (max-width: 576px) {
  .hero-stats {
    grid-template-columns: 1fr;
    gap: 10px;
  }

  .results-toolbar {
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
    padding: 15px 20px;
  }

  .results-toolbar h2 {
    font-size: 20px;
  }
}

@media (max-width: 480px) {
  .job-card {
    grid-template-columns: 1fr;
    gap: 12px;
  }

  .job-card-action {
    grid-column: span 1;
  }
}
</style>
@endpush

@section('content')
<div class="jobs-page">
    <section class="jobs-hero">
      <div class="container">
        <div class="row align-items-center g-4">
          <div class="col-lg-7">
            <span class="hero-kicker">BestForYou Careers</span>
            <h1>Find a role that fits your next chapter.</h1>
            <p>
              Explore curated openings, compare role details quickly, and apply with confidence.
            </p>
          </div>
          <div class="col-lg-5">
            <div class="hero-stats">
              <div>
                <strong>{{ $jobs->total() }}</strong>
                <span>Open roles</span>
              </div>
              <div>
                <strong>{{ $jobs->pluck('location')->filter()->unique()->count() ?: 1 }}</strong>
                <span>Locations</span>
              </div>
              <div>
                <strong>{{ $categories->count() }}</strong>
                <span>Categories</span>
              </div>
            </div>
          </div>
        </div>

        <form class="search-dock" action="{{ url('/jobs') }}" method="GET">
          <label class="search-field">
            <i class="fa fa-search"></i>
            <span>What</span>
            <input
              name="search"
              type="text"
              placeholder="Job title, skill, keyword"
              value="{{ request('search') }}"
            >
          </label>
          <label class="search-field">
            <i class="fa fa-map-marker"></i>
            <span>Where</span>
            <input
              name="location"
              type="text"
              placeholder="City, state, remote"
              value="{{ request('location') }}"
            >
          </label>
          <button type="submit" class="search-button">
            Search Jobs
            <i class="fa fa-arrow-right"></i>
          </button>
        </form>
      </div>
    </section>

    <section class="jobs-content">
      <div class="container">

        <div class="row g-4 align-items-start">
          <aside class="col-xl-3 col-lg-4">
            <button class="filter-toggle-btn d-lg-none" type="button" data-toggle="collapse" data-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
              <i class="fa fa-filter"></i> <span class="toggle-text">Filters</span>
            </button>
            <div class="collapse d-lg-block" id="filterCollapse">
              <form action="{{ url('/jobs') }}" method="GET" class="filter-panel">
              <div class="panel-heading">
                <span>Refine Search</span>
                @if(request()->hasAny(['search', 'location', 'category_id', 'region', 'region_id']))
                <a href="{{ url('/jobs') }}" class="btn btn-sm btn-light text-danger rounded-pill px-3">
                  Clear
                </a>
                @endif
              </div>

              <label class="panel-input">
                <span>Keywords</span>
                <input name="search" type="text" placeholder="UI designer, sales, PHP" value="{{ request('search') }}">
              </label>

              <label class="panel-input">
                <span>Location</span>
                <input name="location" type="text" placeholder="Kozhikode, Kochi, Remote" value="{{ request('location') }}">
              </label>

              <label class="panel-input">
                <span>Region</span>
                <select name="region" onchange="this.form.submit()">
                  <option value="">All Regions</option>
                  @foreach($regions as $region)
                    <option value="{{ $region->slug }}" {{ (request('region_id') == $region->id || request('region') == $region->slug) ? 'selected' : '' }}>
                      {{ $region->name }}
                    </option>
                  @endforeach
                </select>
              </label>

              <div class="panel-category">
                <span>Category</span>
                <input type="hidden" name="category_id" id="category_input" value="{{ request('category_id') }}">
                <div class="category-options">
                  <a
                    href="{{ request()->fullUrlWithQuery(['category_id' => '']) }}"
                    class="{{ !request('category_id') ? 'active' : '' }}"
                  >
                    All categories
                  </a>
                  @foreach($categories as $category)
                  <a
                    href="{{ request()->fullUrlWithQuery(['category_id' => $category->id]) }}"
                    class="{{ request('category_id') == $category->id ? 'active' : '' }}"
                  >
                    {{ $category->name }}
                  </a>
                  @endforeach
                </div>
              </div>

              <button type="submit" class="panel-button mt-3">
                Apply Filters
              </button>

              <div class="support-card">
                <i class="fa fa-file-text-o"></i>
                <h3>Stand out faster</h3>
                <p>Upload your resume and let our recruiters match you with relevant openings.</p>
                <a href="{{ url('/upload-resume') }}">Upload Resume</a>
              </div>
              </form>
            </div>
          </aside>

          <div class="col-xl-9 col-lg-8">
            <div class="results-toolbar">
              <div>
                <span class="eyebrow">Available opportunities</span>
                <h2>{{ $jobs->total() }} {{ $jobs->total() === 1 ? 'role' : 'roles' }} found</h2>
              </div>
              <div class="toolbar-note">
                <i class="fa fa-bolt"></i>
                Updated regularly
              </div>
            </div>

            @if($jobs->count() > 0)
            <div class="job-list">
              @foreach($jobs as $job)
              <article class="job-card">
                <div class="job-card-accent"></div>
                <div class="company-mark">
                    @php
                        $titleParts = array_filter(explode(' ', $job->title));
                        $initials = count($titleParts) > 0 ? strtoupper(substr($titleParts[0], 0, 1)) : 'B4';
                        if(count($titleParts) > 1) $initials .= strtoupper(substr($titleParts[1], 0, 1));
                    @endphp
                    {{ $initials }}
                </div>

                <div class="job-card-main">
                  <div class="job-meta-top">
                    @if($job->job_code)
                        <span class="code-pill"><i class="fa fa-hashtag"></i>{{ $job->job_code }}</span>
                    @endif
                    <span class="category-pill">{{ $job->category ? $job->category->name : 'General' }}</span>
                    @if($job->region)
                        <span class="category-pill region-badge-outline"><i class="fa fa-globe"></i> {{ $job->region->name }}</span>
                    @endif
                    @if($job->jobType)
                        <span class="type-pill"><i class="fa fa-star"></i>{{ $job->jobType->name }}</span>
                    @endif
                    <span><i class="fa fa-clock-o"></i>{{ $job->created_at->diffForHumans() }}</span>
                  </div>

                  <h3>
                    <a href="{{ url('/jobs/' . $job->job_code) }}">
                      {{ $job->title }}
                    </a>
                  </h3>

                  <div class="job-facts">
                    <span><i class="fa fa-map-marker"></i>{{ $job->location ?: 'Remote' }}</span>
                    <span><i class="fa fa-briefcase"></i>
                        @if($job->experience_min !== null)
                            {{ $job->experience_min }}-{{ $job->experience_max ?: '+' }} Yrs
                        @else
                            Any experience
                        @endif
                    </span>
                    @if($job->industryType)
                        <span><i class="fa fa-building-o"></i>{{ $job->industryType->name }}</span>
                    @endif
                    <span><i class="fa fa-money"></i>
                        @if($job->salary_from && $job->salary_to)
                            {{ $job->currency ? $job->currency->symbol : '$' }}{{ number_format($job->salary_from) }} - {{ number_format($job->salary_to) }}
                        @else
                            Competitive
                        @endif
                    </span>
                  </div>

                  <div class="skills-row">
                    @foreach($job->skills->take(5) as $skill)
                        <span>{{ $skill->name }}</span>
                    @endforeach
                    @if($job->skills->count() > 5)
                        <span class="more-skills">+{{ $job->skills->count() - 5 }} more</span>
                    @endif
                    @if($job->skills->count() == 0)
                        <span class="muted-skill">Skills not listed</span>
                    @endif
                  </div>
                </div>

                <div class="job-card-action">
                  <a href="{{ url('/jobs/' . $job->job_code) }}" class="details-button">
                    View Details
                    <i class="fa fa-arrow-right"></i>
                  </a>
                </div>
              </article>
              @endforeach
            </div>
            
            <div class="mt-4 d-flex justify-content-center">
                {{ $jobs->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
            @else
            <div class="empty-state">
              <div class="empty-icon"><i class="fa fa-search"></i></div>
              <h3>No matching jobs found</h3>
              <p>Try another keyword, location, or reset the filters to see every open role.</p>
              <a href="{{ url('/jobs') }}" class="btn btn-outline-primary mt-3 rounded-pill px-4">Reset Search</a>
            </div>
            @endif
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
