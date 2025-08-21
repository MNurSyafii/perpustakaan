@extends('layout')

@section('perpus')
<div class="container mt-3 mt-md-4">
    <!-- Header + Search -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
        <h2 class="fw-bold mb-0">Relasi Kategori Buku</h2>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('kategoribuku_relasi.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Relasi
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th class="text-center" style="width: 5%">No</th>
                    <th style="width: 30%">Buku</th>
                    <th style="width: 30%">Kategori</th>
                    <th class="text-center" style="width: 20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategoribukuRelasi as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration + ($kategoribukuRelasi->currentPage() - 1) * $kategoribukuRelasi->perPage() }}</td>
                    <td>{{ $item->buku->judul }}</td>
                    <td>{{ $item->kategori->nama_kategori }}</td>
                    <td class="text-center">
                        <div class="d-flex flex-nowrap justify-content-center gap-1">
                            <a href="{{ route('kategoribuku_relasi.show', $item->id) }}" class="btn btn-info btn-sm py-1 px-2">
                                <i class="fas fa-eye"></i> Lihat
                            </a>

                            <a href="{{ route('kategoribuku_relasi.edit', $item->id) }}" class="btn btn-warning btn-sm py-1 px-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <form action="{{ route('kategoribuku_relasi.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus relasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm py-1 px-2">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data relasi kategori buku.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $kategoribukuRelasi->withQueryString()->links() }}
    </div>
</div>
@endsection
