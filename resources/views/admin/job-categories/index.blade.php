@extends('layouts.admin')

@section('title', 'Job Categories')

@section('navbar_content')
<div class="d-flex justify-content-between align-items-center w-100 me-3">
    <div class="d-flex flex-column justify-content-center">
        <h5 class="mb-0 fw-bold text-dark" style="font-size: 1.1rem; line-height: 1.2;">Job Categories</h5>
        <small class="text-muted" style="font-size: 0.8rem; line-height: 1.2;">Manage your hierarchical job clusters</small>
    </div>
    <button type="button" class="btn btn-primary" onclick="openDialog()">
        <i class="bx bx-plus me-1"></i> Add Category
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
                    'placeholder' => 'Search by Category Name',
                    'class' => 'col-12'
                ]
            ]
        ])

        <div class="table-responsive text-nowrap rounded-3 border">
            {!! $dataTable->table(['class' => 'table table-hover mb-0', 'id' => 'categoryTable']) !!}
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title fw-bold" id="modalTitle">New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="categoryForm" action="" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-body pt-4">
                    <div class="row">
                        <div class="col-12 col-md-8 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="name">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g., Information Technology" required />
                        </div>
                        
                        <div class="col-12 col-md-4 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="symbol">Symbol</label>
                            <input type="text" class="form-control" id="symbol" name="symbol" placeholder="e.g., IT" />
                        </div>
                        
                        <div class="col-12 mb-2">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="parent_category_id">Parent Category (Optional)</label>
                            <select class="form-select" id="parent_category_id" name="parent_category_id">
                                <option value="">None (Top Level)</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
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
    function openDialog(id = null, name = '', symbol = '', parent_id = '') {
        var myModal = new bootstrap.Modal(document.getElementById('categoryModal'));
        var form = document.getElementById('categoryForm');
        
        document.getElementById('name').value = name;
        document.getElementById('symbol').value = symbol || '';
        document.getElementById('parent_category_id').value = parent_id || '';
        
        if (id) {
            document.getElementById('modalTitle').innerText = 'Edit Category';
            document.getElementById('formMethod').value = 'PUT';
            form.action = '{{ url("admin/job-categories") }}/' + id;
        } else {
            document.getElementById('modalTitle').innerText = 'New Category';
            document.getElementById('formMethod').value = 'POST';
            form.action = '{{ url("admin/job-categories") }}';
        }
        
        // Hide self from parent options if editing
        var options = document.getElementById('parent_category_id').options;
        for (var i = 0; i < options.length; i++) {
            if (options[i].value == id && id !== null) {
                options[i].style.display = 'none';
            } else {
                options[i].style.display = '';
            }
        }
        
        myModal.show();
    }

    @push('scripts')
    {!! $dataTable->scripts() !!}
    <script>
        $(function() {
            // Live search: trigger redraw on every change or keyup in searchForm
            $('#searchForm input, #searchForm select').on('keyup change input', function () {
                if (window.LaravelDataTables && window.LaravelDataTables["categoryTable"]) {
                    window.LaravelDataTables["categoryTable"].draw();
                }
            });
        });
    </script>
    @endpush
