<?php

namespace App\Http\Controllers;

use App\Models\Koleksipribadi;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KoleksipribadiController extends Controller
{
    public function index()
    {
        $koleksipribadi = Koleksipribadi::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
            {
            if (Auth::user()->role === 'peminjam') {
                return view('peminjam.koleksi.tampil', compact('koleksipribadi'));
            }
        
            abort(403, 'Role tidak dikenali.');
        }
    }

    public function create()
    {
        $bukus = Buku::all();
        {
            if (Auth::user()->role === 'peminjam') {
                return view('peminjam.koleksi.tambah', compact('bukus'));
            }
        
            abort(403, 'Role tidak dikenali.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
        ]);

        DB::beginTransaction();
        try {
            $exists = Koleksipribadi::where('user_id', Auth::id())
                ->where('buku_id', $request->buku_id)
                ->exists();
                
            if ($exists) {
                return redirect()->back()->with('error', 'Buku ini sudah ada dalam koleksi anda.')->withInput();
            }
            
            $koleksipribadi = Koleksipribadi::create([
                'user_id' => Auth::id(),
                'buku_id' => $request->buku_id,
            ]);
            
            DB::commit();
            return redirect()->route('koleksipribadi.index')->with('success', 'Buku berhasil ditambahkan ke koleksi pribadi!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Koleksipribadi $koleksipribadi)
    {
        if (Auth::user()->role === 'peminjam') {
            if ($koleksipribadi->user_id !== Auth::id()) {
                return redirect()->route('peminjam.koleksi.show')->with('error', 'Anda tidak memiliki akses ke koleksi ini.');
            }
        
            $koleksipribadi->load('buku');
            return view('peminjam.koleksi.show', compact('koleksipribadi'));
        }
        
        abort(403, 'Role tidak dikenali.');
        }
        
    public function edit(Koleksipribadi $koleksipribadi)
    {
        if ($koleksipribadi->user_id !== Auth::id()) {
            return redirect()->route('koleksipribadi.index')->with('error', 'Anda tidak memiliki akses ke koleksi ini.');
        }

        $bukus = Buku::all();
        return view('koleksipribadi.edit', compact('koleksipribadi', 'bukus'));
    }

    public function update(Request $request, Koleksipribadi $koleksipribadi)
    {
        if ($koleksipribadi->user_id !== Auth::id()) {
            return redirect()->route('koleksipribadi.index')->with('error', 'Anda tidak memiliki akses ke koleksi ini.');
        }

        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
        ]);

        DB::beginTransaction();
        try {
            $exists = Koleksipribadi::where('user_id', Auth::id())
                ->where('buku_id', $request->buku_id)
                ->where('id', '!=', $koleksipribadi->id)
                ->exists();
                
            if ($exists) {
                return redirect()->back()->with('error', 'Buku ini sudah ada dalam koleksi anda.')->withInput();
            }
            
            $koleksipribadi->update([
                'buku_id' => $request->buku_id,
            ]);
            
            DB::commit();
            return redirect()->route('koleksipribadi.index')->with('success', 'Koleksi pribadi berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Koleksipribadi $koleksipribadi)
    {
        if ($koleksipribadi->user_id !== Auth::id()) {
            return redirect()->route('koleksipribadi.index')->with('error', 'Anda tidak memiliki akses ke koleksi ini.');
        }

        DB::beginTransaction();
        try {
            $koleksipribadi->delete();
            
            DB::commit();
            return redirect()->route('koleksipribadi.index')->with('success', 'Buku berhasil dihapus dari koleksi pribadi!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}