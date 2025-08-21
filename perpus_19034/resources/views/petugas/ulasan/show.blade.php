@extends('layout')

@section('perpus')
<div class="container mt-4 mt-lg-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-header bg-primary text-white py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-star me-2"></i> Detail Ulasan
                        </h5>
                        <a href="{{ route('admin.ulasan.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Book Information -->
                    <div class="book-info mb-4 p-3 bg-light rounded-3">
                        <div class="d-flex align-items-center">
                            <div class="book-cover me-3">
                                <i class="fas fa-book fa-3x text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $ulasanbuku->buku->judul }}</h6>
                                <p class="mb-0 text-muted small">
                                    <i class="fas fa-user me-1"></i>
                                    {{ $ulasanbuku->buku->penulis }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Review Details -->
                    <div class="review-details">
                        <!-- User Info -->
                        <div class="mb-4">
                            <label class="form-label text-muted small">Pengguna</label>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-2">
                                    {{ strtoupper(substr($ulasanbuku->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $ulasanbuku->user->name }}</h6>
                                    <small class="text-muted">{{ $ulasanbuku->user->email }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="form-label text-muted small">Rating</label>
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $ulasanbuku->ranting)
                                        <i class="fas fa-star fa-lg text-warning"></i>
                                    @else
                                        <i class="far fa-star fa-lg text-warning"></i>
                                    @endif
                                @endfor
                                <span class="ms-2 text-muted">({{ $ulasanbuku->ranting }}/5)</span>
                            </div>
                        </div>

                        <!-- Review Text -->
                        <div class="mb-4">
                            <label class="form-label text-muted small">Ulasan</label>
                            <div class="p-3 bg-light rounded-3">
                                {{ $ulasanbuku->ulasan }}
                            </div>
                        </div>

                        <!-- Timestamp -->
                        <div class="meta-info text-muted small">
                            <p class="mb-1">
                                <i class="fas fa-clock me-1"></i>
                                Dibuat: {{ $ulasanbuku->created_at->format('d M Y H:i') }}
                            </p>
                            @if($ulasanbuku->updated_at != $ulasanbuku->created_at)
                                <p class="mb-0">
                                    <i class="fas fa-edit me-1"></i>
                                    Diperbarui: {{ $ulasanbuku->updated_at->format('d M Y H:i') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <form action="{{ route('admin.ulasan.destroy', $ulasanbuku->id) }}" 
                              method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt me-2"></i>
                                Hapus Ulasan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    background-color: var(--bs-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.stars {
    color: #ffc107;
}

.book-info {
    transition: all 0.3s ease;
}

.book-info:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.meta-info {
    background-color: #f8fafc;
    padding: 1rem;
    border-radius: 0.5rem;
}
</style>
@endsection