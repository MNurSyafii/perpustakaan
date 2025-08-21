@extends('layout')

@section('perpus')
<div class="container mt-3 mt-md-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold mb-0">Tambah Relasi Kategori Buku</h2>
        <a href="{{ route('kategoribuku_relasi.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Alert Error Validasi -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Form Tambah Relasi -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('kategoribuku_relasi.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="buku_id" class="form-label">Pilih Buku</label>
                    <select name="buku_id" id="buku_id" class="form-select" required>
                        <option value="">-- Pilih Buku --</option>
                        @foreach ($buku as $item)
                            <option value="{{ $item->id }}" {{ old('buku_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->judul }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Pilih Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Relasi
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
