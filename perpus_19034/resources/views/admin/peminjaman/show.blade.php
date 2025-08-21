@extends('layout')

@section('perpus')
<div class="container mt-4 mt-lg-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            <div class="card shadow-lg rounded-4 border-0 overflow-hidden">
                <div class="card-header bg-primary text-white py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-info-circle me-2"></i> Detail Peminjaman
                        </h5>
                        <span class="badge bg-white text-primary px-3 py-2 rounded-pill">
                            ID: #{{ $peminjaman->id }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Nama Peminjam Field -->
                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark">Nama Peminjam</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-user text-primary"></i></span>
                            <input type="text" class="form-control form-control-lg" value="{{ $peminjaman->user->name }}" readonly>
                        </div>
                    </div>

                    <!-- Judul Buku Field -->
                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark">Judul Buku</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-book text-primary"></i></span>
                            <input type="text" class="form-control form-control-lg" value="{{ $peminjaman->buku->judul }}" readonly>
                        </div>
                    </div>

                    <!-- Tanggal Peminjaman Field -->
                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark">Tanggal Peminjaman</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-calendar text-primary"></i></span>
                            <input type="text" class="form-control form-control-lg" 
                                   value="{{ $peminjaman->tanggal_peminjaman ? \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d/m/Y') : 'Belum ditentukan' }}" 
                                   readonly>
                        </div>
                    </div>

                    <!-- Tanggal Pengembalian Field -->
                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark">Tanggal Pengembalian</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-calendar-check text-primary"></i></span>
                            <input type="text" class="form-control form-control-lg" 
                                   value="{{ $peminjaman->tanggal_pengembalian ? \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d/m/Y') : 'Belum ditentukan' }}" 
                                   readonly>
                        </div>
                    </div>

                    <!-- Status Peminjaman Field -->
                    <div class="mb-4">
                        <label class="form-label fw-medium text-dark">Status Peminjaman</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-info-circle text-primary"></i></span>
                            <input type="text" class="form-control form-control-lg" value="{{ $peminjaman->status_peminjaman }}" readonly>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-action btn-back">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'petugas')
                            <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="btn btn-action btn-edit">
                                <i class="fas fa-edit me-2"></i>
                                Edit
                            </a>
                            <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash-alt me-2"></i>
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Base Styles */
    :root {
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --secondary-color: #6c757d;
        --light-color: #f8f9fa;
        --danger-color: #dc3545;
        --success-color: #198754;
        --warning-color: #ffc107;
        --border-radius: 0.5rem;
        --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    /* Card Styling */
    .card {
        border: none;
        transition: var(--transition);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
    }

    /* Detail Section Styling */
    .detail-section {
        background-color: #fff;
        border-radius: var(--border-radius);
    }

    .detail-item {
        padding: 1.5rem;
        background-color: #f8fafc;
        border-radius: var(--border-radius);
        margin-bottom: 1rem;
    }

    .detail-label {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(79, 70, 229, 0.1);
    }

    .detail-content {
        color: #4b5563;
    }

    .detail-content strong {
        color: #1f2937;
        min-width: 120px;
        display: inline-block;
    }

    /* Badge Styling */
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    /* Alert Styling */
    .alert {
        border-radius: var(--border-radius);
        border: none;
    }

    /* Button Styling */
    .btn-action {
        padding: 0.75rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 500;
        border-radius: var(--border-radius);
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-back {
        background-color: var(--light-color);
        color: var(--secondary-color);
        border: 1px solid #e2e8f0;
    }

    .btn-back:hover {
        background-color: #e2e8f0;
        color: #4b5563;
    }

    .btn-edit {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-edit:hover {
        background-color: var(--primary-hover);
        color: white;
    }

    .btn-delete {
        background-color: var(--danger-color);
        color: white;
    }

    .btn-delete:hover {
        background-color: #bb2d3b;
        color: white;
    }

    /* Meta Information */
    .meta-info {
        background-color: #f8fafc;
        border-radius: var(--border-radius);
        padding: 1rem;
        margin-top: 2rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }
        
        .btn-action {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
        }
        
        .detail-content strong {
            min-width: 100px;
        }
    }
</style>
@endsection