@extends('layout')

@section('perpus')
<div class="container mt-4 mt-lg-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-header bg-primary text-white py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-user-plus me-2"></i> Tambah Anggota Baru
                        </h5>
                    </div>
                </div>

                <div class="card-body p-4">
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

                    <form action="{{ route('user.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <!-- Nama Lengkap -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-user text-primary"></i>
                                </span>
                                <input type="text" name="nama_lengkap" 
                                       class="form-control form-control-lg @error('nama_lengkap') is-invalid @enderror"
                                       value="{{ old('nama_lengkap') }}" 
                                       placeholder="Masukkan nama lengkap" 
                                       required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-envelope text-primary"></i>
                                </span>
                                <input type="email" name="email" 
                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" 
                                       placeholder="Masukkan alamat email" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Alamat <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                </span>
                                <textarea name="alamat" 
                                          class="form-control form-control-lg @error('alamat') is-invalid @enderror"
                                          rows="3" 
                                          placeholder="Masukkan alamat lengkap" 
                                          required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Role Selection -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Peran <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-user-tag text-primary"></i>
                                </span>
                                <select name="role" class="form-select form-select-lg @error('role') is-invalid @enderror" required>
                                    <option value="">-- Pilih Peran --</option>
                                    <option value="peminjam" {{ old('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                                    <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" name="password" 
                                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                                       placeholder="Masukkan password" 
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Confirmation -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Konfirmasi Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" name="password_confirmation" 
                                       class="form-control form-control-lg"
                                       placeholder="Konfirmasi password" 
                                       required>
                            </div>
                        </div>

                        <!-- Meta Information -->
                        <div class="meta-info mb-4">
                            <p class="text-muted mb-0">
                                <small>
                                    <i class="fas fa-user me-1"></i> Dibuat oleh: {{ Auth::user()->name }}
                                </small>
                            </p>
                            <p class="text-muted mb-0">
                                <small>
                                    <i class="fas fa-clock me-1"></i> {{ now()->format('d M Y H:i') }}
                                </small>
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('user.tampil') }}" class="btn btn-action btn-cancel">
                                <i class="fas fa-times me-2"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-action btn-save">
                                <i class="fas fa-save me-2"></i>
                                Simpan Data
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
        --border-radius: 0.5rem;
        --transition: all 0.3s ease;
    }
    
    /* Card & Form Styling */
    .card {
        border: none;
        transition: var(--transition);
    }
    
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
</style>
@endsection