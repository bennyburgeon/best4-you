{{-- 
    DataTables CSS & JS are now loaded globally in layouts/admin.blade.php.
    This partial remains as a hook for page-specific overrides if needed.
--}}
@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('public/admin/assets/css/datatable-assets.css') }}" />
    @endpush
@endonce
