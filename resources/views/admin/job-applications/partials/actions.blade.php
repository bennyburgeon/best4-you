<form action="{{ route('job-applications.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this application?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-icon btn-danger" title="Delete">
        <i class="bx bx-trash"></i>
    </button>
</form>
