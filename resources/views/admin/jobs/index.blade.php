@extends('layouts.admin')

@section('title', 'Jobs')

@section('navbar_content')
<div class="d-flex justify-content-between align-items-center w-100 me-3">
    <div class="d-flex flex-column justify-content-center">
        <h5 class="mb-0 fw-bold text-dark" style="font-size: 1.1rem; line-height: 1.2;">Live Vacancies</h5>
        <small class="text-muted" style="font-size: 0.8rem; line-height: 1.2;">Management of active job listings</small>
    </div>
    <a href="{{ route('jobs.create') }}" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Post New Job
    </a>
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
                    'label' => 'Job Search',
                    'placeholder' => 'Search by Job Code or Title',
                    'class' => 'col-md-3'
                ],
                [
                    'name' => 'client_id',
                    'label' => 'Company',
                    'type' => 'select',
                    'options' => $clients->pluck('title', 'id')->toArray(),
                    'class' => 'col-md-3'
                ],
                [
                    'name' => 'industry_type_id',
                    'label' => 'Industry',
                    'type' => 'select',
                    'options' => $industryTypes->pluck('name', 'id')->toArray(),
                    'class' => 'col-md-3'
                ],
                [
                    'name' => 'date_range',
                    'label' => 'Date Range',
                    'placeholder' => 'Select Date Range',
                    'class' => 'col-md-3'
                ]
            ]
        ])

        <div class="table-responsive text-nowrap rounded-3 border">
            <table class="table table-hover mb-0" id="jobTable">
                <thead class="table-light">
                    <tr>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Code</th>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Title</th>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Company</th>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Industry</th>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Dates</th>
                        <th class="text-uppercase text-center" style="font-size: 0.75rem; width: 220px;">Actions</th>
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

        var columnsConfig = [
            { 
                data: 'job_code', 
                name: 'job_code',
                render: function(data) {
                    return '<span class="badge bg-label-primary">' + escapeHtml(data || 'N/A') + '</span>';
                }
            },
            { 
                data: 'title', 
                name: 'title',
                className: 'fw-medium'
            },
            { 
                data: 'client', 
                name: 'client.title',
                orderable: false,
                render: function(data, type, row) {
                    return data ? escapeHtml(data.title) : escapeHtml(row.company || '-');
                }
            },
            { 
                data: 'industry_type', 
                name: 'industryType.name',
                orderable: false,
                render: function(data) {
                    return data ? escapeHtml(data.name) : '-';
                }
            },
            { 
                data: null, 
                orderable: false,
                render: function(data, type, row) {
                    var openStr = row.opening_date ? formatDate(row.opening_date) : 'N/A';
                    var closeStr = row.closing_date ? formatDate(row.closing_date) : 'N/A';
                    
                    return '<div class="small">' +
                        '<div class="text-success"><i class="bx bx-calendar-check me-1"></i>' + openStr + '</div>' +
                        '<div class="text-danger"><i class="bx bx-calendar-x me-1"></i>' + closeStr + '</div>' +
                        '</div>';
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    var escapedTitle = escapeHtml(row.title).replace(/'/g, "\\'");
                    var escapedCode = escapeHtml(row.job_code || 'N/A').replace(/'/g, "\\'");
                    
                    // Format description for copy button
                    var cleanDesc = (row.roles_and_responsibility || '')
                        .replace(/<p>|<\/p>|<div>|<\/div>|<li>|<\/li>|<br>|<br\/>|<br \/>/g, '\n')
                        .replace(/•/g, '\n• ')
                        .replace(/<[^>]*>/g, '')
                        .replace(/\n+/g, '\n')
                        .trim();
                    var escapedDesc = escapeHtml(cleanDesc).replace(/'/g, "\\'");
                        
                    var skillsStr = (row.skills || []).map(function(s) { return s.name; }).join(', ') || 'N/A';
                    var escapedSkills = escapeHtml(skillsStr).replace(/'/g, "\\'");
                    
                    var categoryName = row.category ? row.category.name : 'N/A';
                    var jobTypeName = row.job_type ? row.job_type.name : 'N/A';
                    var industryName = row.industry_type ? row.industry_type.name : 'N/A';
                    var clientName = row.client ? row.client.title : (row.company || 'N/A');
                    
                    var expMin = row.experience_min;
                    var expMax = row.experience_max;
                    var experienceStr = (expMin !== null && expMax !== null) ? (expMin + ' - ' + expMax + ' years') : 'Not Specified';
                    
                    var currencySymbol = row.currency ? row.currency.symbol : '$';
                    var salaryStr = (row.salary_from && row.salary_to) ? (currencySymbol + ' ' + row.salary_from + ' - ' + row.salary_to) : 'Not Specified';
                    
                    var openingStr = row.opening_date ? formatDate(row.opening_date) : 'N/A';
                    var closingStr = row.closing_date ? formatDate(row.closing_date) : 'N/A';
                    var applyLink = window.location.origin + '/jobs/' + (row.job_code || row.id);
                    
                    var copyBtn = '<button type="button" class="btn btn-sm btn-outline-primary copy-job-btn" ' +
                        'data-title="' + escapedTitle + '" ' +
                        'data-code="' + escapedCode + '" ' +
                        'data-description="' + escapedDesc + '" ' +
                        'data-skills="' + escapedSkills + '" ' +
                        'data-opening="' + openingStr + '" ' +
                        'data-closing="' + closingStr + '" ' +
                        'data-category="' + escapeHtml(categoryName) + '" ' +
                        'data-jobtype="' + escapeHtml(jobTypeName) + '" ' +
                        'data-industry="' + escapeHtml(industryName) + '" ' +
                        'data-experience="' + escapeHtml(experienceStr) + '" ' +
                        'data-salary="' + escapeHtml(salaryStr) + '" ' +
                        'data-link="' + escapeHtml(applyLink) + '">' +
                        '<i class="bx bx-copy"></i> Copy' +
                        '</button>';
                        
                    var editUrl = '{{ route("jobs.edit", ":id") }}'.replace(':id', row.id);
                    var editBtn = '<a href="' + editUrl + '" class="btn btn-sm btn-info text-white">' +
                        '<i class="bx bx-edit-alt"></i> Edit' +
                        '</a>';
                        
                    var deleteUrl = '{{ route("jobs.destroy", ":id") }}'.replace(':id', row.id);
                    var deleteBtn = '<form action="' + deleteUrl + '" method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this job?\');">' +
                        '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                        '<input type="hidden" name="_method" value="DELETE">' +
                        '<button type="submit" class="btn btn-sm btn-danger">' +
                        '<i class="bx bx-trash"></i> Delete' +
                        '</button>' +
                        '</form>';
                        
                    return '<div class="d-flex justify-content-center gap-1">' + copyBtn + editBtn + deleteBtn + '</div>';
                }
            }
        ];

        initializeAdminDataTable('#jobTable', '{{ route("jobs.index") }}', columnsConfig, '#searchForm', [[0, 'desc']]);

        // Re-bind the copy job details action handler
        $(document).on('click', '.copy-job-btn', function() {
            var title = $(this).data('title');
            var code = $(this).data('code');
            var category = $(this).data('category');
            var jobtype = $(this).data('jobtype');
            var industry = $(this).data('industry');
            var experience = $(this).data('experience');
            var salary = $(this).data('salary');
            var opening = $(this).data('opening');
            var closing = $(this).data('closing');
            var skills = $(this).data('skills');
            var description = $(this).data('description');
            var link = $(this).data('link');

            var text = `📋 *JOB VACANCY DETAILS: ${title}*\n\n` +
                       `🔹 *Job Title:* ${title}\n` +
                       `🔹 *Job Code:* ${code}\n` +
                       `🔹 *Category:* ${category}\n` +
                       `🔹 *Job Type:* ${jobtype}\n` +
                       `🔹 *Industry:* ${industry}\n\n` +
                       `💼 *Experience Required:* ${experience}\n` +
                       `💰 *Salary:* ${salary}\n\n` +
                       `📅 *Opening Date:* ${opening}\n` +
                       `📅 *Closing Date:* ${closing}\n\n` +
                       `🛠️ *Key Skills:* ${skills}\n\n` +
                       `📝 *Description / Roles & Responsibilities:*\n${description}\n\n` +
                       `🔗 *Apply Link:* ${link}\n` +
                       `___________________________________`;

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(function() {
                    showToast('Job details copied successfully!');
                }, function(err) {
                    fallbackCopyText(text);
                });
            } else {
                fallbackCopyText(text);
            }
        });

        function fallbackCopyText(text) {
            var tempInput = $('<textarea>');
            tempInput.css({
                position: 'absolute',
                left: '-9999px',
                top: '0'
            });
            $('body').append(tempInput);
            tempInput.val(text).select();
            try {
                document.execCommand('copy');
                showToast('Job details copied successfully!');
            } catch (err) {
                showToast('Failed to copy job details');
            }
            tempInput.remove();
        }

        function showToast(message) {
            $('.toast-notification').remove();
            
            var toast = $('<div class="toast-notification"></div>').text(message);
            toast.css({
                'position': 'fixed',
                'bottom': '20px',
                'right': '20px',
                'background': '#28a745',
                'color': '#fff',
                'padding': '12px 24px',
                'border-radius': '8px',
                'box-shadow': '0 4px 12px rgba(0,0,0,0.15)',
                'z-index': '9999',
                'font-weight': '500',
                'display': 'none',
                'backdrop-filter': 'blur(4px)',
                'border': '1px solid rgba(255,255,255,0.2)',
                'font-family': 'inherit'
            });
            
            $('body').append(toast);
            toast.fadeIn(300).delay(2500).fadeOut(300, function() {
                $(this).remove();
            });
        }
    });
</script>
@endpush
