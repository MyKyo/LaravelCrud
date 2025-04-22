<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indo App - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Simplified Sidebar Styles */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 56px;
            background: #f8f9fa;
            transition: all 0.3s ease;
            z-index: 1000;
            border-right: 1px solid #dee2e6;
            overflow-y: auto;
        }
        
        .sidebar-collapsed {
            width: 60px;
        }
        
        .sidebar-collapsed .nav-text {
            display: none;
        }
        
        .sidebar-collapsed .nav-link {
            justify-content: center;
            padding: 0.75rem 0;
        }
        
        .sidebar-collapsed .nav-link i {
            margin-right: 0;
            font-size: 1.1rem;
        }
        
        .main-content {
            margin-left: 240px;
            transition: all 0.3s ease;
            padding-top: 56px;
            min-height: 100vh;
            background: #fff;
        }
        
        .content-collapsed {
            margin-left: 60px;
        }
        
        .content-no-sidebar {
            margin-left: 0;
        }
        
        /* Clean Navbar */
        .navbar {
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1030;
            border-bottom: 1px solid #dee2e6;
        }
        
        /* Minimal Menu Items */
        .nav-link {
            color: #495057;
            padding: 0.75rem 1rem;
            margin: 0.25rem 0.5rem;
            display: flex;
            align-items: center;
            transition: all 0.2s;
            border-radius: 4px;
        }
        
        .nav-link:hover {
            background: #e9ecef;
        }
        
        .nav-link.active {
            font-weight: 500;
            color: #212529;
        }
        
        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            color: #6c757d;
        }
        
        .nav-link.active i {
            color: #212529;
        }
        
        /* Simple Toggle Button */
        .sidebar-toggle {
            background: transparent;
            border: none;
            color: #6c757d;
            padding: 0.5rem;
            cursor: pointer;
        }
        
        /* Clean User Mode Layout */
        .user-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            padding-top: 80px;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar-visible {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .content-collapsed {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            @if(session('is_admin'))
            <button class="sidebar-toggle me-2" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            @endif
            <a class="navbar-brand" href="{{ route('indo.index') }}">Indo App</a>
            
            <div class="d-flex align-items-center">
                @if(session('is_admin'))
                    <a href="{{ route('switch.user') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-user me-1"></i> User Mode
                    </a>
                @else
                    <a href="{{ route('switch.admin') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-lock me-1"></i> Admin Mode
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Admin Sidebar -->
    @if(session('is_admin'))
    <div class="sidebar" id="sidebar">
        <div class="p-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('indo.index') }}">
                        <i class="fas fa-home"></i>
                        <span class="nav-text">Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#data-barang" data-bs-toggle="tab">
                        <i class="fas fa-box"></i>
                        <span class="nav-text">Data Barang</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#riwayat-pembelian" data-bs-toggle="tab">
                        <i class="fas fa-history"></i>
                        <span class="nav-text">Riwayat Pembelian</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main class="@if(session('is_admin')) main-content @else user-content @endif" id="mainContent">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('is_admin'))
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            let isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

            // Initialize sidebar state
            function initSidebar() {
                if (isCollapsed) {
                    sidebar.classList.add('sidebar-collapsed');
                    mainContent.classList.add('content-collapsed');
                }
            }

            // Toggle sidebar
            function toggleSidebar() {
                isCollapsed = !isCollapsed;
                sidebar.classList.toggle('sidebar-collapsed');
                mainContent.classList.toggle('content-collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            }

            // Initialize
            initSidebar();
            
            // Event listener
            sidebarToggle.addEventListener('click', toggleSidebar);
            @endif
        });
    </script>
    @yield('scripts')
</body>
</html>