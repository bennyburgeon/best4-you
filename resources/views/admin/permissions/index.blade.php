@extends('layouts.admin')
@section('title', 'Permissions')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Permissions</h5>
        <a href="{{ route('permissions.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add New</a>
    </div>
    <div class="table-responsive text-nowrap p-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        <a href="{{ route('permissions.edit', $item->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('permissions.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
