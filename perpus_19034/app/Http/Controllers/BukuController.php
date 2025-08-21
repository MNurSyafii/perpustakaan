<?php 

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Support\Facades\Auth;
use App\Models\Kategoribuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function index(Request $request)
{
    $kategoribukus = Kategoribuku::all();

    
    $search = $request->input('search');

    
    $query = Buku::with('kategoribukus');

   
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('judul', 'like', '%' . $search . '%')
              ->orWhere('penulis', 'like', '%' . $search . '%');
        });
    }

    
    $buku = $query->latest()->paginate(10);

    // Tampilkan view sesuai role
    if (Auth::user()->role === 'admin') {
        return view('admin.buku.tampil', compact('buku', 'kategoribukus'));
    } elseif (Auth::user()->role === 'petugas') {
        return view('petugas.buku.tampil', compact('buku', 'kategoribukus'));
    } elseif (Auth::user()->role === 'peminjam') {
        return view('peminjam.buku.tampil', compact('buku', 'kategoribukus'));
    }

    abort(403, 'Role tidak dikenali.');
}


    public function create()
    {
        $kategori = Kategoribuku::all();

        if (Auth::user()->role === 'admin') {
            return view('admin.buku.tambah', compact('kategori'));
        } elseif (Auth::user()->role === 'petugas') {
            return view('petugas.buku.tambah', compact('kategori'));
        }

        abort(403, 'Role tidak dikenali.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric|min:1900|max:' . date('Y'),
            'kategori' => 'required|array',
            'kategori.*' => 'exists:kategoribukus,id',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        DB::beginTransaction();
        try {
            $buku = new Buku();
            $buku->judul = $request->judul;
            $buku->penulis = $request->penulis;
            $buku->penerbit = $request->penerbit;
            $buku->tahun_terbit = $request->tahun_terbit;

            if ($request->hasFile('cover')) {
                $coverName = time() . '_' . $request->cover->getClientOriginalName();
                $request->cover->move(public_path('covers'), $coverName);
                $buku->cover = $coverName;
            }

            $buku->save();
            $buku->kategoribukus()->attach($request->kategori);

            DB::commit();
            return redirect()->route('buku.index')->with('success', 'Data buku berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Buku $buku)
    {
        $buku->load(['kategoribukus', 'ulasanbukus.user']);

        if (Auth::user()->role === 'admin') {
            return view('admin.buku.show', compact('buku'));
        } elseif (Auth::user()->role === 'petugas') {
            return view('petugas.buku.show', compact('buku'));
        }
        elseif (Auth::user()->role === 'peminjam') {
            return view('peminjam.buku.show', compact('buku'));
        }

        abort(403, 'Role tidak dikenali.');
    }

    public function edit(Buku $buku)
    {
        $kategori = Kategoribuku::all();
        $buku->load('kategoribukus');

        if (Auth::user()->role === 'admin') {
            return view('admin.buku.edit', compact('buku', 'kategori'));
        } elseif (Auth::user()->role === 'petugas') {
            return view('petugas.buku.edit', compact('buku', 'kategori'));
        }

        abort(403, 'Role tidak dikenali.');
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric|min:1900|max:' . date('Y'),
            'kategori' => 'required|array',
            'kategori.*' => 'exists:kategoribukus,id',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        DB::beginTransaction();
        try {
            $buku->update([
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'penerbit' => $request->penerbit,
                'tahun_terbit' => $request->tahun_terbit,
            ]);

            if ($request->hasFile('cover')) {
                if ($buku->cover && file_exists(public_path('covers/' . $buku->cover))) {
                    unlink(public_path('covers/' . $buku->cover));
                }

                $coverName = time() . '_' . $request->cover->getClientOriginalName();
                $request->cover->move(public_path('covers'), $coverName);
                $buku->cover = $coverName;
                $buku->save();
            }

            $buku->kategoribukus()->sync($request->kategori);

            DB::commit();
            return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Buku $buku)
    {
        DB::beginTransaction();
        try {
            if ($buku->peminjamans()->whereIn('status_peminjaman', ['dipinjam', 'terlambat'])->exists()) {
                return redirect()->route('buku.index')->with('error', 'Buku tidak dapat dihapus karena sedang dipinjam!');
            }

            if ($buku->cover && file_exists(public_path('covers/' . $buku->cover))) {
                unlink(public_path('covers/' . $buku->cover));
            }

            $buku->kategoribukus()->detach();
            $buku->delete();

            DB::commit();
            return redirect()->route('buku.index')->with('success', 'Data buku berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
