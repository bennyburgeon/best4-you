<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | Best4You</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Boxicons (Sneat uses Boxicons) -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/layout.css') }}" />
    @stack('styles')
</head>
<body>
    <div class="layout-wrapper">
        @auth
        <!-- Sidebar Menu -->
        <aside class="layout-menu">
            <a href="{{ route('admin.dashboard') }}" class="app-brand">
                <span class="app-brand-logo">
                    <!-- SVG from original app -->
                    <svg width="25" viewBox="0 0 464 295" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M117.892 278.49L72.2356 226.476L164.711 123.003L120.245 42.0298L171.218 20.3703L237.525 141.28L117.892 278.49Z" fill="currentColor" />
                        <path d="M237.525 141.28L305.617 26.6874L364.577 6.46781L299.882 121.365L418.964 263.303L363.308 284.154L237.525 141.28Z" fill="currentColor" fill-opacity="0.8" />
                    </svg>
                </span>
                <span class="app-brand-text">Admin</span>
            </a>
            <div class="menu-inner">
                <div class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div>Dashboard</div>
                    </a>
                </div>
                <div class="menu-item {{ request()->routeIs('job-categories.*') ? 'active' : '' }}">
                    <a href="{{ route('job-categories.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-list-ul"></i>
                        <div>Categories</div>
                    </a>
                </div>
                <div class="menu-item {{ request()->routeIs('industry-types.*') ? 'active' : '' }}">
                    <a href="{{ route('industry-types.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-briefcase"></i>
                        <div>Industry Types</div>
                    </a>
                </div>
                <div class="menu-item {{ request()->routeIs('job-types.*') ? 'active' : '' }}">
                    <a href="{{ route('job-types.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-bookmark-star"></i>
                        <div>Job Types</div>
                    </a>
                </div>
                <div class="menu-item {{ request()->routeIs('regions.*') ? 'active' : '' }}">
                    <a href="{{ route('regions.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-globe"></i>
                        <div>Regions</div>
                    </a>
                </div>
                <div class="menu-item {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                    <a href="{{ route('clients.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-building"></i>
                        <div>Clients</div>
                    </a>
                </div>
                <div class="menu-item {{ request()->routeIs('jobs.*') ? 'active' : '' }}">
                    <a href="{{ route('jobs.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-briefcase-alt"></i>
                        <div>Jobs</div>
                    </a>
                </div>
                <div class="menu-item {{ request()->routeIs('job-applications.*') ? 'active' : '' }}">
                    <a href="{{ route('job-applications.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-file"></i>
                        <div>Applications</div>
                    </a>
                </div>
                <div class="menu-item {{ request()->routeIs('skills.*') ? 'active' : '' }}">
                    <a href="{{ route('skills.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-wrench"></i>
                        <div>Skills</div>
                    </a>
                </div>
                <div class="menu-item {{ request()->routeIs('currencies.*') ? 'active' : '' }}">
                    <a href="{{ route('currencies.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-dollar-circle"></i>
                        <div>Currencies</div>
                    </a>
                </div>
                
                <li class="menu-header small text-uppercase" style="margin: 1rem 0 0.5rem 1.5rem;"><span class="menu-header-text text-muted" style="font-size: 0.75rem;">Access Control</span></li>
                <div class="menu-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                    <a href="{{ route('roles.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-shield"></i>
                        <div>Roles</div>
                    </a>
                </div>
                <div class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-user"></i>
                        <div>Users</div>
                    </a>
                </div>
            </div>
        </aside>
        @endauth

        <!-- Main Page Layout -->
        <div class="layout-page" @guest style="margin-left: 0; width: 100%;" @endguest>
            @auth
            <!-- Top Navbar -->
            <nav class="layout-navbar">
                <div class="d-flex align-items-center flex-grow-1">
                    @hasSection('navbar_content')
                        @yield('navbar_content')
                    @else
                        <i class="bx bx-search fs-4 lh-0 text-muted me-2"></i>
                        <span class="text-muted">Search (⌘K)</span>
                    @endif
                </div>
                <div class="d-flex align-items-center">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bx bx-log-out"></i> Logout</button>
                    </form>
                </div>
            </nav>
            @endauth

            <!-- Content wrapper -->
            <div class="content-wrapper">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
            
            @auth
            <!-- Footer -->
            <footer class="content-footer p-4">
                <div class="text-center text-muted">
                    © 2025 Best4You. All rights reserved.
                </div>
            </footer>
            @endauth
        </div>
    </div>

    <!-- Core JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS (must be after jQuery) -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('public/admin/assets/js/datatable-assets.js') }}"></script>
    @stack('scripts')
</body>
</html>
