@extends('layouts.admin')

@section('title', 'Users')

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
            <h5 class="card-title mb-1 fw-bold">Admin Users</h5>
            <small class="text-muted">Manage administrators and staff access</small>
        </div>
        <button type="button" class="btn btn-primary" onclick="openDialog()">
            <i class="bx bx-plus me-1"></i> Add User
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
                        <th class="text-uppercase" style="font-size: 0.75rem;">Name</th>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Email</th>
                        <th class="text-uppercase" style="font-size: 0.75rem;">Roles</th>
                        <th class="text-uppercase text-center" style="font-size: 0.75rem; width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($items as $item)
                    <tr>
                        <td class="fw-medium text-dark">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3 bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold" style="width:32px; height:32px;">
                                    {{ substr($item->name, 0, 1) }}
                                </div>
                                {{ $item->name }}
                            </div>
                        </td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                @forelse($item->roles as $role)
                                    <span class="badge bg-label-info">{{ $role->name }}</span>
                                @empty
                                    <span class="text-muted small">No roles</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-info text-white" 
                                    onclick="openDialog({{ $item->id }}, '{{ addslashes($item->name) }}', '{{ addslashes($item->email) }}', {{ json_encode($item->roles->pluck('name')) }})">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </button>
                                <form action="{{ route('users.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
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
                        <td colspan="4" class="text-center py-4 text-muted">No users found. Click "Add User" to create one.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title fw-bold" id="modalTitle">New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="userForm" action="" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-body pt-4">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="name">Full Name *</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required />
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="email">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="john@example.com" required />
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" id="passwordLabel" for="password">Password *</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Min 6 characters" />
                            <small class="text-muted d-none" id="passwordHelp">Leave blank to keep existing password.</small>
                        </div>
                        <div class="col-12 mb-2">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="roles">Assigned Roles</label>
                            <select class="form-select select2-multiple" id="roles" name="roles[]" multiple="multiple" data-placeholder="Select roles">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
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
            dropdownParent: $('#userModal')
        });
    });

    function openDialog(id = null, name = '', email = '', rolesList = []) {
        var myModal = new bootstrap.Modal(document.getElementById('userModal'));
        var form = document.getElementById('userForm');
        
        document.getElementById('name').value = name;
        document.getElementById('email').value = email;
        document.getElementById('password').value = '';
        
        $('#roles').val(rolesList).trigger('change');
        
        if (id) {
            document.getElementById('modalTitle').innerText = 'Edit User';
            document.getElementById('formMethod').value = 'PUT';
            form.action = '{{ url("admin/users") }}/' + id;
            document.getElementById('password').required = false;
            document.getElementById('passwordLabel').innerText = 'Password (Optional)';
            document.getElementById('passwordHelp').classList.remove('d-none');
        } else {
            document.getElementById('modalTitle').innerText = 'New User';
            document.getElementById('formMethod').value = 'POST';
            form.action = '{{ url("admin/users") }}';
            document.getElementById('password').required = true;
            document.getElementById('passwordLabel').innerText = 'Password *';
            document.getElementById('passwordHelp').classList.add('d-none');
        }
        
        myModal.show();
    }
</script>
@endpush
