@extends('layout')

@section('perpus')
<div class="container mt-4 mt-lg-5">
    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Buku</h6>
                            <h4 class="mb-0 fw-bold">{{ $totalBuku }}</h4>
                        </div>
                        <div class="icon-box bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-book text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Peminjaman</h6>
                            <h4 class="mb-0 fw-bold">{{ $totalPeminjaman }}</h4>
                        </div>
                        <div class="icon-box bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-book-reader text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Anggota</h6>
                            <h4 class="mb-0 fw-bold">{{ $totalAnggota }}</h4>
                        </div>
                        <div class="icon-box bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-users text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Laporan Buku Card -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg rounded-4 border-0 h-100">
                <div class="card-header bg-primary text-white py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-book me-2"></i> Laporan Buku
                        </h5>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('laporan.buku.generate') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-medium">Periode Laporan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-calendar text-primary"></i>
                                </span>
                                <input type="date" name="start_date" class="form-control" required>
                                <span class="input-group-text bg-light">sampai</span>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium">Status Buku</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-filter text-primary"></i>
                                </span>
                                <select name="status" class="form-select">
                                    <option value="all">Semua Status</option>
                                    <option value="tersedia">Tersedia</option>
                                    <option value="dipinjam">Sedang Dipinjam</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-file-pdf me-2"></i>Generate PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Laporan Peminjaman Card -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg rounded-4 border-0 h-100">
                <div class="card-header bg-primary text-white py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-book-reader me-2"></i> Laporan Peminjaman
                        </h5>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('laporan.peminjaman.generate') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-medium">Periode Laporan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-calendar text-primary"></i>
                                </span>
                                <input type="date" name="start_date" class="form-control" required>
                                <span class="input-group-text bg-light">sampai</span>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium">Status Peminjaman</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-filter text-primary"></i>
                                </span>
                                <select name="status" class="form-select">
                                    <option value="all">Semua Status</option>
                                    <option value="dipinjam">Sedang Dipinjam</option>
                                    <option value="dikembalikan">Dikembalikan</option>
                                    <option value="terlambat">Terlambat</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-file-pdf me-2"></i>Generate PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Meta Information -->
    <div class="card shadow-sm rounded-4 border-0 mt-2">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="meta-info text-muted small">
                    <p class="mb-0">
                        <i class="fas fa-user me-1"></i> Generated by: {{ Auth::user()->name }}
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-clock me-1"></i> Last updated: {{ now()->format('d M Y H:i') }}
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-light btn-sm" onclick="window.print()">
                        <i class="fas fa-print me-1"></i> Print
                    </a>
                    <a href="#" class="btn btn-light btn-sm" onclick="exportToExcel()">
                        <i class="fas fa-file-excel me-1"></i> Export
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-box {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn {
    padding: 0.75rem 1.5rem;
    font-size: 0.95rem;
    font-weight: 500;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.input-group-text {
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
}

.form-control, .form-select {
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
}

.form-control:focus, .form-select:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.15);
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

@media print {
    .no-print {
        display: none;
    }
}
</style>

<script>
function exportToExcel() {
    // Add your Excel export logic here
    alert('Export to Excel functionality will be implemented here');
}

// Initialize date inputs with current date range
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const thirtyDaysAgo = new Date(today.getTime() - (30 * 24 * 60 * 60 * 1000));
    
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(function(input, index) {
        if (index % 2 === 0) {
            input.value = thirtyDaysAgo.toISOString().split('T')[0];
        } else {
            input.value = today.toISOString().split('T')[0];
        }
    });
});
</script>
@endsection