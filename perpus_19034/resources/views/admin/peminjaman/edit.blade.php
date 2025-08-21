@extends('layout')

@section('perpus')
<div class="container mt-4 mt-lg-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            <div class="card shadow-lg rounded-4 border-0 overflow-hidden">
                <div class="card-header bg-primary text-white py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-edit me-2"></i> Edit Peminjaman
                        </h5>
                        <span class="badge bg-white text-primary px-3 py-2 rounded-pill">
                            ID: #{{ $peminjaman->id }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <h5 class="alert-heading fw-medium mb-2">
                                <i class="fas fa-exclamation-circle me-2"></i>Error Validasi
                            </h5>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Nama Peminjam Field -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Nama Peminjam <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user text-primary"></i></span>
                                <select name="user_id" class="form-select form-select-lg @error('user_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Peminjam --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $peminjaman->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Judul Buku Field -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Judul Buku <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-book text-primary"></i></span>
                                <select name="buku_id" class="form-select form-select-lg @error('buku_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Buku --</option>
                                    @foreach ($bukus as $item)
                                        <option value="{{ $item->id }}" {{ $peminjaman->buku_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->judul }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('buku_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tanggal Peminjaman Field -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Tanggal Peminjaman <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-calendar text-primary"></i></span>
                                <input type="date" name="tanggal_peminjaman" 
                                       class="form-control form-control-lg @error('tanggal_peminjaman') is-invalid @enderror" 
                                       value="{{ $peminjaman->tanggal_peminjaman }}" required>
                                @error('tanggal_peminjaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tanggal Pengembalian Field -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Tanggal Pengembalian <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-calendar-check text-primary"></i></span>
                                <input type="date" name="tanggal_pengembalian" 
                                       class="form-control form-control-lg @error('tanggal_pengembalian') is-invalid @enderror" 
                                       value="{{ $peminjaman->tanggal_pengembalian }}" required>
                                @error('tanggal_pengembalian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Peminjaman Field -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Status Peminjaman <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-info-circle text-primary"></i></span>
                                <select name="status_peminjaman" class="form-select form-select-lg @error('status_peminjaman') is-invalid @enderror" required>
                                    <option value="Menunggu" {{ $peminjaman->status_peminjaman == 'Menunggu' ? 'selected' : '' }}>
                                        Menunggu
                                    </option>
                                    <option value="Disetujui" {{ $peminjaman->status_peminjaman == 'Disetujui' ? 'selected' : '' }}>
                                        Disetujui
                                    </option>
                                    <option value="Ditolak" {{ $peminjaman->status_peminjaman == 'Ditolak' ? 'selected' : '' }}>
                                        Ditolak
                                    </option>
                                    <option value="Dipinjam" {{ $peminjaman->status_peminjaman == 'Dipinjam' ? 'selected' : '' }}>
                                        Dipinjam
                                    </option>
                                    <option value="Dikembalikan" {{ $peminjaman->status_peminjaman == 'Dikembalikan' ? 'selected' : '' }}>
                                        Dikembalikan
                                    </option>
                                </select>
                                @error('status_peminjaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Meta Information -->
                        <div class="meta-info mb-4">
                            <p class="text-muted mb-1">
                                <small><i class="fas fa-clock me-1"></i> Dibuat: {{ $peminjaman->created_at->format('d M Y H:i') }}</small>
                            </p>
                            <p class="text-muted mb-0">
                                <small><i class="fas fa-user me-1"></i> Diubah oleh: {{ Auth::user()->name }}</small>
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('peminjaman.index') }}" class="btn btn-action btn-cancel">
                                <i class="fas fa-times me-2"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-action btn-save">
                                <i class="fas fa-save me-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
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
    
    /* Form Elements */
    .form-control, .form-select {
        border: 1px solid #e2e8f0;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        border-radius: var(--border-radius);
        transition: var(--transition);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.15);
    }
    
    .form-control-lg, .form-select-lg {
        padding: 0.85rem 1.2rem;
    }
    
    .input-group-text {
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: var(--primary-color);
    }
    
    /* Meta Information */
    .meta-info {
        background-color: #f8fafc;
        border-radius: var(--border-radius);
        padding: 1rem;
    }
    
    /* Action Buttons */
    .btn-action {
        padding: 0.75rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 500;
        border-radius: var(--border-radius);
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--box-shadow);
    }
    
    .btn-cancel {
        background-color: white;
        color: var(--secondary-color);
        border: 1px solid #e2e8f0;
    }
    
    .btn-cancel:hover {
        background-color: #f1f5f9;
        color: #4b5563;
    }
    
    .btn-save {
        background-color: var(--primary-color);
        color: white;
        border: none;
    }
    
    .btn-save:hover {
        background-color: var(--primary-hover);
        color: white;
        transform: translateY(-2px);
    }
    
    /* Alert Styling */
    .alert {
        border: none;
    }
    
    .alert-danger {
        background-color: #fee2e2;
        color: #b91c1c;
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
    }
</style>

<script>
    // Form validation
    (function() {
        'use strict';
        
        var forms = document.querySelectorAll('.needs-validation');
        
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    
                    form.classList.add('was-validated');
                }, false);
            });
    })();
</script>
@endsection