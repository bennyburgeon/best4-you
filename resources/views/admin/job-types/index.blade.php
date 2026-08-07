@extends('layouts.admin')

@section('title', 'Job Types')

@section('navbar_content')
<div class="d-flex justify-content-between align-items-center w-100 me-3">
    <div class="d-flex flex-column justify-content-center">
        <h5 class="mb-0 fw-bold text-dark" style="font-size: 1.1rem; line-height: 1.2;">Job Types</h5>
        <small class="text-muted" style="font-size: 0.8rem; line-height: 1.2;">Manage employment types (e.g. Full-Time, Freelance)</small>
    </div>
    <button type="button" class="btn btn-primary" onclick="openDialog()">
        <i class="bx bx-plus me-1"></i> Add Type
    </button>
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
                    'label' => 'Name',
                    'placeholder' => 'Search by Job Type Name',
                    'class' => 'col-12'
                ]
            ]
        ])

        <div class="table-responsive text-nowrap rounded-3 border">
            {!! $dataTable->table(['class' => 'table table-hover mb-0', 'id' => 'jobTypeTable']) !!}
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="jobTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title fw-bold" id="modalTitle">New Job Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="jobTypeForm" action="" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-body pt-4">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="name">Type Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g., Full-Time" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top pt-3">
                    <button type="button" class="btn btn-label-secondary" style="background-color: #f5f5f9; color: #697a8d;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.partials.datatable-assets')

@endsection

@push('scripts')
<script>
    function openDialog(id = null, name = '') {
        var myModal = new bootstrap.Modal(document.getElementById('jobTypeModal'));
        var form = document.getElementById('jobTypeForm');
        
        document.getElementById('name').value = name;
        
        if (id) {
            document.getElementById('modalTitle').innerText = 'Edit Job Type';
            document.getElementById('formMethod').value = 'PUT';
            form.action = '{{ url("admin/job-types") }}/' + id;
        } else {
            document.getElementById('modalTitle').innerText = 'New Job Type';
            document.getElementById('formMethod').value = 'POST';
            form.action = '{{ url("admin/job-types") }}';
        }
        
        myModal.show();
    }

    @push('scripts')
    {!! $dataTable->scripts() !!}
    <script>
        $(function() {
            // Live search: trigger redraw on every change or keyup in searchForm
            $('#searchForm input, #searchForm select').on('keyup change input', function () {
                if (window.LaravelDataTables && window.LaravelDataTables["jobTypeTable"]) {
                    window.LaravelDataTables["jobTypeTable"].draw();
                }
            });
        });
    </script>
    @endpush
