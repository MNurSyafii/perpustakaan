@extends('layout')

@section('perpus')
<div class="container-fluid px-4 px-lg-5">
    <div class="d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between mb-4">
        <div class="d-flex flex-column">
            <h3 class="fw-bold mb-0"></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
        </div>
    </div>

    <!-- Flash Messages -->
    <div class="flash-messages position-fixed top-0 end-0 p-3" style="z-index: 11">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-2 fs-4"></i>
                    <div>
                        <h6 class="alert-heading mb-1">Error!</h6>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- Form Card -->
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4">
        <div class="card-body p-5">
            <form method="POST" action="{{ route('kategoribuku.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="inputnama_kategori" class="form-label fw-semibold">Nama Kategori</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-tag text-primary"></i>
                        </span>
                        <input 
                            type="text" 
                            name="nama_kategori" 
                            id="inputnama_kategori" 
                            class="form-control form-control-lg @error('nama_kategori') is-invalid @enderror" 
                            placeholder="Masukkan Nama Kategori"
                            value="{{ old('nama_kategori') }}"
                            required
                        >
                    </div>
                    @error('nama_kategori')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-3 mt-5">
                            <a href="{{ route('kategoribuku.index') }}" class="btn btn-action btn-cancel">
                                <i class="fas fa-times me-2"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-action btn-save">
                                <i class="fas fa-save me-2"></i>
                                Simpan Data
                            </button>
            </form>
        </div>
    </div>
</div>

<style>
    /* Consistent with your index page styles */
    :root {
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --secondary-color: #7c3aed;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
        --info-color: #3b82f6;
        --light-color: #f8fafc;
        --dark-color: #1e293b;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .card {
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .form-control, .form-select {
        border: 1px solid var(--border-color);
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.25);
    }

    .input-group-text {
        background-color: #f8fafc;
        border: 1px solid var(--border-color);
        border-right: none;
    }

    .input-group .form-control {
        border-left: none;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
    }

    .btn-secondary {
        background-color: white;
        color: var(--dark-color);
        border: 1px solid var(--border-color);
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #f8fafc;
        color: var(--dark-color);
        border-color: var(--border-color);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }
        
        .btn {
            padding: 0.5rem 1rem;
        }
    }
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Add animation to form card
    const formCard = document.querySelector('.card');
    formCard.style.opacity = '0';
    formCard.style.transform = 'translateY(20px)';
    formCard.style.transition = 'all 0.4s ease';
    
    setTimeout(() => {
        formCard.style.opacity = '1';
        formCard.style.transform = 'translateY(0)';
    }, 100);
});
</script>
@endsection