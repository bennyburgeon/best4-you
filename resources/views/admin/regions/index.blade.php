@extends('layouts.admin')

@section('title', 'Regions')

@section('navbar_content')
<div class="d-flex justify-content-between align-items-center w-100 me-3">
    <div class="d-flex flex-column justify-content-center">
        <h5 class="mb-0 fw-bold text-dark" style="font-size: 1.1rem; line-height: 1.2;">Regions</h5>
        <small class="text-muted" style="font-size: 0.8rem; line-height: 1.2;">Manage job geographic regions</small>
    </div>
    <button type="button" class="btn btn-primary" onclick="openDialog()">
        <i class="bx bx-plus me-1"></i> Add Region
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
                    'placeholder' => 'Search by Region Name',
                    'class' => 'col-12'
                ]
            ]
        ])

        <div class="table-responsive text-nowrap rounded-3 border">
            <table class="table table-hover mb-0" id="regionTable" data-ajax-url="{{ route('regions.index') }}" data-destroy-url="{{ route('regions.destroy', ':id') }}">
                <thead class="table-light">
                    <tr>
                        <th class="text-uppercase" style="font-size: 0.75rem;">ID</th>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Name</th>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Slug</th>
                        <th class="text-uppercase text-center" style="font-size: 0.75rem;">Status</th>
                        <th class="text-uppercase text-center" style="font-size: 0.75rem; width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    {{-- Loaded dynamically --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="regionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title fw-bold" id="modalTitle">New Region</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="regionForm" data-url="{{ url('admin/regions') }}" action="" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-body pt-4">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="name">Region Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g., India, Europe, Gulf" required />
                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked>
                                <label class="form-check-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="status">Active Status</label>
                            </div>
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
<script src="{{ asset('public/admin/assets/js/regions.js') }}"></script>
@endpush
