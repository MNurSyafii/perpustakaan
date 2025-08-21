@extends('layout')

@section('perpus')
<div class="container mt-4 mt-lg-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-header bg-primary text-white py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-book-reader me-2"></i> Laporan Peminjaman Buku
                        </h5>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('laporan.peminjaman.generate') }}" method="POST" target="_blank" id="laporanPeminjamanForm" class="needs-validation" novalidate>
                        @csrf

                        <!-- User and Status Selection -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Peminjam</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-user text-primary"></i>
                                    </span>
                                    <select name="user_id" class="form-select form-select-lg">
                                        <option value="" selected>-- Semua Peminjam --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Status Peminjaman</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-info-circle text-primary"></i>
                                    </span>
                                    <select name="status_peminjaman" class="form-select form-select-lg">
                                        <option value="" selected>-- Semua Status --</option>
                                        @foreach($status as $s)
                                            <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Date Range Selection -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Tanggal Mulai</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-calendar text-primary"></i>
                                    </span>
                                    <input type="date" name="tanggal_mulai" 
                                           class="form-control form-control-lg"
                                           max="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Tanggal Selesai</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-calendar-check text-primary"></i>
                                    </span>
                                    <input type="date" name="tanggal_selesai" 
                                           class="form-control form-control-lg"
                                           max="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Sorting Options -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Urutkan Berdasarkan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-sort text-primary"></i>
                                    </span>
                                    <select name="sort_by" class="form-select form-select-lg" required>
                                        <option value="tanggal_peminjaman">Tanggal Peminjaman</option>
                                        <option value="tanggal_pengembalian">Tanggal Pengembalian</option>
                                        <option value="status_peminjaman">Status Peminjaman</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Urutan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-sort-alpha-down text-primary"></i>
                                    </span>
                                    <select name="sort_order" class="form-select form-select-lg" required>
                                        <option value="asc">Menaik (Lama ke Baru)</option>
                                        <option value="desc">Menurun (Baru ke Lama)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Meta Information -->
                        <div class="meta-info mb-4">
                            <div class="d-flex justify-content-between align-items-center text-muted small">
                                <div>
                                    <p class="mb-0">
                                        <i class="fas fa-user me-1"></i> Generated by: {{ Auth::user()->name }}
                                    </p>
                                    <p class="mb-0">
                                        <i class="fas fa-clock me-1"></i> {{ now()->format('d M Y H:i') }}
                                    </p>
                                </div>
                                <div>
                                    <span class="badge bg-light text-primary">
                                        <i class="fas fa-info-circle me-1"></i> PDF akan dibuka di tab baru
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-file-pdf me-2"></i> Generate PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn {
    padding: 0.75rem 1.5rem;
    font-size: 0.95rem;
    font-weight: 500;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
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

.meta-info {
    background-color: #f8fafc;
    border-radius: 0.5rem;
    padding: 1rem;
}

.badge {
    padding: 0.5em 0.8em;
    font-weight: 500;
}
</style>

<script>
document.getElementById('laporanPeminjamanForm').addEventListener('submit', function(event) {
    const tglMulai = document.getElementById('tanggal_mulai').value;
    const tglSelesai = document.getElementById('tanggal_selesai').value;

    if (tglMulai && tglSelesai && tglSelesai < tglMulai) {
        alert('Tanggal Selesai tidak boleh lebih kecil dari Tanggal Mulai.');
        event.preventDefault();
    }
});

// Initialize date inputs with current date range
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const thirtyDaysAgo = new Date(today.getTime() - (30 * 24 * 60 * 60 * 1000));
    
    const startDate = document.querySelector('input[name="tanggal_mulai"]');
    const endDate = document.querySelector('input[name="tanggal_selesai"]');
    
    startDate.value = thirtyDaysAgo.toISOString().split('T')[0];
    endDate.value = today.toISOString().split('T')[0];
});
</script>
@endsection