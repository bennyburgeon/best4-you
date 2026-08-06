@extends('layouts.admin')

@section('title', 'Job Applications')

@section('navbar_content')
<div class="d-flex justify-content-between align-items-center w-100 me-3">
    <div class="d-flex flex-column justify-content-center">
        <h5 class="mb-0 fw-bold text-dark" style="font-size: 1.1rem; line-height: 1.2;">Job Applications</h5>
        <small class="text-muted" style="font-size: 0.8rem; line-height: 1.2;">Review submitted resumes and candidate details</small>
    </div>
</div>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Collapsible Search Accordion --}}
        @include('admin.partials.search-accordion', [
            'fields' => [
                [
                    'name' => 'search_query',
                    'label' => 'Applicant Search',
                    'placeholder' => 'Search by Name or Contact Number',
                    'class' => 'col-md-4'
                ],
                [
                    'name' => 'job_id',
                    'label' => 'Job Applied For',
                    'type' => 'select',
                    'options' => $jobs->mapWithKeys(function($job) {
                        return [$job->id => ($job->job_code ? '[' . $job->job_code . '] ' : '') . $job->title];
                    })->toArray(),
                    'class' => 'col-md-5'
                ],
                [
                    'name' => 'date_range',
                    'label' => 'Date Applied',
                    'placeholder' => 'Select Date Range',
                    'class' => 'col-md-3'
                ]
            ]
        ])

        <div class="table-responsive text-nowrap rounded-3 border">
            <table class="table table-hover mb-0" id="applicationTable">
                <thead class="table-light">
                    <tr>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Applicant</th>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Contact</th>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Job Applied For</th>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Resume</th>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Applied At</th>
                        <th class="text-uppercase text-center" style="font-size: 0.75rem; width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    {{-- Loaded dynamically --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.partials.datatable-assets')

@endsection

@push('scripts')
<script>
    $(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        function escapeHtml(text) {
            if (!text) return '';
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        function formatDate(dateStr) {
            if (!dateStr) return 'N/A';
            var date = new Date(dateStr);
            if (isNaN(date.getTime())) return 'N/A';
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return months[date.getMonth()] + ' ' + String(date.getDate()).padStart(2, '0') + ', ' + date.getFullYear();
        }

        function formatTime(dateStr) {
            if (!dateStr) return '';
            var date = new Date(dateStr);
            if (isNaN(date.getTime())) return '';
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0'+minutes : minutes;
            return hours + ':' + minutes + ' ' + ampm;
        }

        var columnsConfig = [
            { 
                data: 'name', 
                name: 'name',
                render: function(data, type, row) {
                    return '<div>' +
                        '<div class="fw-medium text-dark">' + escapeHtml(data) + '</div>' +
                        '<small class="text-muted">ID: ' + row.id + '</small>' +
                        '</div>';
                }
            },
            { 
                data: null, 
                orderable: false,
                render: function(data, type, row) {
                    return '<div class="small">' +
                        '<div class="text-muted"><i class="bx bx-envelope me-1"></i>' + escapeHtml(row.email) + '</div>' +
                        '<div class="text-muted"><i class="bx bx-phone me-1"></i>' + escapeHtml(row.phone) + '</div>' +
                        '</div>';
                }
            },
            { 
                data: 'job', 
                name: 'job.title',
                orderable: false,
                render: function(data, type, row) {
                    if (data) {
                        var codeHtml = data.job_code ? '<small class="badge bg-label-primary">' + escapeHtml(data.job_code) + '</small>' : '';
                        return '<div>' +
                            '<div class="fw-medium">' + escapeHtml(data.title) + '</div>' +
                            codeHtml +
                            '</div>';
                    }
                    return '<span class="badge bg-label-secondary">General Application (Resume Upload)</span>';
                }
            },
            { 
                data: 'resume_url', 
                name: 'resume_url',
                orderable: false,
                render: function(data) {
                    if (data) {
                        return '<a href="' + data + '" target="_blank" class="btn btn-sm btn-outline-primary">' +
                            '<i class="bx bx-download me-1"></i> Download' +
                            '</a>';
                    }
                    return '<span class="text-muted small">No resume attached</span>';
                }
            },
            { 
                data: 'created_at', 
                name: 'created_at',
                render: function(data) {
                    return '<small class="text-muted">' + formatDate(data) + '</small>' +
                        '<div class="small text-muted">' + formatTime(data) + '</div>';
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    var deleteUrl = '{{ route("job-applications.destroy", ":id") }}'.replace(':id', row.id);
                    
                    return '<form action="' + deleteUrl + '" method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this application?\');">' +
                        '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                        '<input type="hidden" name="_method" value="DELETE">' +
                        '<button type="submit" class="btn btn-sm btn-icon btn-danger" title="Delete">' +
                        '<i class="bx bx-trash"></i>' +
                        '</button>' +
                        '</form>';
                }
            }
        ];

        initializeAdminDataTable('#applicationTable', '{{ route("job-applications.index") }}', columnsConfig, '#searchForm', [[4, 'desc']]);
    });
</script>
@endpush
