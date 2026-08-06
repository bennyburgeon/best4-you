@extends('layouts.admin')

@section('title', 'Edit Job Category')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Edit Category</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('job-categories.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-12 col-md-8 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="name">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g., Information Technology" value="{{ old('name', $item->name) }}" required />
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-md-4 mb-3">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="symbol">Symbol</label>
                            <input type="text" class="form-control" id="symbol" name="symbol" placeholder="e.g., IT" value="{{ old('symbol', $item->symbol) }}" />
                            @error('symbol')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 mb-4">
                            <label class="form-label text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;" for="parent_category_id">Parent Category (Optional)</label>
                            <select class="form-select" id="parent_category_id" name="parent_category_id">
                                <option value="">None (Top Level)</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('parent_category_id', $item->parent_category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_category_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row pt-2">
                        <div class="col-12 text-end">
                            <a href="{{ route('job-categories.index') }}" class="btn btn-label-secondary me-2 px-4" style="background-color: #f5f5f9; color: #697a8d;">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Update Category</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
