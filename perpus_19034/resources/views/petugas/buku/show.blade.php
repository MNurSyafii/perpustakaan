@extends('layout')

@section('perpus')
<div class="container mt-4">
    <!-- Header with Back Button -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
            <i class="fas fa-arrow-left me-2"></i>
            Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <!-- Book Cover Column -->
                        <div class="col-md-5 p-4 d-flex flex-column align-items-center bg-light">
                            @if ($buku->cover)
                                <div class="book-cover-container mb-3">
                                    <img src="{{ asset('covers/' . $buku->cover) }}" 
                                         alt="Cover Buku" 
                                         class="img-fluid rounded shadow-sm"
                                         style="max-height: 350px; width: auto;">
                                </div>
                            @else
                                <div class="no-cover-placeholder text-center py-4">
                                    <div class="bg-white rounded-3 p-4 shadow-sm">
                                        <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                                        <p class="text-muted mb-0">Tidak ada cover</p>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Action Buttons -->
                            <div class="d-flex gap-2 mt-auto w-100">
                                <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning btn-sm flex-grow-1">
                                    <i class="fas fa-edit me-2"></i>
                                    Edit
                                </a>
                                <form action="{{ route('buku.destroy', $buku->id) }}" 
                                      method="POST" 
                                      class="flex-grow-1"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                        <i class="fas fa-trash me-2"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Book Details Column -->
                        <div class="col-md-7 p-4">
                            <h3 class="fw-bold text-dark mb-4">{{ $buku->judul }}</h3>
                            
                            <div class="book-details">
                                <div class="detail-item">
                                    <span class="detail-label">Penulis</span>
                                    <span class="detail-value">{{ $buku->penulis }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Penerbit</span>
                                    <span class="detail-value">{{ $buku->penerbit }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Tahun Terbit</span>
                                    <span class="detail-value">{{ $buku->tahun_terbit }}</span>
                                </div>
                                @if($buku->kategoribukus->count() > 0)
                                <div class="detail-item">
                                    <span class="detail-label">Kategori</span>
                                    <div class="detail-value">
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($buku->kategoribukus as $kategori)
                                                <span class="badge bg-primary">{{ $kategori->nama_kategori }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="detail-item">
                                    <span class="detail-label">Ditambahkan</span>
                                    <span class="detail-value">{{ $buku->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Diperbarui</span>
                                    <span class="detail-value">{{ $buku->updated_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* General Styles */
    body {
        background-color: #f8f9fa;
    }
    
    /* Card Styles */
    .card {
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    /* Book Cover Styles */
    .book-cover-container {
        max-width: 100%;
        height: 350px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
    }
    
    .no-cover-placeholder {
        width: 100%;
        height: 350px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Detail Item Styles */
    .book-details {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .detail-item {
        display: flex;
        align-items: flex-start;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }
    
    .detail-label {
        width: 120px;
        font-weight: 600;
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .detail-value {
        flex: 1;
        font-weight: 500;
        color: #343a40;
    }
    
    /* Badge Styles */
    .badge {
        font-weight: 500;
        padding: 0.5em 0.75em;
        border-radius: 6px;
        font-size: 0.8rem;
    }
    
    .bg-primary {
        background-color: #4f46e5 !important;
    }
    
    /* Button Styles */
    .btn-outline-secondary {
        border-color: #dee2e6;
        color: #6c757d;
    }
    
    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #495057;
    }
    
    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }
    
    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
        color: #212529;
    }
    
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .book-cover-container, .no-cover-placeholder {
            height: 250px;
        }
        
        .detail-item {
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .detail-label {
            width: 100%;
        }
    }
</style>
@endsection