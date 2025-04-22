<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indo App - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Improved Sidebar Styles */
        .sidebar {
            width: 240px;
            height: calc(100vh - 56px);
            position: fixed;
            left: 0;
            top: 56px;
            background: #f8f9fa;
            transition: all 0.3s ease;
            z-index: 1000;
            border-right: 1px solid #dee2e6;
            overflow-y: auto;
            padding-top: 15px;
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
        
        /* Navbar Styles */
        .navbar {
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1030;
            border-bottom: 1px solid #dee2e6;
        }
        
        /* Menu Items */
        .nav-link {
            color: #495057;
            padding: 0.75rem 1.5rem;
            margin: 0.15rem 0;
            display: flex;
            align-items: center;
            transition: all 0.2s;
            border-radius: 0;
        }
        
        .nav-link:hover {
            background: #e9ecef;
        }
        
        .nav-link.active {
            font-weight: 500;
            color: #212529;
            background-color: rgba(0,0,0,0.05);
            border-left: 3px solid #0d6efd;
        }
        
        .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            color: #6c757d;
        }
        
        .nav-link.active i {
            color: #0d6efd;
        }
        
        /* Search Box Styles */
        .search-box {
            max-width: 300px;
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
            
            .search-box {
                max-width: 100%;
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
        <div class="d-flex flex-column h-100">
            <ul class="nav flex-column flex-grow-1">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('indo.index') }}">
                        <i class="fas fa-home"></i>
                        <span class="nav-text">Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#dashboard" data-bs-toggle="tab">
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

            <div class="tab-content">
                <!-- Dashboard Tab -->
                <div class="tab-pane fade" id="dashboard">
                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h5>
                        </div>
                        <div class="card-body">
                            <p>Selamat datang di dashboard admin</p>
                        </div>
                    </div>
                </div>

                <!-- Data Barang Tab -->
                <div class="tab-pane fade" id="data-barang">
                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <h5 class="mb-0"><i class="fas fa-box me-2"></i>Data Barang</h5>
                                <div class="d-flex mt-2 mt-md-0">
                                    <form action="{{ route('indo.index') }}" method="GET" class="search-box me-2">
                                        <input type="hidden" name="active_tab" id="activeTabInput" value="">
                                        <div class="input-group">
                                            <input type="text" 
                                                   class="form-control form-control-sm" 
                                                   placeholder="Cari barang..." 
                                                   name="search"
                                                   value="{{ request('search') }}">
                                            <button class="btn btn-outline-secondary btn-sm" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            @if(request('search'))
                                            <a href="{{ route('indo.index') }}" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-times"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </form>
                                    <a href="{{ route('indo.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Tambah
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Barang</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($indo as $item)
                                        <tr>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->namabarang }}</td>
                                            <td>Rp {{ number_format($item->harga, 2) }}</td>
                                            <td>{{ $item->jumlahbarang }}</td>
                                            <td>
                                                <a href="{{ route('indo.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('indo.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                @if(request('search'))
                                                <i class="fas fa-search-minus fa-2x mb-2 text-muted"></i>
                                                <p class="text-muted">Tidak ditemukan barang dengan pencarian "{{ request('search') }}"</p>
                                                @else
                                                <i class="fas fa-box-open fa-2x mb-2 text-muted"></i>
                                                <p class="text-muted">Tidak ada data barang</p>
                                                @endif
                                                <a href="{{ route('indo.index') }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-sync-alt me-1"></i> Muat Ulang
                                                </a>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($indo->hasPages())
                            <div class="d-flex justify-content-center mt-3">
                                {{ $indo->withQueryString()->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Riwayat Pembelian Tab -->
                <div class="tab-pane fade" id="riwayat-pembelian">
                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Pembelian</h5>
                                <form action="{{ route('indo.index') }}" method="GET" class="search-box mt-2 mt-md-0">
                                    <input type="hidden" name="active_tab" id="activeTabInput" value="">
                                    <div class="input-group">
                                        <input type="text" 
                                               class="form-control form-control-sm" 
                                               placeholder="Cari riwayat..." 
                                               name="search_history"
                                               value="{{ request('search_history') }}">
                                        <button class="btn btn-outline-secondary btn-sm" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if(request('search_history'))
                                        <a href="{{ route('indo.index') }}" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-times"></i>
                                        </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Pembeli</th>
                                            <th>Barang</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pembelians as $pembelian)
                                        <tr>
                                            <td>{{ $pembelian->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $pembelian->nama_pembeli }}</td>
                                            <td>{{ $pembelian->indo->namabarang }}</td>
                                            <td>{{ $pembelian->jumlah_beli }}</td>
                                            <td>Rp {{ number_format($pembelian->total_harga, 2) }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                @if(request('search_history'))
                                                <i class="fas fa-search-minus fa-2x mb-2 text-muted"></i>
                                                <p class="text-muted">Tidak ditemukan riwayat dengan pencarian "{{ request('search_history') }}"</p>
                                                @else
                                                <i class="fas fa-history fa-2x mb-2 text-muted"></i>
                                                <p class="text-muted">Tidak ada riwayat pembelian</p>
                                                @endif
                                                <a href="{{ route('indo.index') }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-sync-alt me-1"></i> Muat Ulang
                                                </a>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($pembelians->hasPages())
                            <div class="d-flex justify-content-center mt-3">
                                {{ $pembelians->withQueryString()->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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

            // Activate tabs based on URL hash, URL parameter, or localStorage
            function activateTab() {
                const urlParams = new URLSearchParams(window.location.search);
                const tabParam = urlParams.get('active_tab');
                const hash = window.location.hash;
                const savedTab = localStorage.getItem('activeTab');
                
                // Prioritize: 1. URL parameter, 2. URL hash, 3. saved tab, 4. default to dashboard
                const tabToActivate = tabParam ? `#${tabParam}` : (hash || savedTab || '#dashboard');
                
                const tab = document.querySelector(`a[href="${tabToActivate}"]`);
                if (tab) {
                    new bootstrap.Tab(tab).show();
                }
            }

            // Activate tab on page load
            activateTab();
            
            // Activate tab when hash changes
            window.addEventListener('hashchange', activateTab);

            // Save active tab to localStorage when changed
            document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
                tab.addEventListener('shown.bs.tab', function (e) {
                    const activeTab = e.target.getAttribute('href');
                    localStorage.setItem('activeTab', activeTab);
                });
            });

            // Update active tab input before form submission
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const activeTab = localStorage.getItem('activeTab') || '#dashboard';
                    const activeTabInput = this.querySelector('#activeTabInput');
                    if (activeTabInput) {
                        activeTabInput.value = activeTab.replace('#', '');
                    }
                });
            });
        });
    </script>
    @yield('scripts')
</body>
</html>