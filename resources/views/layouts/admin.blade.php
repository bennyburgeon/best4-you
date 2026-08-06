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
    
    <style>
        :root {
            --bs-primary: #696cff;
            --bs-body-bg: #f5f5f9;
            --bs-body-font-family: 'Public Sans', sans-serif;
        }
        body {
            font-family: var(--bs-body-font-family);
            background-color: var(--bs-body-bg);
            color: #566a7f;
            overflow-x: hidden;
        }
        
        /* Layout */
        .layout-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .layout-menu {
            width: 260px;
            background: #fff;
            box-shadow: 0 0.125rem 0.375rem 0 rgba(161, 172, 184, 0.12);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1038;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
        }
        .app-brand {
            height: 64px;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: #566a7f;
            text-decoration: none;
            text-transform: uppercase;
        }
        .app-brand-logo { color: var(--bs-primary); margin-right: 0.5rem; }
        
        .menu-inner {
            padding: 0.5rem 0;
            overflow-y: auto;
            flex-grow: 1;
        }
        .menu-item {
            margin-bottom: 0.25rem;
        }
        .menu-link {
            display: flex;
            align-items: center;
            padding: 0.625rem 1rem;
            margin: 0 1rem;
            color: #697a8d;
            border-radius: 0.375rem;
            text-decoration: none;
            transition: all 0.2s;
        }
        .menu-link:hover {
            background-color: rgba(67, 89, 113, 0.04);
            color: #697a8d;
        }
        .menu-item.active > .menu-link {
            color: #696cff;
            background-color: rgba(105, 108, 255, 0.16);
            font-weight: 600;
        }
        .menu-icon {
            font-size: 1.25rem;
            margin-right: 0.75rem;
        }
        
        /* Main Content */
        .layout-page {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin-left: 260px;
            width: calc(100% - 260px);
        }
        
        /* Navbar */
        .layout-navbar {
            height: 64px;
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: saturate(200%) blur(6px);
            box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
            border-radius: 0.375rem;
            margin: 1rem 1.5rem 0;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1030;
        }
        
        /* Content */
        .content-wrapper {
            flex-grow: 1;
            padding: 1.5rem;
        }
        
        /* Components */
        .card {
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid #d9dee3;
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.12);
        }
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #d9dee3;
            padding: 1.5rem;
        }
        .card-body {
            padding: 1.5rem;
        }
        
        .btn-primary {
            color: #fff;
            background-color: #696cff;
            border-color: #696cff;
            box-shadow: 0 0.125rem 0.25rem 0 rgba(105, 108, 255, 0.4);
        }
        .btn-primary:hover {
            background-color: #5f61e6;
            border-color: #5f61e6;
            transform: translateY(-1px);
        }
        .btn-info {
            color: #fff;
            background-color: #03c3ec;
            border-color: #03c3ec;
            box-shadow: 0 0.125rem 0.25rem 0 rgba(3, 195, 236, 0.4);
        }
        .btn-danger {
            color: #fff;
            background-color: #ff3e1d;
            border-color: #ff3e1d;
            box-shadow: 0 0.125rem 0.25rem 0 rgba(255, 62, 29, 0.4);
        }
        
        /* Form Controls */
        .form-control, .form-select {
            border: 1px solid #d9dee3;
            border-radius: 0.375rem;
            padding: 0.4375rem 0.875rem;
            color: #697a8d;
        }
        .form-control:focus, .form-select:focus {
            border-color: #696cff;
            box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.1);
        }

        .table > :not(caption) > * > * {
            padding: 0.625rem 1.25rem;
            background-color: var(--bs-table-bg);
            border-bottom-color: #d9dee3;
        }

        .bg-label-primary {
            background-color: #e7e7ff !important;
            color: #696cff !important;
        }
    </style>
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
    @stack('scripts')
</body>
</html>
