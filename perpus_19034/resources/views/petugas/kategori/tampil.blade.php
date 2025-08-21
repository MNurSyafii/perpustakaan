@extends('layout')

@section('perpus')
<div class="container-fluid px-4 px-lg-5">
    <div class="d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between mb-4">
        <div class="d-flex flex-column">
        </div>
        <div class="d-flex gap-2">
            <form action="{{ route('kategoribuku.index') }}" method="GET" class="search-form flex-grow-1">
                <div class="input-group input-group-merged shadow-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control form-control-sm border-start-0" 
                           placeholder="Cari kategori..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-search d-none d-md-block">
                        Cari
                    </button>
                </div>
            </form>
            <a href="{{ route('kategoribuku.create') }}" class="btn btn-add shadow-sm">
                <i class="fas fa-plus me-1"></i>Tambah Kategori
            </a>
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

    <!-- Category Table Card -->
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header">
                        <tr>
                            <th class="text-center ps-4" style="width: 5%">No</th>
                            <th style="width: 75%">Nama Kategori</th>
                            <th class="text-center pe-4" style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategoribukus as $item)
                        <tr class="category-row">
                            <td class="text-center ps-4 text-muted fw-medium">{{ $loop->iteration + ($kategoribukus->currentPage() - 1) * $kategoribukus->perPage() }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="category-badge me-3">
                                        <i class="fas fa-tag text-primary"></i>
                                    </span>
                                    <span class="category-name fw-semibold">{{ \Illuminate\Support\Str::limit($item->nama_kategori, 30) }}</span>
                                </div>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('kategoribuku.show', $item->id) }}" 
                                       class="btn btn-action btn-view" 
                                       data-bs-toggle="tooltip" 
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kategoribuku.edit', $item->id) }}" 
                                       class="btn btn-action btn-edit" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kategoribuku.destroy', $item->id) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-action btn-delete" 
                                                data-bs-toggle="tooltip" 
                                                title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-tags text-primary opacity-25"></i>
                                    </div>
                                    <h3 class="empty-state-title">Tidak ada data kategori</h3>
                                    <p class="empty-state-text">Mulai dengan menambahkan kategori baru</p>
                                    <a href="{{ route('kategoribuku.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus me-1"></i>Tambah Kategori Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination with Count -->
        @if($kategoribukus->hasPages())
        <div class="card-footer bg-transparent border-top-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="text-muted small mb-2 mb-md-0">
                    Menampilkan <span class="fw-semibold">{{ $kategoribukus->firstItem() }} - {{ $kategoribukus->lastItem() }}</span> dari <span class="fw-semibold">{{ $kategoribukus->total() }}</span> kategori
                </div>
                <div class="pagination-container">
                    {{ $kategoribukus->withQueryString()->links() }}
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

    /* Search Form */
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

    .search-form .btn-search {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .search-form .btn-search:hover {
        background-color: var(--primary-hover);
    }

    /* Add Button */
    .btn-add {
        background-color: var(--primary-color);
        color: white;
        font-weight: 500;
        border-radius: 0.5rem;
        padding: 0.5rem 1.25rem;
        transition: all 0.3s ease;
        white-space: nowrap;
        border: none;
    }

    .btn-add:hover {
        background-color: var(--primary-hover);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
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

    .category-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid var(--border-color);
    }

    .category-row:hover {
        background-color: #f8fafc;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* Category Badge */
    .category-badge {
        width: 36px;
        height: 36px;
        background-color: rgba(79, 70, 229, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .category-name {
        color: var(--dark-color);
        transition: color 0.2s ease;
    }

    .category-row:hover .category-name {
        color: var(--primary-color);
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

    .btn-edit {
        background-color: rgba(var(--bs-warning-rgb), 0.1);
        color: var(--warning-color);
        border: none;
    }

    .btn-edit:hover {
        background-color: var(--warning-color);
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
        .search-form {
            width: 100%;
            margin-bottom: 1rem;
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

        .btn-add {
            padding: 0.5rem 0.75rem;
        }

        .btn-add span {
            display: none;
        }

        .btn-add i {
            margin-right: 0 !important;
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

    // Add animation to category rows on load
    const categoryRows = document.querySelectorAll('.category-row');
    categoryRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(10px)';
        row.style.transition = 'all 0.4s ease';
        
        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, 100 * index);
    });
});
</script>
@endsection