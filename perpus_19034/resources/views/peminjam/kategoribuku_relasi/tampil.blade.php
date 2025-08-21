{{-- resources/views/peminjam/kategori_relasi/tampil.blade.php --}}

@extends('layout') {{-- ganti 'layouts.app' sesuai layout utama project kamu --}}

@section('perpus')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Relasi Kategori Buku</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-800 p-3 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2">Judul Buku</th>
                    <th class="border p-2">Kategori</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategoribukuRelasi as $relasi)
                    <tr class="hover:bg-gray-100">
                        <td class="border p-2">{{ $relasi->buku->judul ?? '-' }}</td>
                        <td class="border p-2">{{ $relasi->kategori->nama ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="border p-2 text-center">Tidak ada data relasi kategori buku.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $kategoribukuRelasi->links() }}
    </div>
</div>
@endsection
