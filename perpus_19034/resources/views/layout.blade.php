<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 280px;
            --header-height: 70px;
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --card-border-radius: 12px;
            --transition-speed: 0.3s;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-top: var(--header-height);
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        
        /* Header Styles */
        .app-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            height: var(--header-height);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 0 1.5rem;
        }

        .app-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
            background-color: var(--sidebar-bg);
            transition: transform var(--transition-speed) ease;
            overflow-y: auto;
            z-index: 1020;
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
        }
        
        .sidebar.collapsed {
            transform: translateX(-100%);
        }
        
        .sidebar-menu {
            padding: 0;
            list-style: none;
            margin-bottom: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 4px;
        }
        
        .sidebar-menu .nav-link {
            color: #e2e8f0;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            border-radius: 6px;
            margin: 0 10px;
            transition: all var(--transition-speed);
            font-weight: 500;
        }
        
        .sidebar-menu .nav-link:hover, 
        .sidebar-menu .nav-link.active {
            background-color: var(--sidebar-hover);
            color: white;
            transform: translateX(5px);
        }
        
        .sidebar-menu .nav-link i {
            margin-right: 14px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        /* Main Content Area */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            flex: 1;
            transition: margin-left var(--transition-speed) ease;
        }
        
        .main-content.expanded {
            margin-left: 0;
        }
        
        /* Footer */
        .footer {
            margin-top: auto;
            background-color: #1f2937;
            padding: 1.25rem 0;
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition-speed) ease;
        }
        
        .footer.expanded {
            margin-left: 0;
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.expanded {
                transform: translateX(0);
            }
            
            .main-content, .footer {
                margin-left: 0;
            }
            
            /* Overlay for sidebar when open on mobile */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: var(--header-height);
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1010;
                backdrop-filter: blur(2px);
                transition: opacity var(--transition-speed);
            }
            
            .sidebar-overlay.show {
                display: block;
            }
        }
        
        /* User badge in sidebar */
        .user-badge {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 15px;
            background-color: rgba(255,255,255,0.05);
        }
        
        .user-profile {
            width: 45px;
            height: 45px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .user-role {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        /* Section divider in sidebar */
        .sidebar-divider {
            color: #64748b;
            font-size: 0.8rem;
            padding: 12px 24px 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        
        /* Card styles */
        .card {
            border-radius: var(--card-border-radius);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border: none;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            border-top-left-radius: var(--card-border-radius) !important;
            border-top-right-radius: var(--card-border-radius) !important;
            font-weight: 600;
        }
        
        /* Button styles */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-2px);
        }
        
        /* Tables */
        .table th {
            font-weight: 600;
            color: #1f2937;
        }
        
        /* Form controls */
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            border: 1px solid #e5e7eb;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.15);
        }
        
        /* Badge/pill styles */
        .badge {
            padding: 0.45em 0.8em;
            font-weight: 500;
            border-radius: 20px;
        }
        
        /* Custom toggle button */
        .sidebar-toggle-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
            background-color: rgba(255,255,255,0.1);
        }
        
        .sidebar-toggle-btn:hover {
            background-color: rgba(255,255,255,0.2);
            transform: scale(1.05);
        }
        
        /* DateTime display */
        .datetime-badge {
            background-color: rgba(255,255,255,0.15);
            border-radius: 8px;
            padding: 6px 14px;
            font-size: 0.85rem;
        }
        
        /* Breadcrumb */
        .breadcrumb-container {
            margin-bottom: 1.5rem;
            background-color: white;
            padding: 1rem 1.5rem;
            border-radius: var(--card-border-radius);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .breadcrumb-item.active {
            font-weight: 600;
        }
        
        /* Animation for page transitions */
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Dashboard stats cards */
        .stat-card {
            border-radius: var(--card-border-radius);
            padding: 1.5rem;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card .stat-icon {
            position: absolute;
            right: 1rem;
            top: 1rem;
            font-size: 2.5rem;
            opacity: 0.15;
        }
        
        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .stat-card .stat-label {
            font-size: 1rem;
            color: #6b7280;
        }
        
        /* Action buttons */
        .action-btns .btn {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Search bar */
        .search-bar {
            border-radius: 30px;
            padding-left: 1rem;
            padding-right: 1rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        
        .search-bar:focus {
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
        }
        
        /* Notification badge */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background-color: #ef4444;
            color: white;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="app-header text-white">
        <div class="container-fluid d-flex justify-content-between align-items-center h-100">
            <div class="d-flex align-items-center">
                <button class="sidebar-toggle-btn text-white me-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="d-flex align-items-center app-brand">
                    <i class="fas fa-book-open fs-4 me-3"></i>
                    <h1 class="h4 mb-0">Perpustakaan Digital</h1>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="datetime-badge me-4 d-none d-md-block">
                    <i class="far fa-clock me-2"></i>
                    <span id="currentDateTime">{{ now()->format('Y-m-d H:i:s') }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                    @csrf
                    <button type="submit" class="btn btn-light d-flex align-items-center">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Sidebar Overlay (for mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="user-badge">
            <div class="d-flex align-items-center">
                <div class="user-profile me-3">
                    <i class="fas fa-user text-white"></i>
                </div>
                <div>
                    <div class="text-white fw-medium mb-1">{{ Auth::user()->name }}</div>
                    <span class="user-role">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
            </div>
        </div>

        <ul class="sidebar-menu">
            @if(Auth::user()->role === 'admin')
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            @elseif(Auth::user()->role === 'petugas')
                <li>
                    <a href="{{ route('petugas.dashboard') }}" class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->role === 'admin')
                <!-- Admin Menu Items -->
                <div class="sidebar-divider">Data Buku</div>
                <li>
                    <a href="{{ route('buku.index') }}" class="nav-link {{ request()->routeIs('buku.index') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        <span>Total Buku</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kategoribuku.index') }}" class="nav-link {{ request()->routeIs('kategoribuku.index') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span>Kategori</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('peminjaman.index') }}" class="nav-link {{ request()->routeIs('peminjaman.index') ? 'active' : '' }}">
                        <i class="fas fa-bookmark"></i>
                        <span>Peminjaman</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.tampil') }}" class="nav-link {{ request()->routeIs('user.tampil') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Anggota</span>
                    </a>
                </li>
                 <li>
                    <a href="{{ route('ulasanbuku.index') }}" class="nav-link {{ request()->routeIs('ulasan.index') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Ulasan</span>
                    </a>
                </li>
                
                <div class="sidebar-divider">Laporan</div>
                <li>
                    <a href="{{ route('laporan.buku') }}" class="nav-link {{ request()->routeIs('admin.reports.books*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Laporan Buku</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.peminjaman') }}" class="nav-link {{ request()->routeIs('admin.reports.loans*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Laporan Peminjaman</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->role === 'petugas')
                <!-- Petugas Menu Items -->
                <div class="sidebar-divider">Data Buku</div>
                <li>
                    <a href="{{ route('buku.index') }}" class="nav-link {{ request()->routeIs('buku.index') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        <span>Total Buku</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kategoribuku.index') }}" class="nav-link {{ request()->routeIs('kategoribuku.index') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span>Kategori</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('peminjaman.index') }}" class="nav-link {{ request()->routeIs('peminjaman.index') ? 'active' : '' }}">
                        <i class="fas fa-bookmark"></i>
                        <span>Peminjaman</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ulasanbuku.index') }}" class="nav-link {{ request()->routeIs('ulasan.index') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Ulasan</span>
                    </a>
                </li>
                <div class="sidebar-divider">Laporan</div>
                <li>
                    <a href="{{ route('laporan.buku') }}" class="nav-link {{ request()->routeIs('admin.reports.books*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Laporan Buku</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.peminjaman') }}" class="nav-link {{ request()->routeIs('admin.reports.loans*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Laporan Peminjaman</span>
                    </a>
                </li>
            @endif
    </aside>
            
            <main class="main-content" id="mainContent">
    <div class="container-fluid py-4">
        @yield('perpus')
    </div>
</main>

    <!-- Footer -->
    <footer class="footer text-white" id="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; {{ date('Y') }} Sistem Perpustakaan Digital. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-center justify-content-md-end">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Update DateTime function
        function updateDateTime() {
            const now = new Date();
            const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };
            
            let dateTimeStr = now.toLocaleString('id-ID', options)
                .replace(',', '')
                .replace(/(\d+)\/(\d+)\/(\d+)/, '$3-$1-$2');
                
            document.getElementById('currentDateTime').textContent = dateTimeStr;
        }

        // Initialize and update every second
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize date/time
            updateDateTime();
            setInterval(updateDateTime, 1000);
            
            // Sidebar toggle functionality
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const footer = document.getElementById('footer');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            function toggleSidebar() {
                const isMobile = window.innerWidth < 992;
                
                if (isMobile) {
                    sidebar.classList.toggle('expanded');
                    sidebarOverlay.classList.toggle('show');
                } else {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');
                    footer.classList.toggle('expanded');
                }
            }
            
            sidebarToggle.addEventListener('click', toggleSidebar);
            sidebarOverlay.addEventListener('click', toggleSidebar);
            
            // Handle responsive adjustments on window resize
            window.addEventListener('resize', () => {
                const isMobile = window.innerWidth < 992;
                
                if (isMobile) {
                    sidebar.classList.remove('collapsed');
                    sidebar.classList.remove('expanded');
                    mainContent.classList.remove('expanded');
                    footer.classList.remove('expanded');
                    sidebarOverlay.classList.remove('show');
                } else {
                    sidebar.classList.remove('expanded');
                    sidebarOverlay.classList.remove('show');
                }
            });
            
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>