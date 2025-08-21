<?php

namespace App\Http\Controllers;

use App\Models\Ulasanbuku;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UlasanbukuController extends Controller
{
    public function searchUlasan(Request $request)
{
    $keyword = $request->input('keyword');

    $ulasan = \App\Models\Ulasanbuku::with(['user', 'buku'])
        ->where(function ($query) use ($keyword) {
            $query->where('ulasan', 'like', "%{$keyword}%")
                  ->orWhereHas('user', function ($q) use ($keyword) {
                      $q->where('name', 'like', "%{$keyword}%");
                  })
                  ->orWhereHas('buku', function ($q) use ($keyword) {
                      $q->where('judul', 'like', "%{$keyword}%");
                  });
        })
        ->latest()
        ->paginate(10);

    return view('admin.ulasan.index', compact('ulasan'))->with('keyword', $keyword);
}

    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $ulasans = Ulasanbuku::with(['buku', 'user'])
                        ->latest()
                        ->paginate(10);
            $totalUlasan = Ulasanbuku::count();
            return view('admin.ulasan.tampil', compact('ulasans', 'totalUlasan'));
            
        } elseif (Auth::user()->role === 'petugas') {

            $ulasans = Ulasanbuku::with(['buku', 'user'])
                        ->latest()
                        ->paginate(10);
            $totalUlasan = Ulasanbuku::count();
            return view('petugas.ulasan.tampil', compact('ulasans', 'totalUlasan'));
            
        } elseif (Auth::user()->role === 'peminjam') {
            $ulasans = Ulasanbuku::with('buku')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->paginate(10);
            $totalUlasan = Ulasanbuku::where('user_id', Auth::id())->count();
            return view('peminjam.ulasan.tampil', compact('ulasans', 'totalUlasan'));
        }
        
        abort(403, 'Role tidak dikenali.');
    }

    public function create()
    {
        $bukus = Buku::all();
        return view('peminjam.ulasan.tambah', compact('bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'ulasan' => 'required|string',
            'ranting' => 'required|integer|min:1|max:5',
        ]);

        DB::beginTransaction();
        try {
            Ulasanbuku::create([
                'user_id' => Auth::id(),
                'buku_id' => $request->buku_id,
                'ulasan' => $request->ulasan,
                'ranting' => $request->ranting,
            ]);

            DB::commit();
            return redirect()->route('ulasanbuku.index')->with('success', 'Ulasan berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan ulasan: '.$e->getMessage())->withInput();
        }
    }

    public function show(Ulasanbuku $ulasanbuku)
    {
        if ($ulasanbuku->user_id !== Auth::id()) {
            return redirect()->route('ulasanbuku.index')->with('error', 'Anda tidak punya akses.');
        }

        $ulasanbuku->load('buku');
        if (Auth::user()->role === 'admin') {
            return view('admin.ulasan.tampil', compact('ulasanbuku'));
        } elseif (Auth::user()->role === 'petugas') {
            return view('petugas.ulasan.tampil', compact('ulasanbuku'));
        } elseif (Auth::user()->role === 'peminjam') {
            return view('peminjam.ulasan.tampil', compact('ulasanbuku'));
        }
        abort(403, 'Role tidak dikenali.');    }

    public function edit(Ulasanbuku $ulasanbuku)
    {
        if ($ulasanbuku->user_id !== Auth::id()) {
            return redirect()->route('ulasanbuku.index')->with('error', 'Anda tidak punya akses.');
        }

        $bukus = Buku::all();
        return view('peminjam.ulasan.edit', compact('ulasanbuku', 'bukus'));
    }

    public function update(Request $request, Ulasanbuku $ulasanbuku)
    {
        if ($ulasanbuku->user_id !== Auth::id()) {
            return redirect()->route('ulasanbuku.index')->with('error', 'Anda tidak punya akses.');
        }

        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'ulasan' => 'required|string',
            'ranting' => 'required|integer|min:1|max:5',
        ]);

        DB::beginTransaction();
        try {
            $ulasanbuku->update([
                'buku_id' => $request->buku_id,
                'ulasan' => $request->ulasan,
                'ranting' => $request->ranting,
            ]);

            DB::commit();
            return redirect()->route('ulasanbuku.index')->with('success', 'Ulasan berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui ulasan: '.$e->getMessage())->withInput();
        }
    }

    public function destroy(Ulasanbuku $ulasanbuku)
    {
        if ($ulasanbuku->user_id !== Auth::id()) {
            return redirect()->route('ulasanbuku.index')->with('error', 'Anda tidak punya akses.');
        }

        DB::beginTransaction();
        try {
            $ulasanbuku->delete();
            DB::commit();
            return redirect()->route('ulasanbuku.index')->with('success', 'Ulasan berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus ulasan: '.$e->getMessage());
        }
    }
}