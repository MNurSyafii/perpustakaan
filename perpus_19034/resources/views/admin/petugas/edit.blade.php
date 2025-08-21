@extends('layout')

@section('perpus')
<div class="container mt-4 mt-lg-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-header bg-primary text-white py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-user-edit me-2"></i> Edit Anggota
                        </h5>
                        <span class="badge bg-white text-primary px-3 py-2">
                            ID: #{{ $user->id }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <h5 class="alert-heading fw-medium mb-2">
                                <i class="fas fa-exclamation-circle me-2"></i>Error Validasi
                            </h5>
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('user.update', $user->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Nama Lengkap -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-user text-primary"></i>
                                </span>
                                <input type="text" name="nama_lengkap" 
                                       class="form-control form-control-lg @error('nama_lengkap') is-invalid @enderror"
                                       value="{{ old('nama_lengkap', $user->name) }}" 
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
                                       value="{{ old('email', $user->email) }}" 
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
                                          required>{{ old('alamat', $user->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Baru -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" name="password" 
                                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                                       placeholder="Kosongkan jika tidak ingin mengubah">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Minimal 8 karakter</small>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-dark">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" name="password_confirmation" 
                                       class="form-control form-control-lg"
                                       placeholder="Konfirmasi password baru">
                            </div>
                        </div>

                        <!-- Meta Information -->
                        <div class="meta-info mb-4">
                            <p class="text-muted mb-0">
                                <small>
                                    <i class="fas fa-user me-1"></i> Diubah oleh: {{ Auth::user()->name }}
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
.btn-action {
    padding: 0.75rem 1.5rem;
    font-size: 0.95rem;
    font-weight: 500;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.btn-cancel {
    background-color: white;
    color: #6c757d;
    border: 1px solid #e2e8f0;
}

.btn-cancel:hover {
    background-color: #f1f5f9;
    color: #4b5563;
}

.btn-save {
    background-color: var(--bs-primary);
    color: white;
    border: none;
}

.btn-save:hover {
    background-color: #4338ca;
    color: white;
    transform: translateY(-2px);
}

.input-group-text {
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
}

.form-control {
    border: 1px solid #e2e8f0;
}

.form-control:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.15);
}

.meta-info {
    background-color: #f8fafc;
    border-radius: 0.5rem;
    padding: 1rem;
}

.alert {
    border: none;
}

.alert-danger {
    background-color: #fee2e2;
    color: #991b1b;
}
</style>
@endsection