@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="fw-bold">Dashboard</h4>
        <p class="text-muted">Welcome to the Best4You Administration Panel</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted text-uppercase mb-2">Total Jobs</h6>
                <h2 class="fw-bold text-primary mb-0">{{ $stats['jobs'] ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted text-uppercase mb-2">Applications</h6>
                <h2 class="fw-bold text-success mb-0">{{ $stats['applications'] ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted text-uppercase mb-2">Clients</h6>
                <h2 class="fw-bold text-warning mb-0">{{ $stats['clients'] ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted text-uppercase mb-2">Categories</h6>
                <h2 class="fw-bold text-info mb-0">{{ $stats['categories'] ?? 0 }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom bg-transparent py-3">
                <h5 class="card-title mb-0 fw-bold">Recent Resumes & Applications</h5>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-uppercase" style="font-size: 0.75rem;">Applicant</th>
                            <th class="text-uppercase" style="font-size: 0.75rem;">Contact</th>
                            <th class="text-uppercase" style="font-size: 0.75rem;">Job/Role</th>
                            <th class="text-uppercase" style="font-size: 0.75rem;">Resume</th>
                            <th class="text-uppercase" style="font-size: 0.75rem;">Date</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($recentApplications as $app)
                        <tr>
                            <td>
                                <div class="fw-medium text-dark">{{ $app->name }}</div>
                            </td>
                            <td>
                                <div class="small text-muted">{{ $app->email }}<br>{{ $app->phone }}</div>
                            </td>
                            <td>
                                @if($app->job)
                                    <span class="badge bg-label-primary">{{ $app->job->title }}</span>
                                @else
                                    <span class="badge bg-label-secondary">General Resume</span>
                                @endif
                            </td>
                            <td>
                                @if($app->getFirstMediaUrl('resume'))
                                    <a href="{{ $app->getFirstMediaUrl('resume') }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-download me-1"></i> Download
                                    </a>
                                @else
                                    <span class="text-muted small">No resume attached</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $app->created_at->format('M d, Y') }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No applications or resumes submitted yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-transparent text-center py-3">
                <a href="{{ route('job-applications.index') }}" class="btn btn-sm btn-primary">View All Applications</a>
            </div>
        </div>
    </div>
</div>
@endsection
