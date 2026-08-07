@extends('layouts.admin')

@section('title', 'Clients')

@section('navbar_content')
<div class="d-flex justify-content-between align-items-center w-100 me-3">
    <div class="d-flex flex-column justify-content-center">
        <h5 class="mb-0 fw-bold text-dark" style="font-size: 1.1rem; line-height: 1.2;">Clients</h5>
        <small class="text-muted" style="font-size: 0.8rem; line-height: 1.2;">Manage company profiles</small>
    </div>
    <button type="button" class="btn btn-primary" onclick="openDialog()">
        <i class="bx bx-plus me-1"></i> Add Client
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
                    'label' => 'Company Search',
                    'placeholder' => 'Search by Name, Email, or Contact Number',
                    'class' => 'col-md-8'
                ],
                [
                    'name' => 'verified',
                    'label' => 'Verification Status',
                    'type' => 'select',
                    'options' => [
                        'true' => 'Verified',
                        'false' => 'Unverified'
                    ],
                    'class' => 'col-md-4'
                ]
            ]
        ])

        <div class="table-responsive text-nowrap rounded-3 border">
            {!! $dataTable->table(['class' => 'table table-hover mb-0', 'id' => 'clientTable']) !!}
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="clientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title fw-bold" id="modalTitle">New Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="clientForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-body pt-4">
                    <div class="row">
                        <div class="col-12 col-md-8 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="title">Company Name *</label>
                            <input type="text" class="form-control" id="title" name="title" required />
                        </div>
                        <div class="col-12 col-md-4 mb-3 d-flex align-items-end pb-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="verified" name="verified" value="true">
                                <label class="form-check-label" for="verified">Verified Client</label>
                            </div>
                        </div>
                        
                        <div class="col-12 mb-4">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="logo">Company Logo (Optional)</label>
                            <div class="d-flex align-items-center gap-3">
                                <div id="logoPreviewContainer" class="d-none">
                                    <img id="logoPreview" src="" alt="Client Logo" class="rounded border bg-light" style="width: 50px; height: 50px; object-fit: contain; padding: 4px;" />
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12"><hr class="my-2"></div>
                        <h6 class="mt-2 mb-3 fw-bold text-primary">General Contact Details</h6>

                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="contact_email">Email Address</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" />
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="contact_number">Phone Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number" />
                        </div>

                        <div class="col-12"><hr class="my-2"></div>
                        <h6 class="mt-2 mb-3 fw-bold text-primary">HR Representative Details</h6>

                        <div class="col-12 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="hr_name">HR Name</label>
                            <input type="text" class="form-control" id="hr_name" name="hr_name" />
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="hr_email">HR Email</label>
                            <input type="email" class="form-control" id="hr_email" name="hr_email" />
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="hr_contact">HR Phone</label>
                            <input type="text" class="form-control" id="hr_contact" name="hr_contact" />
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

@push('styles')
<style>
.bg-label-success { background-color: #e8fadf !important; color: #71dd37 !important; }
.bg-label-secondary { background-color: #ebeef0 !important; color: #8592a3 !important; }
</style>
@endpush

@push('scripts')
<script>
    function openDialog(id = null, title = '', verified = 0, contact_email = '', contact_number = '', hr_name = '', hr_email = '', hr_contact = '', logoUrl = '') {
        var myModal = new bootstrap.Modal(document.getElementById('clientModal'));
        var form = document.getElementById('clientForm');
        
        document.getElementById('title').value = title;
        document.getElementById('verified').checked = (verified == 1);
        document.getElementById('contact_email').value = contact_email;
        document.getElementById('contact_number').value = contact_number;
        document.getElementById('hr_name').value = hr_name;
        document.getElementById('hr_email').value = hr_email;
        document.getElementById('hr_contact').value = hr_contact;
        document.getElementById('logo').value = '';
        
        var previewContainer = document.getElementById('logoPreviewContainer');
        var previewImg = document.getElementById('logoPreview');
        
        if (logoUrl) {
            previewImg.src = logoUrl;
            previewContainer.classList.remove('d-none');
        } else {
            previewContainer.classList.add('d-none');
            previewImg.src = '';
        }
        
        if (id) {
            document.getElementById('modalTitle').innerText = 'Edit Client';
            document.getElementById('formMethod').value = 'PUT';
            form.action = '{{ url("admin/clients") }}/' + id;
        } else {
            document.getElementById('modalTitle').innerText = 'New Client';
            document.getElementById('formMethod').value = 'POST';
            form.action = '{{ url("admin/clients") }}';
        }
        
        myModal.show();
    }
</script>
{!! $dataTable->scripts() !!}
<script>
        $(function() {
            // Live search: trigger redraw on every change or keyup in searchForm
            $('#searchForm input, #searchForm select').on('keyup change input', function () {
                if (window.LaravelDataTables && window.LaravelDataTables["clientTable"]) {
                    window.LaravelDataTables["clientTable"].draw();
                }
            });
        });
    </script>
    @endpush
