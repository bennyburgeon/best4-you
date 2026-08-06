@extends('layouts.admin')
@section('title', 'Create Permission')
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Create Permission</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
            <!-- Add fields here -->
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection
