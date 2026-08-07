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
            {!! $dataTable->table(['class' => 'table table-hover mb-0', 'id' => 'applicationTable']) !!}
        </div>
    </div>
</div>

@include('admin.partials.datatable-assets')

@endsection

@push('scripts')
{!! $dataTable->scripts() !!}
<script>
    $(function() {
        // Live search: trigger redraw on every change or keyup in searchForm
        $('#searchForm input, #searchForm select').on('keyup change input', function () {
            if (window.LaravelDataTables && window.LaravelDataTables["applicationTable"]) {
                window.LaravelDataTables["applicationTable"].draw();
            }
        });

        // Initialize flatpickr range pickers if present and trigger table redraw on close
        if (typeof flatpickr !== 'undefined') {
            $('.flatpickr-range').flatpickr({
                mode: 'range',
                dateFormat: 'Y-m-d',
                allowInput: true,
                onClose: function(selectedDates, dateStr, instance) {
                    if (window.LaravelDataTables && window.LaravelDataTables["applicationTable"]) {
                        window.LaravelDataTables["applicationTable"].draw();
                    }
                }
            });
        }
    });
</script>
@endpush
