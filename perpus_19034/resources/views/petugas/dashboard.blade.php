@extends('layout')

@section('perpus')
<div class="container-fluid">
    <!-- Dashboard Title & Welcome Message -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="fw-bold text-primary mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                            <p class="text-muted mb-0">Dashboard Admin Perpustakaan Digital</p>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="fas fa-chart-line text-primary" style="font-size: 3rem; opacity: 0.15;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Buku -->
        <div class="col-md-6 col-lg-3 animate__animated animate__fadeInUp">
            <div class="stat-card bg-white shadow-sm">
                <div class="stat-icon">
                    <i class="fas fa-book text-primary"></i>
                </div>
                <span class="font-medium">{{ \App\Models\Buku::count() }}</span>
                <div class="stat-label">Total Buku</div>
                <div class="mt-3">
                    <a href="{{ route('buku.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye me-1"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Total Kategori -->
        <div class="col-md-6 col-lg-3 animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
            <div class="stat-card bg-white shadow-sm">
                <div class="stat-icon">
                    <i class="fas fa-tags text-success"></i>
                </div>
    <span class="font-medium">{{ \App\Models\Kategoribuku::count() }}</span>
                <div class="stat-label">Total Kategori</div>
                <div class="mt-3">
                    <a href="{{ route('kategoribuku.index') }}" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-eye me-1"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Total Peminjaman -->
        <div class="col-md-6 col-lg-3 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
            <div class="stat-card bg-white shadow-sm">
                <div class="stat-icon">
                    <i class="fas fa-bookmark text-warning"></i>
                </div>
                 <span class="font-medium">{{ \App\Models\Peminjaman::count() }}</span>
                <div class="stat-label">Total Peminjaman</div>
                <div class="mt-3">
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-outline-warning">
                        <i class="fas fa-eye me-1"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>

    <!-- Main Menu Section -->
    <h5 class="section-title mb-3">
        <i class="fas fa-th-large me-2 text-primary"></i>
        Menu Utama
    </h5>
    
    <div class="row g-4">
        <!-- Buku Menu -->
        <div class="col-md-6 col-lg-3">
            <div class="custom-card shadow-sm h-100 animate__animated animate__fadeInUp">
                <div class="card-header-blue d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Buku</h5>
                    <i class="fas fa-book fs-3 opacity-75"></i>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">Kelola koleksi buku perpustakaan</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('buku.index') }}" class="btn btn-primary">
                            <i class="fas fa-eye me-2"></i>
                            <span>Lihat Buku</span>
                        </a>
                        <a href="{{ route('buku.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>
                            <span>Tambah Buku</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kategori Menu -->
        <div class="col-md-6 col-lg-3">
            <div class="custom-card shadow-sm h-100 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                <div class="card-header-green d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Kategori</h5>
                    <i class="fas fa-tags fs-3 opacity-75"></i>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">Atur kategori untuk koleksi buku</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('kategoribuku.index') }}" class="btn btn-success">
                            <i class="fas fa-eye me-2"></i>
                            <span>Lihat Kategori</span>
                        </a>
                        <a href="{{ route('kategoribuku.create') }}" class="btn btn-outline-success">
                            <i class="fas fa-plus me-2"></i>
                            <span>Tambah Kategori</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peminjaman Menu -->
        <div class="col-md-6 col-lg-3">
            <div class="custom-card shadow-sm h-100 animate__animated animate__fadeInUp" style="animation-delay: 0.4s">
                <div class="card-header-yellow d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Peminjaman</h5>
                    <i class="fas fa-bookmark fs-3 opacity-75"></i>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">Kelola peminjaman buku anggota</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-warning text-white">
                            <i class="fas fa-eye me-2"></i>
                            <span>Lihat Peminjaman</span>
                        </a>
                        <a href="{{ route('peminjaman.create') }}" class="btn btn-outline-warning">
                            <i class="fas fa-plus me-2"></i>
                            <span>Peminjaman Baru</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>


    <!-- Laporan Section -->
    <h5 class="section-title mt-5 mb-3">
        <i class="fas fa-file-alt me-2 text-indigo"></i>
        Laporan
    </h5>
    
    <div class="row g-4">
        <!-- Laporan Buku -->
        <div class="col-md-6 col-lg-4">
            <div class="custom-card shadow-sm h-100 animate__animated animate__fadeInUp">
                <div class="card-header-purple d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Laporan Buku</h5>
                    <i class="fas fa-file-pdf fs-3 opacity-75"></i>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">Kelola laporan data buku perpustakaan</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('laporan.buku') }}" target="_blank" class="btn btn-purple d-flex align-items-center justify-content-center" style="background-color: var(--purple-color)">
                            <i class="fas fa-eye me-2"></i>
                            <span>Lihat Laporan Buku</span>
                        </a>
                        <a href="{{ route('laporan.buku') }}?download=true" 
                           class="btn btn-outline-purple d-flex align-items-center justify-content-center" 
                           style="color: var(--purple-color); border-color: var(--purple-color)"
                           download>
                            <i class="fas fa-download me-2"></i>
                            <span>Download PDF</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan Peminjaman -->
        <div class="col-md-6 col-lg-4">
            <div class="custom-card shadow-sm h-100 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                <div class="card-header-blue d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Laporan Peminjaman</h5>
                    <i class="fas fa-file-alt fs-3 opacity-75"></i>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">Kelola laporan data peminjaman buku</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('laporan.peminjaman') }}" target="_blank" class="btn btn-primary d-flex align-items-center justify-content-center">
                            <i class="fas fa-eye me-2"></i>
                            <span>Lihat Laporan Peminjaman</span>
                        </a>
                        <a href="{{ route('laporan.peminjaman') }}?download=true" 
                           class="btn btn-outline-primary d-flex align-items-center justify-content-center"
                           download>
                            <i class="fas fa-download me-2"></i>
                            <span>Download PDF</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
 

<!-- Additional custom styles for this specific dashboard -->
<style>
    /* Card header color variants */
    .card-header-blue {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        color: white;
        padding: 1.25rem;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }
    
    .card-header-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 1.25rem;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }
    
    .card-header-yellow {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 1.25rem;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }
    
    .card-header-purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
        padding: 1.25rem;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }
    
    /* Custom card styles */
    .custom-card {
        border-radius: 12px;
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
    }
    
    .custom-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    /* Section title styles */
    .section-title {
        font-weight: 600;
        color: #1f2937;
        padding-bottom: 0.5rem;
        position: relative;
    }
    
    /* Stats card styling */
    .stat-card {
        border-radius: 12px;
        padding: 1.5rem;
        height: 100%;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
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

    /* Custom color variables */
    :root {
        --purple-color: #8b5cf6;
        --indigo-color: #6366f1;
    }
    
    .text-indigo {
        color: var(--indigo-color);
    }
    
    .btn-outline-purple {
        color: var(--purple-color);
        border-color: var(--purple-color);
    }
    
    .btn-outline-purple:hover {
        background-color: var(--purple-color);
        color: white;
    }
</style>
@endsection