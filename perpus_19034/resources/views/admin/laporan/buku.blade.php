@extends('layout')

@section('perpus')
<div class="container mt-4 mt-lg-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-header bg-primary text-white py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-book me-2"></i> Laporan Buku
                        </h5>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('laporan.buku.generate') }}" method="POST" target="_blank" class="needs-validation" novalidate>
                        @csrf
                        
                        <!-- Publisher & Year Selection -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Penerbit</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-building text-primary"></i>
                                    </span>
                                    <select name="penerbit" class="form-select form-select-lg">
                                        <option value="">-- Semua Penerbit --</option>
                                        @foreach($penerbit as $p)
                                        <option value="{{ $p }}">{{ $p }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Tahun Terbit</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-calendar text-primary"></i>
                                    </span>
                                    <select name="tahun_terbit" class="form-select form-select-lg">
                                        <option value="">-- Semua Tahun --</option>
                                        @foreach($tahun as $t)
                                        <option value="{{ $t }}">{{ $t }}</option>
                                        @endforeach
                                    </select>
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
                                        <option value="judul">Judul</option>
                                        <option value="penulis">Penulis</option>
                                        <option value="penerbit">Penerbit</option>
                                        <option value="tahun_terbit">Tahun Terbit</option>
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
                                        <option value="asc">Menaik (A-Z / 0-9)</option>
                                        <option value="desc">Menurun (Z-A / 9-0)</option>
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

.form-select {
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
}

.form-select:focus {
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
@endsection