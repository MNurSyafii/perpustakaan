@extends('layout')

@section('perpus')
<div class="container mt-4 mt-lg-5">
    <div class="row">
        <!-- User Profile Card -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-body text-center p-4">
                    <div class="avatar-circle-lg mx-auto mb-3">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        <a href="{{ route('user.tampil') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                    <div class="border-top pt-3 mt-3">
                        <div class="row text-center">
                            <div class="col">
                                <h6 class="text-muted mb-1">
                                    <i class="fas fa-calendar-alt"></i>
                                </h6>
                                <small class="text-muted">Bergabung {{ $user->created_at->format('d F Y') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Details Card -->
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-header bg-primary text-white py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-user-circle me-2"></i> Informasi Anggota
                        </h5>
                        <span class="badge bg-white text-primary px-3 py-2">
                            ID: #{{ $user->id }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th width="200" class="border-0">
                                    <i class="fas fa-user me-2 text-primary"></i>
                                    Nama Lengkap
                                </th>
                                <td class="border-0">{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th class="border-0">
                                    <i class="fas fa-envelope me-2 text-primary"></i>
                                    Email
                                </th>
                                <td class="border-0">{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th class="border-0">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                    Alamat
                                </th>
                                <td class="border-0">{{ $user->alamat }}</td>
                            </tr>
                            <tr>
                                <th class="border-0">
                                    <i class="fas fa-calendar-check me-2 text-primary"></i>
                                    Tanggal Bergabung
                                </th>
                                <td class="border-0">{{ $user->created_at->format('d F Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Riwayat Peminjaman Card -->
            @if(isset($peminjaman) && count($peminjaman) > 0)
            <div class="card shadow-lg rounded-4 border-0 mt-4">
                <div class="card-header bg-primary text-white py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-history me-2"></i> Riwayat Peminjaman
                        </h5>
                        <span class="badge bg-white text-primary px-3 py-2">
                            Total: {{ count($peminjaman) }}
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>
                                        <i class="fas fa-book me-2 text-primary"></i>
                                        Judul Buku
                                    </th>
                                    <th>
                                        <i class="fas fa-calendar me-2 text-primary"></i>
                                        Tanggal Pinjam
                                    </th>
                                    <th>
                                        <i class="fas fa-calendar-check me-2 text-primary"></i>
                                        Tanggal Kembali
                                    </th>
                                    <th class="text-center">
                                        <i class="fas fa-info-circle me-2 text-primary"></i>
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjaman as $pinjam)
                                <tr>
                                    <td>{{ $pinjam->buku->judul }}</td>
                                    <td>{{ $pinjam->tanggal_peminjaman }}</td>
                                    <td>{{ $pinjam->tanggal_pengembalian ?? 'Belum dikembalikan' }}</td>
                                    <td class="text-center">
                                        @if($pinjam->status_peminjaman == 'dipinjam')
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-clock me-1"></i>
                                                Dipinjam
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>
                                                Dikembalikan
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.avatar-circle-lg {
    width: 100px;
    height: 100px;
    background-color: var(--bs-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: 600;
}

.table th {
    font-weight: 600;
    color: #4b5563;
}

.badge {
    padding: 0.5em 0.8em;
    font-weight: 500;
}

.card {
    box-shadow: 0 2px 4px rgba(0,0,0,0.04);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.08);
}

.btn-action {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.btn-action:hover {
    transform: translateY(-2px);
}
</style>
@endsection