@extends('layouts.admin')
@section('title', 'Edit Permission')
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Permission</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('permissions.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Add fields here -->
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
