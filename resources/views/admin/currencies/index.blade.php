@extends('layouts.admin')

@section('title', 'Currencies')

@section('navbar_content')
<div class="d-flex justify-content-between align-items-center w-100 me-3">
    <div class="d-flex flex-column justify-content-center">
        <h5 class="mb-0 fw-bold text-dark" style="font-size: 1.1rem; line-height: 1.2;">Currencies</h5>
        <small class="text-muted" style="font-size: 0.8rem; line-height: 1.2;">Manage system currencies</small>
    </div>
    <button type="button" class="btn btn-primary" onclick="openDialog()">
        <i class="bx bx-plus me-1"></i> Add Currency
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
                    'placeholder' => 'Search by Currency Name or Code',
                    'class' => 'col-12'
                ]
            ]
        ])

        <div class="table-responsive text-nowrap rounded-3 border">
            <table class="table table-hover mb-0" id="currencyTable">
                <thead class="table-light">
                    <tr>
                        <th class="text-uppercase" style="font-size: 0.75rem;">ID</th>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Code</th>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Name</th>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Symbol</th>
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
<div class="modal fade" id="currencyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title fw-bold" id="modalTitle">New Currency</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="currencyForm" action="" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-body pt-4">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="code">Currency Code *</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="e.g., USD" required />
                        </div>
                        <div class="col-12 col-md-8 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="name">Currency Name *</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g., US Dollar" required />
                        </div>
                        <div class="col-12 mb-2">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="symbol">Symbol *</label>
                            <input type="text" class="form-control" id="symbol" name="symbol" placeholder="e.g., $" required />
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
    function openDialog(id = null, code = '', name = '', symbol = '') {
        var myModal = new bootstrap.Modal(document.getElementById('currencyModal'));
        var form = document.getElementById('currencyForm');
        
        document.getElementById('code').value = code;
        document.getElementById('name').value = name;
        document.getElementById('symbol').value = symbol;
        
        if (id) {
            document.getElementById('modalTitle').innerText = 'Edit Currency';
            document.getElementById('formMethod').value = 'PUT';
            form.action = '{{ url("admin/currencies") }}/' + id;
        } else {
            document.getElementById('modalTitle').innerText = 'New Currency';
            document.getElementById('formMethod').value = 'POST';
            form.action = '{{ url("admin/currencies") }}';
        }
        
        myModal.show();
    }

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

        var columnsConfig = [
            { 
                data: 'id', 
                name: 'id',
                render: function(data, type, row) {
                    return '<span class="fw-medium">#' + data + '</span>';
                }
            },
            { 
                data: 'code', 
                name: 'code',
                render: function(data) {
                    return '<span class="badge bg-label-primary">' + escapeHtml(data) + '</span>';
                }
            },
            { 
                data: 'name', 
                name: 'name' 
            },
            { 
                data: 'symbol', 
                name: 'symbol' 
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    var escapedCode = escapeHtml(row.code).replace(/'/g, "\\'");
                    var escapedName = escapeHtml(row.name).replace(/'/g, "\\'");
                    var escapedSymbol = escapeHtml(row.symbol).replace(/'/g, "\\'");
                    
                    var editBtn = '<button type="button" class="btn btn-sm btn-info text-white" onclick="openDialog(' + row.id + ', \'' + escapedCode + '\', \'' + escapedName + '\', \'' + escapedSymbol + '\')">' +
                        '<i class="bx bx-edit-alt me-1"></i> Edit' +
                        '</button>';
                        
                    var deleteUrl = '{{ route("currencies.destroy", ":id") }}'.replace(':id', row.id);
                    
                    var deleteBtn = '<form action="' + deleteUrl + '" method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this currency?\');">' +
                        '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                        '<input type="hidden" name="_method" value="DELETE">' +
                        '<button type="submit" class="btn btn-sm btn-danger">' +
                        '<i class="bx bx-trash me-1"></i> Delete' +
                        '</button>' +
                        '</form>';
                        
                    return '<div class="d-flex justify-content-center gap-2">' + editBtn + deleteBtn + '</div>';
                }
            }
        ];

        initializeAdminDataTable('#currencyTable', '{{ route("currencies.index") }}', columnsConfig, '#searchForm', [[0, 'desc']]);
    });
</script>
@endpush
