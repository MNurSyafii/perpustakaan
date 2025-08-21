<?php

namespace App\Http\Controllers;

use App\Models\Kategoribuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KategoribukuController extends Controller
{
   public function index(Request $request)
{
    $query = Kategoribuku::withCount('bukus')->latest();

    if ($request->has('search') && $request->search !== null) {
        $query->where('nama_kategori', 'like', '%' . $request->search . '%');
    }

    $kategoribukus = $query->paginate(10);

    switch (Auth::user()->role) {
        case 'admin':
            return view('admin.kategori.tampil', compact('kategoribukus'));
        case 'petugas':
            return view('petugas.kategori.tampil', compact('kategoribukus'));
        case 'peminjam':
            return view('peminjam.kategori.tampil', compact('kategoribukus'));
        default:
            abort(403, 'Role tidak dikenali.');
    }
}


    public function create()
    {
        switch (Auth::user()->role) {
            case 'admin':
                return view('admin.kategori.tambah');
            case 'petugas':
                return view('petugas.kategori.tambah');
            default:
                abort(403, 'Role tidak dikenali.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoribukus,nama_kategori',
        ]);

        try {
            Kategoribuku::create([
                'nama_kategori' => $request->nama_kategori,
            ]);
            
            return redirect()->route('kategori.index')
                ->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Kategoribuku $kategoribuku)
    {
        $kategoribuku->load('bukus');

        switch (Auth::user()->role) {
            case 'admin':
                return view('admin.kategori.show', compact('kategoribuku'));
            case 'petugas':
                return view('petugas.kategori.show', compact('kategoribuku'));
            case 'peminjam':
                return view('peminjam.kategori.show', compact('kategoribuku'));
            default:
                abort(403, 'Role tidak dikenali.');
        }
    }

    public function edit(Kategoribuku $kategoribuku)
    {
        switch (Auth::user()->role) {
            case 'admin':
                return view('admin.kategori.edit', compact('kategoribuku'));
            case 'petugas':
                return view('petugas.kategori.edit', compact('kategoribuku'));
            default:
                abort(403, 'Role tidak dikenali.');
        }
    }

    public function update(Request $request, Kategoribuku $kategoribuku)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoribukus,nama_kategori,' . $kategoribuku->id,
        ]);

        try {
            $kategoribuku->update([
                'nama_kategori' => $request->nama_kategori,
            ]);
            
            return redirect()->route('kategori.index')
                ->with('success', 'Kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
    public function destroy(Kategoribuku $kategoribuku)
    {
        try {
            if ($kategoribuku->bukus()->count() > 0) {
                return redirect()->route('kategori.index')
                    ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki buku terkait.');
            }

            $kategoribuku->delete();

            return redirect()->route('kategori.index')
                ->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
