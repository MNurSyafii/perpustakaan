@extends('layout')

@section('perpus')
<div class="container-fluid px-4 px-lg-5">
    <div class="d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between mb-4">
        <div class="d-flex flex-column">
        </div>
        <div class="d-flex gap-2">
            <form action="{{ route('peminjaman.index') }}" method="GET" class="search-form flex-grow-1">
                <div class="input-group input-group-merged shadow-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control form-control-sm border-start-0" 
                           placeholder="Cari Peminjaman..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-search d-none d-md-block">
                        Cari
                    </button>
                </div>
            </form>
            <a href="{{ route('peminjaman.create') }}" class="btn btn-add shadow-sm">
                <i class="fas fa-plus me-1"></i>Tambah Peminjaman
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
    </div>

    <!-- Loans Table Card -->
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header">
                        <tr>
                            <th class="ps-4" style="width: 20%">
                                <i class="fas fa-user me-2 text-primary"></i>Peminjam
                            </th>
                            <th style="width: 25%">
                                <i class="fas fa-book me-2 text-primary"></i>Buku
                            </th>
                            <th style="width: 15%">
                                <i class="fas fa-calendar-plus me-2 text-primary"></i>Pinjam
                            </th>
                            <th style="width: 15%">
                                <i class="fas fa-calendar-check me-2 text-primary"></i>Kembali
                            </th>
                            <th class="text-center" style="width: 15%">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Status
                            </th>
                            <th class="pe-4" style="width: 20%">
                                <i class="fas fa-cogs me-2 text-primary"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjaman as $item)
                            <tr class="loan-row">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar bg-primary text-white rounded-circle me-3">
                                            {{ strtoupper(substr($item->user->name ?? '-', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="user-name fw-semibold">{{ $item->user->name ?? '-' }}</div>
                                            <small class="text-muted">{{ $item->user->email ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->buku->cover ?? false)
                                            <img src="{{ asset('covers/' . $item->buku->cover) }}" 
                                                 alt="{{ $item->buku->judul }}" 
                                                 class="book-cover rounded-3 me-3 shadow-sm"
                                                 style="width: 48px; height: 64px; object-fit: cover;">
                                        @else
                                            <div class="book-cover-placeholder rounded-3 me-3 shadow-sm"
                                                 style="width: 48px; height: 64px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-book text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="book-title fw-semibold">{{ $item->buku->judul ?? '-' }}</div>
                                            <small class="text-muted">{{ $item->buku->penulis ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="loan-date">
                                        {{ $item->tanggal_peminjaman ? \Carbon\Carbon::parse($item->tanggal_peminjaman)->translatedFormat('d M Y') : '-' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="return-date">
                                        {{ $item->tanggal_pengembalian ? \Carbon\Carbon::parse($item->tanggal_pengembalian)->translatedFormat('d M Y') : '-' }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusClasses = [
                                            'Menunggu' => 'bg-info',
                                            'Disetujui' => 'bg-primary',
                                            'Ditolak' => 'bg-danger',
                                            'Dipinjam' => 'bg-warning',
                                            'Dikembalikan' => 'bg-success'
                                        ];
                                        
                                        $statusIcons = [
                                            'Menunggu' => 'fas fa-clock',
                                            'Disetujui' => 'fas fa-check',
                                            'Ditolak' => 'fas fa-times',
                                            'Dipinjam' => 'fas fa-hand-holding',
                                            'Dikembalikan' => 'fas fa-check-circle'
                                        ];
                                        
                                        $today = now();
                                        $due = $item->tanggal_pengembalian ? \Carbon\Carbon::parse($item->tanggal_pengembalian) : null;
                                        $isLate = $item->status_peminjaman === 'Dipinjam' && $due && $today->gt($due);
                                    @endphp

                                    @if($isLate)
                                        <span class="badge bg-danger bg-opacity-15 text-danger">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            Terlambat
                                        </span>
                                    @else
                                        <span class="badge {{ $statusClasses[$item->status_peminjaman] ?? 'bg-secondary' }} text-white">
                                        <i class="{{ $statusIcons[$item->status_peminjaman] ?? 'fas fa-question' }} me-1"></i>
                                        {{ $item->status_peminjaman }}
                                    </span>
                                    @endif
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex justify-content-start gap-2">
                                        @if($item->status_peminjaman === 'Menunggu')
                                            <form action="{{ route('peminjaman.acc', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-success btn-sm"
                                                        data-bs-toggle="tooltip"
                                                        title="Setujui Peminjaman">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('peminjaman.tolak', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-danger btn-sm"
                                                        data-bs-toggle="tooltip"
                                                        title="Tolak Peminjaman">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <a href="{{ route('peminjaman.show', $item->id) }}" 
                                           class="btn btn-info btn-sm" 
                                           data-bs-toggle="tooltip" 
                                           title="Detail Peminjaman">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <a href="{{ route('peminjaman.edit', $item->id) }}" 
                                           class="btn btn-warning btn-sm" 
                                           data-bs-toggle="tooltip" 
                                           title="Edit Peminjaman">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('peminjaman.destroy', $item->id) }}" 
                                              method="POST" 
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm delete-btn" 
                                                    data-bs-toggle="tooltip"
                                                    title="Hapus Peminjaman">
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
                                            <i class="fas fa-book-open text-primary opacity-25"></i>
                                        </div>
                                        <h3 class="empty-state-title">Tidak ada data peminjaman</h3>
                                        <p class="empty-state-text">Mulai dengan menambahkan peminjaman baru</p>
                                        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mt-3">
                                            <i class="fas fa-plus me-1"></i>Tambah Peminjaman
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
        @if($peminjaman->hasPages())
        <div class="card-footer bg-transparent border-top-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="text-muted small mb-2 mb-md-0">
                    Menampilkan <span class="fw-semibold">{{ $peminjaman->firstItem() }} - {{ $peminjaman->lastItem() }}</span> dari <span class="fw-semibold">{{ $peminjaman->total() }}</span> peminjaman
                </div>
                <div class="pagination-container">
                    {{ $peminjaman->links() }}
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

    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 0;
    }

    .breadcrumb-item.active {
        color: var(--text-muted);
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

    .loan-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid var(--border-color);
    }

    .loan-row:hover {
        background-color: #f8fafc;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* User Avatar */
    .user-avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }

    .user-name {
        color: var(--dark-color);
        transition: color 0.2s ease;
    }

    .loan-row:hover .user-name {
        color: var(--primary-color);
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
    }

    /* Loan Dates */
    .loan-date, .return-date {
        color: var(--dark-color);
    }

    /* Status Badges */
    .badge {
        font-weight: 500;
        padding: 0.35rem 0.65rem;
        font-size: 0.75rem;
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
        .d-flex.flex-md-row {
            flex-direction: column !important;
        }
        
        .btn-add {
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

        .empty-state {
            padding: 2rem 0;
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

    // Add animation to loan rows on load
    const loanRows = document.querySelectorAll('.loan-row');
    loanRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(10px)';
        row.style.transition = 'all 0.4s ease';
        
        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, 100 * index);
    });
});

function confirmDelete(button) {
    if (confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')) {
        button.closest('form').submit();
    }
}
</script>
@endsection