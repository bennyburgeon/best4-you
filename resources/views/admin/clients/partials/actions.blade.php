@php
    $escapedTitle = e($row->title);
    $escapedEmail = e($row->contact_email ?? '');
    $escapedPhone = e($row->contact_number ?? '');
    $escapedHrName = e($row->hr_name ?? '');
    $escapedHrEmail = e($row->hr_email ?? '');
    $escapedHrContact = e($row->hr_contact ?? '');
    $logoUrl = $row->logo ?? '';
    $verifiedVal = $row->verified ? 1 : 0;
@endphp

<div class="d-flex justify-content-center gap-2">
    <button type="button" class="btn btn-sm btn-info text-white" 
            onclick="openDialog({{ $row->id }}, '{{ addslashes($escapedTitle) }}', {{ $verifiedVal }}, '{{ addslashes($escapedEmail) }}', '{{ addslashes($escapedPhone) }}', '{{ addslashes($escapedHrName) }}', '{{ addslashes($escapedHrEmail) }}', '{{ addslashes($escapedHrContact) }}', '{{ $logoUrl }}')">
        <i class="bx bx-edit-alt me-1"></i> Edit
    </button>
    
    <form action="{{ route('clients.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this client?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="bx bx-trash me-1"></i> Delete
        </button>
    </form>
</div>
