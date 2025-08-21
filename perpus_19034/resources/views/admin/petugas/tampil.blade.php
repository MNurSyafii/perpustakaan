@extends('layout')

@section('perpus')
<div class="container-fluid px-4 px-lg-5">
    <div class="d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between mb-4">
        <div class="d-flex flex-column">
            <h1 class="page-title mb-0">
                <i class=""></i> 
            </h1>
        </div>
        <div class="d-flex gap-2">
            <div class="search-form flex-grow-1">
                <div class="input-group input-group-merged shadow-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control form-control-sm border-start-0" 
                           placeholder="Cari anggota...">
                </div>
            </div>
            <a href="{{ route('user.create') }}" class="btn btn-add shadow-sm">
                <i class="fas fa-plus me-1"></i>Tambah Anggota
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

    <!-- Members Table Card -->
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="membersTable">
                    <thead class="table-header">
                        <tr>
    <th class="ps-4" style="width: 20%">
        <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap
    </th>
    <th style="width: 20%">
        <i class="fas fa-envelope me-2 text-primary"></i>Email
    </th>
    <th style="width: 15%">
        <i class="fas fa-user-tag me-2 text-primary"></i>Role <!-- Kolom baru -->
    </th>
    <th style="width: 15%">
        <i class="fas fa-map-marker-alt me-2 text-primary"></i>Alamat
    </th>
    <th class="text-center" style="width: 10%">
        <i class="fas fa-book me-2 text-primary"></i>Status
    </th>
    <th class="pe-4" style="width: 20%">
        <i class="fas fa-cogs me-2 text-primary"></i>Aksi
    </th>
</tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            @php
                                $activePeminjaman = App\Models\Peminjaman::where('user_id', $user->id)
                                    ->where('status_peminjaman', 'dipinjam')
                                    ->count();
                            @endphp
                            <tr class="member-row">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar bg-primary text-white rounded-circle me-3">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="user-name fw-semibold">{{ $user->name }}</div>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                Bergabung {{ $user->created_at->format('d M Y') }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $user->email }}</span>
                                </td>
                                <td>
    @switch($user->role)
        @case('admin')
            <span class="badge bg-danger bg-opacity-15 text-white">
                <i class=""></i>Admin
            </span>
            @break
        @case('petugas')
            <span class="badge bg-primary bg-opacity-15 text-white">
                <i class=""></i>Petugas
            </span>
            @break
        @default
            <span class="badge bg-success bg-opacity-15 text-white">
                <i class=""></i>Peminjam
            </span>
    @endswitch
</td>
                                <td>
                                    @if($user->alamat)
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $user->alamat }}">
                                            {{ $user->alamat }}
                                        </span>
                                    @else
                                        <span class="text-muted fst-italic">Belum diisi</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($activePeminjaman > 0)
                                        <span class="badge bg-warning bg-opacity-15 text-white">
                                            <i class=""></i>
                                            Sedang Meminjam
                                        </span>
                                    @else
                                        <span class="badge bg-success bg-opacity-15 text-white">
                                            <i class=""></i>
                                            Tidak Meminjam
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex justify-content-start gap-2">
                                        <a href="{{ route('user.show', $user->id) }}" 
                                           class="btn btn-action btn-view" 
                                           data-bs-toggle="tooltip" 
                                           title="Detail Anggota">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('user.edit', $user->id) }}" 
                                           class="btn btn-action btn-edit" 
                                           data-bs-toggle="tooltip" 
                                           title="Edit Anggota">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('user.reset-password', $user->id) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-action btn-reset"
                                                    onclick="return confirm('Reset password anggota ini ke default (password123)?')"
                                                    data-bs-toggle="tooltip"
                                                    title="Reset Password">
                                                <i class="fas fa-key"></i>
                                            </button>
                                        </form>
                                        @if($activePeminjaman == 0)
                                            <form action="{{ route('user.destroy', $user->id) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-action btn-delete" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')"
                                                        data-bs-toggle="tooltip"
                                                        title="Hapus Anggota">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" 
                                                    class="btn btn-action btn-disabled" 
                                                    disabled
                                                    data-bs-toggle="tooltip"
                                                    title="Tidak dapat dihapus karena masih meminjam buku">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-users text-primary opacity-25"></i>
                                        </div>
                                        <h3 class="empty-state-title">Tidak ada data anggota</h3>
                                        <p class="empty-state-text">Mulai dengan menambahkan anggota baru ke sistem Anda</p>
                                        <a href="{{ route('user.create') }}" class="btn btn-primary mt-3">
                                            <i class="fas fa-plus me-1"></i>Tambah Anggota Pertama
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
        @if($users->hasPages())
        <div class="card-footer bg-transparent border-top-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="text-muted small mb-2 mb-md-0">
                    Menampilkan <span class="fw-semibold">{{ $users->firstItem() }} - {{ $users->lastItem() }}</span> dari <span class="fw-semibold">{{ $users->total() }}</span> anggota
                </div>
                <div class="pagination-container">
                    {{ $users->links() }}
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

    .member-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid var(--border-color);
    }

    .member-row:hover {
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

    .member-row:hover .user-name {
        color: var(--primary-color);
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

    .btn-reset {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--primary-color);
        border: none;
    }

    .btn-reset:hover {
        background-color: var(--primary-color);
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

    .btn-disabled {
        background-color: rgba(var(--bs-secondary-rgb), 0.1);
        color: var(--text-muted);
        border: none;
        cursor: not-allowed;
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
        
        .search-form, .btn-add {
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

    // Add animation to member rows on load
    const memberRows = document.querySelectorAll('.member-row');
    memberRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(10px)';
        row.style.transition = 'all 0.4s ease';
        
        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, 100 * index);
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let searchQuery = this.value.toLowerCase();
        let table = document.getElementById('membersTable');
        let rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            let found = false;
            let cells = rows[i].getElementsByTagName('td');
            
            for (let j = 0; j < cells.length; j++) {
                let cellText = cells[j].textContent || cells[j].innerText;
                
                if (cellText.toLowerCase().indexOf(searchQuery) > -1) {
                    found = true;
                    break;
                }
            }
            
            rows[i].style.display = found ? '' : 'none';
        }
    });
});
</script>
@endsection