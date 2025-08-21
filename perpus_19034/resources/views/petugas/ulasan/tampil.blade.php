@extends('layout')

@section('perpus')
<div class="container-fluid px-4 px-lg-5">
    <div class="d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between mb-4">
        <div class="d-flex flex-column">
            <h1 class="page-title mb-0">  
            </h1>
        </div>
        <div class="d-flex gap-2">
            <div class="search-form flex-grow-1">
               <form action="{{ route('ulasan.search') }}" method="GET" class="d-flex gap-2">
            <div class="search-form flex-grow-1">
                <div class="input-group input-group-merged shadow-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" name="keyword" class="form-control form-control-sm border-start-0"
                        placeholder="Cari ulasan..." value="{{ request('keyword') }}">
                </div>
            </div>
        </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages with Animation -->
    <div class="flash-messages position-fixed top-0 end-0 p-3" style="z-index: 11">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2 fs-4"></i>
                    <div>
                        <h6 class="alert-heading mb-1">Sukses!</h6>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-2 fs-4"></i>
                    <div>
                        <h6 class="alert-heading mb-1">Error!</h6>
                        <p class="mb-0">{{ session('error') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- Reviews Table Card -->
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="reviewsTable">
                    <thead class="table-header">
                        <tr>
                            <th class="ps-4" style="width: 25%">
                                <i class="fas fa-book me-2 text-primary"></i>Buku
                            </th>
                            <th style="width: 20%">
                                <i class="fas fa-user me-2 text-primary"></i>Pengguna
                            </th>
                            <th style="width: 15%">
                                <i class="fas fa-star me-2 text-primary"></i>Rating
                            </th>
                            <th style="width: 25%">
                                <i class="fas fa-comment me-2 text-primary"></i>Ulasan
                            </th>
                            <th style="width: 15%">
                                <i class="fas fa-calendar me-2 text-primary"></i>Tanggal
                            </th>
                            <th class="pe-4" style="width: 15%">
                                <i class="fas fa-cogs me-2 text-primary"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ulasans as $ulasan)
                            <tr class="review-row">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($ulasan->buku->cover)
                                            <img src="{{ asset('covers/' . $ulasan->buku->cover) }}" 
                                                 alt="{{ $ulasan->buku->judul }}" 
                                                 class="book-cover rounded-3 me-3 shadow-sm">
                                        @else
                                            <div class="book-cover-placeholder rounded-3 me-3 shadow-sm">
                                                <i class="fas fa-book text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="book-title fw-semibold">{{ \Illuminate\Support\Str::limit($ulasan->buku->judul, 20) }}</div>
                                            <small class="text-muted">{{ \Illuminate\Support\Str::limit($ulasan->buku->penulis, 20) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar bg-primary text-white rounded-circle me-2">
                                            {{ substr($ulasan->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="user-name">{{ $ulasan->user->name }}</div>
                                            <small class="text-muted">{{ \Illuminate\Support\Str::limit($ulasan->user->email, 15) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $ulasan->ranting)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                        <span class="ms-1 text-muted">({{ $ulasan->ranting }}/5)</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="review-text" title="{{ $ulasan->ulasan }}">
                                        {{ \Illuminate\Support\Str::limit($ulasan->ulasan, 50) }}
                                    </div>
                                </td>
                                <td>
                                    <div class="review-date">{{ $ulasan->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $ulasan->created_at->format('H:i') }}</small>
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex justify-content-start gap-2">
                                        <a href="{{ route('admin.ulasan.show', $ulasan->id) }}" 
                                           class="btn btn-action btn-view" 
                                           data-bs-toggle="tooltip" 
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.ulasan.destroy', $ulasan->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-action btn-delete" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-star text-primary opacity-25"></i>
                                        </div>
                                        <h3 class="empty-state-title">Tidak ada data ulasan</h3>
                                        <p class="empty-state-text">Belum ada ulasan yang tersedia</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination with Count -->
        @if($ulasans->hasPages())
        <div class="card-footer bg-transparent border-top-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="text-muted small mb-2 mb-md-0">
                    Menampilkan <span class="fw-semibold">{{ $ulasans->firstItem() }} - {{ $ulasans->lastItem() }}</span> dari <span class="fw-semibold">{{ $ulasans->total() }}</span> ulasan
                </div>
                <div class="pagination-container">
                    {{ $ulasans->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Color Variables */
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

    /* Page Header */
    .page-title {
        font-size: 1.5rem;
        color: var(--dark-color);
        font-weight: 600;
    }

    /* Search and Filter */
    .search-form .input-group-merged {
        border-radius: 0.5rem;
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .search-form .form-control {
        border: none;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        background-color: white;
    }

    .search-form .form-control:focus {
        box-shadow: none;
    }

    .form-select {
        border-radius: 0.5rem;
        border: 1px solid var(--border-color);
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
    }

    /* Alert Styling */
    .alert {
        border-radius: 0.5rem;
        border: none;
        box-shadow: var(--card-shadow);
        max-width: 400px;
    }

    /* Table Styling */
    .table {
        --bs-table-bg: transparent;
        margin-bottom: 0;
    }

    .table-header {
        background-color: #f8fafc;
        position: sticky;
        top: 0;
    }

    .table-header th {
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .review-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid var(--border-color);
    }

    .review-row:hover {
        background-color: #f8fafc;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* Book Cover */
    .book-cover {
        width: 40px;
        height: 60px;
        object-fit: cover;
    }

    .book-cover-placeholder {
        width: 40px;
        height: 60px;
        background-color: #f1f5f9;
        display: flex;
        justify-content: center;
        align-items: center;
        color: var(--text-muted);
    }

    .book-title {
        color: var(--dark-color);
        transition: color 0.2s ease;
    }

    .review-row:hover .book-title {
        color: var(--primary-color);
    }

    /* User Avatar */
    .user-avatar {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }

    .user-name {
        color: var(--dark-color);
    }

    /* Stars Rating */
    .stars {
        color: var(--warning-color);
    }

    /* Review Text */
    .review-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 300px;
    }

    /* Review Date */
    .review-date {
        color: var(--dark-color);
    }

    /* Action Buttons */
    .btn-action {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50% !important;
        transition: all 0.3s ease;
    }

    .btn-view {
        background-color: rgba(var(--bs-info-rgb), 0.1);
        color: var(--info-color);
        border: none;
    }

    .btn-view:hover {
        background-color: var(--info-color);
        color: white;
        transform: translateY(-2px);
    }

    .btn-delete {
        background-color: rgba(var(--bs-danger-rgb), 0.1);
        color: var(--danger-color);
        border: none;
    }

    .btn-delete:hover {
        background-color: var(--danger-color);
        color: white;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-state {
        padding: 3rem 0;
        text-align: center;
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
    }

    .empty-state-title {
        font-size: 1.25rem;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .empty-state-text {
        color: var(--text-muted);
        max-width: 400px;
        margin: 0 auto 1rem;
    }

    /* Pagination */
    .pagination-container .pagination {
        margin-bottom: 0;
    }

    .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .page-link {
        color: var(--primary-color);
        border-radius: 0.375rem !important;
        margin: 0 0.25rem;
        border: 1px solid var(--border-color);
    }

    .page-link:hover {
        color: var(--primary-hover);
        background-color: #f1f5f9;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .d-flex.flex-md-row {
            flex-direction: column !important;
        }
        
        .search-form, .form-select {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .btn-action {
            width: 28px;
            height: 28px;
            font-size: 0.75rem;
        }

        .review-text {
            max-width: 150px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            trigger: 'hover focus'
        });
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Add animation to review rows on load
    const reviewRows = document.querySelectorAll('.review-row');
    reviewRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(10px)';
        row.style.transition = 'all 0.4s ease';
        
        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, 100 * index);
    });

    // Enhanced search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        filterTable();
    });

    // Rating filter
    document.getElementById('filterRating').addEventListener('change', function() {
        filterTable();
    });

    // User filter
    document.getElementById('filterUser').addEventListener('change', function() {
        filterTable();
    });

    function filterTable() {
        let searchQuery = document.getElementById('searchInput').value.toLowerCase();
        let selectedRating = document.getElementById('filterRating').value;
        let selectedUser = document.getElementById('filterUser').value.toLowerCase();
        let table = document.getElementById('reviewsTable');
        let tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            let tds = tr[i].getElementsByTagName('td');
            if (tds.length === 0) continue;

            let bookTitle = tds[0] ? tds[0].textContent.toLowerCase() : '';
            let userName = tds[1] ? tds[1].textContent.toLowerCase() : '';
            let review = tds[3] ? tds[3].textContent.toLowerCase() : '';
            let stars = tds[2] ? tds[2].querySelectorAll('.fas.fa-star').length : 0;

            let matchesSearch = bookTitle.includes(searchQuery) || userName.includes(searchQuery) || review.includes(searchQuery);
            let matchesRating = selectedRating === '' || stars == selectedRating;
            let matchesUser = selectedUser === '' || userName.includes(selectedUser);

            tr[i].style.display = (matchesSearch && matchesRating && matchesUser) ? '' : 'none';
        }
    }
});
</script>
@endsection