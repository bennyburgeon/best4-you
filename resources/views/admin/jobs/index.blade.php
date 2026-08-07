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
            {!! $dataTable->table(['class' => 'table table-hover mb-0', 'id' => 'jobTable']) !!}
        </div>
    </div>
</div>

@include('admin.partials.datatable-assets')

@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
<script>
    $(function() {
        // Redraw table when search filters change
        $('#searchForm input, #searchForm select').on('keyup change input', function () {
            if (window.LaravelDataTables && window.LaravelDataTables["jobTable"]) {
                window.LaravelDataTables["jobTable"].draw();
            }
        });

        // Initialize flatpickr range pickers if present and trigger table redraw on close
        if (typeof flatpickr !== 'undefined') {
            $('.flatpickr-range').flatpickr({
                mode: 'range',
                dateFormat: 'Y-m-d',
                allowInput: true,
                onClose: function(selectedDates, dateStr, instance) {
                    if (window.LaravelDataTables && window.LaravelDataTables["jobTable"]) {
                        window.LaravelDataTables["jobTable"].draw();
                    }
                }
            });
        }

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
