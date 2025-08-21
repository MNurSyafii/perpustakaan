@extends('layout')

@section('perpus')
<div class="container-fluid px-4 px-lg-5">
    <div class="d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between mb-4">
        <div class="d-flex flex-column">
            <h3 class="fw-bold mb-0"></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('kategoribuku.index') }}"></a></li>
                    <li class="breadcrumb-item active" aria-current="page"></li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4">
        <div class="card-body p-5">
            <div class="detail-container">
                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-tag text-primary me-2"></i>
                        Nama Kategori
                    </div>
                    <div class="detail-value">{{ $kategoribuku->nama_kategori }}</div>
                </div>

                <div class="d-flex justify-content-end gap-3 mt-5">
                    <a href="{{ route('kategoribuku.index') }}" class="btn btn-action btn-return">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
        --border-radius: 0.5rem;
        --box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --transition: all 0.3s ease;
    }

    .card {
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .detail-container {
        background-color: white;
        border-radius: var(--border-radius);
    }

    .detail-item {
        padding: 1.5rem;
        border-radius: var(--border-radius);
        background-color: var(--light-color);
        border: 1px solid var(--border-color);
        margin-bottom: 1rem;
    }

    .detail-label {
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .detail-value {
        color: var(--dark-color);
        font-size: 1.1rem;
        padding: 0.5rem 0;
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
    
    .btn-return {
        background-color: white;
        color: var(--secondary-color);
        border: 1px solid var(--border-color);
    }
    
    .btn-return:hover {
        background-color: #f1f5f9;
        color: #4b5563;
        transform: translateY(-2px);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }
        
        .detail-item {
            padding: 1rem;
        }
        
        .btn {
            padding: 0.5rem 1rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation to detail card
    const detailCard = document.querySelector('.card');
    detailCard.style.opacity = '0';
    detailCard.style.transform = 'translateY(20px)';
    detailCard.style.transition = 'all 0.4s ease';
    
    setTimeout(() => {
        detailCard.style.opacity = '1';
        detailCard.style.transform = 'translateY(0)';
    }, 100);
});
</script>
@endsection