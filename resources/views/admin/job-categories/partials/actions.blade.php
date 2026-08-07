<div class="d-flex justify-content-center gap-2">
    <button type="button" class="btn btn-sm btn-info text-white" 
            onclick="openDialog({{ $row->id }}, '{{ addslashes(e($row->name)) }}', '{{ addslashes(e($row->symbol)) }}', '{{ $row->parent_category_id }}')">
        <i class="bx bx-edit-alt me-1"></i> Edit
    </button>
    
    <form action="{{ route('job-categories.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="bx bx-trash me-1"></i> Delete
        </button>
    </form>
</div>
