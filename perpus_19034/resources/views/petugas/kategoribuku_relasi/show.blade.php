@extends('layout')

@section('perpus')
<div class="container mt-3 mt-md-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold mb-0">Detail Relasi Kategori Buku</h2>
        <a href="{{ route('kategoribuku_relasi.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Judul Buku:</label>
                <div>{{ $kategoribukuRelasi->buku?->judul ?? '-' }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Nama Kategori:</label>
                <div>{{ $kategoribukuRelasi->kategori?->nama_kategori ?? '-' }}</div>
            </div>

            <div class="mt-4">
                <a href="{{ route('kategoribuku_relasi.edit', $kategoribukuRelasi->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>

                <form action="{{ route('kategoribuku_relasi.destroy', $kategoribukuRelasi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus relasi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
