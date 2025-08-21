<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategoribuku;
use App\Models\KategoribukuRelasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoribukuRelasiController extends Controller
{
    protected function viewPath($folder)
    {
        $role = Auth::user()->role;

        return match ($role) {
            'admin' => 'admin.kategoribuku_relasi.' . $folder,
            'petugas' => 'petugas.kategoribuku_relasi.' . $folder,
            'peminjam' => 'peminjam.kategoribuku_relasi.' . $folder,
            default => abort(403, 'Role tidak dikenali.'),
        };
    }

    public function index()
    {
        $kategoribukuRelasi = KategoribukuRelasi::with(['buku', 'kategori'])->paginate(15);
        return view($this->viewPath('tampil'), compact('kategoribukuRelasi'));
    }

    public function create()
    {
        $buku = Buku::all();
        $kategori = Kategoribuku::all();
        return view($this->viewPath('tambah'), compact('buku', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'kategori_id' => 'required|exists:kategoribukus,id',
        ]);

        $exists = KategoribukuRelasi::where('buku_id', $request->buku_id)
            ->where('kategori_id', $request->kategori_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Relasi kategori buku ini sudah ada')->withInput();
        }

        try {
            KategoribukuRelasi::create([
                'buku_id' => $request->buku_id,
                'kategori_id' => $request->kategori_id,
            ]);

            return redirect()->route('kategoribuku_relasi.index')
                ->with('success', 'Relasi kategori buku berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $kategoribukuRelasi = KategoribukuRelasi::with(['buku', 'kategori'])->findOrFail($id);
        return view($this->viewPath('show'), compact('kategoribukuRelasi'));
    }

    public function edit(KategoribukuRelasi $kategoribukuRelasi)
    {
        $buku = Buku::all();
        $kategori = Kategoribuku::all();
        return view($this->viewPath('edit'), compact('kategoribukuRelasi', 'buku', 'kategori'));
    }

    public function update(Request $request, KategoribukuRelasi $kategoribukuRelasi)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'kategori_id' => 'required|exists:kategoribukus,id',
        ]);

        $exists = KategoribukuRelasi::where('buku_id', $request->buku_id)
            ->where('kategori_id', $request->kategori_id)
            ->where('id', '!=', $kategoribukuRelasi->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Relasi kategori buku ini sudah ada')->withInput();
        }

        try {
            $kategoribukuRelasi->update([
                'buku_id' => $request->buku_id,
                'kategori_id' => $request->kategori_id,
            ]);

            return redirect()->route('kategoribuku_relasi.index')
                ->with('success', 'Relasi kategori buku berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(KategoribukuRelasi $kategoribukuRelasi)
    {
        try {
            $kategoribukuRelasi->delete();
            return redirect()->route('kategoribuku_relasi.index')
                ->with('success', 'Relasi kategori buku berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
