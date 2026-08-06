@extends('layouts.admin')

@section('title', 'Roles')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    .select2-container--bootstrap-5 .select2-selection { border-color: #d9dee3; color: #697a8d; padding: 0.35rem 0.75rem; }
    .select2-search__field { font-size: 0.875rem; }
</style>
@endpush

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center border-bottom-0 pb-0">
        <div>
            <h5 class="card-title mb-1 fw-bold">Roles & Permissions</h5>
            <small class="text-muted">Manage system roles and their access levels</small>
        </div>
        <button type="button" class="btn btn-primary" onclick="openDialog()">
            <i class="bx bx-plus me-1"></i> Add Role
        </button>
    </div>
    
    <div class="card-body mt-4">
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="table-responsive text-nowrap rounded-3 border">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Role Name</th>
                        <th class="text-uppercase" style="font-size: 0.75rem; width: 60%;">Permissions</th>
                        <th class="text-uppercase text-center" style="font-size: 0.75rem; width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($items as $item)
                    <tr>
                        <td class="fw-medium text-dark">{{ $item->name }}</td>
                        <td style="white-space: normal;">
                            <div class="d-flex flex-wrap gap-1">
                                @forelse($item->permissions as $perm)
                                    <span class="badge bg-label-primary">{{ $perm->name }}</span>
                                @empty
                                    <span class="text-muted small">No permissions assigned</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-info text-white" 
                                    onclick="openDialog({{ $item->id }}, '{{ addslashes($item->name) }}', {{ json_encode($item->permissions->pluck('name')) }})">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </button>
                                <form action="{{ route('roles.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bx bx-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">No roles found. Click "Add Role" to create one.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title fw-bold" id="modalTitle">New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="roleForm" action="" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-body pt-4">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="name">Role Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g., Administrator, HR" required />
                        </div>
                        <div class="col-12 mb-2">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="permissions">Assigned Permissions</label>
                            <select class="form-select select2-multiple" id="permissions" name="permissions[]" multiple="multiple" data-placeholder="Select permissions">
                                @foreach($permissions as $perm)
                                    <option value="{{ $perm->name }}">{{ $perm->name }}</option>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-multiple').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#roleModal')
        });
    });

    function openDialog(id = null, name = '', perms = []) {
        var myModal = new bootstrap.Modal(document.getElementById('roleModal'));
        var form = document.getElementById('roleForm');
        
        document.getElementById('name').value = name;
        
        $('#permissions').val(perms).trigger('change');
        
        if (id) {
            document.getElementById('modalTitle').innerText = 'Edit Role';
            document.getElementById('formMethod').value = 'PUT';
            form.action = '{{ url("admin/roles") }}/' + id;
        } else {
            document.getElementById('modalTitle').innerText = 'New Role';
            document.getElementById('formMethod').value = 'POST';
            form.action = '{{ url("admin/roles") }}';
        }
        
        myModal.show();
    }
</script>
@endpush
