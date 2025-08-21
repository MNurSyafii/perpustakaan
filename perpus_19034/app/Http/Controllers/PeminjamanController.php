<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Buku;


class PeminjamanController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $search = $request->search;

    // Query dasar
    $query = Peminjaman::with('user', 'buku')->latest();

    if ($user->role === 'admin' || $user->role === 'petugas') {
        // Filter jika ada pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search . '%');
                })->orWhereHas('buku', function ($q2) use ($search) {
                    $q2->where('judul', 'like', '%' . $search . '%');
                });
            });
        }

        $peminjaman = $query->paginate(10);
        $view = $user->role === 'admin' ? 'admin.peminjaman.tampil' : 'petugas.peminjaman.tampil';
        return view($view, compact('peminjaman'));

    } elseif ($user->role === 'peminjam') {
        // Filter untuk peminjam (hanya pinjaman miliknya)
        if ($search) {
            $query->where('user_id', $user->id)
                  ->whereHas('buku', function ($q) use ($search) {
                      $q->where('judul', 'like', '%' . $search . '%');
                  });
        } else {
            $query->where('user_id', $user->id);
        }

        $peminjaman = $query->paginate(10);
        return view('peminjam.peminjaman.tampil', compact('peminjaman'));
    }

    abort(403, 'Role tidak dikenali.');
}

   public function create()
    {
        $users = User::where('role', 'peminjam')->get();
        $buku = Buku::all();

        if (Auth::user()->role === 'admin') {
            return view('admin.peminjaman.tambah', compact('users', 'buku'));
        } elseif (Auth::user()->role === 'petugas') {
            return view('petugas.peminjaman.tambah', compact('users', 'buku'));
        } elseif (Auth::user()->role === 'peminjam') {
            return view('peminjam.peminjaman.tambah', compact('users', 'buku'));
        }

        abort(403, 'Role tidak dikenali.');
    }


   public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id', // Pastikan user_id dari form valid
        'buku_id' => 'required|exists:bukus,id',
    ]);

    Peminjaman::create([
        'user_id' => $request->user_id,  // Ambil user dari form
        'buku_id' => $request->buku_id,
        'status_peminjaman' => 'Menunggu',
        'tanggal_peminjaman' => null,
        'tanggal_pengembalian' => null,
    ]);

    return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan.');
}


    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $users = User::all();
        $bukus = Buku::all();
        if (Auth::user()->role === 'admin') {
            return view('admin.peminjaman.edit', compact('peminjaman', 'users', 'bukus'));
        } elseif (Auth::user()->role === 'petugas') {
            return view('petugas.peminjaman.edit', compact('peminjaman', 'users', 'bukus'));
        }

        abort(403, 'Role tidak dikenali.');
    }
    public function show($id)
{
    $peminjaman = Peminjaman::with('user', 'buku')->findOrFail($id);

    if (Auth::user()->role === 'admin') {
        return view('admin.peminjaman.show', compact('peminjaman'));
    } elseif (Auth::user()->role === 'petugas') {
        return view('petugas.peminjaman.show', compact('peminjaman'));
    } elseif (Auth::user()->role === 'peminjam') {
        return view('peminjam.peminjaman.show', compact('peminjaman'));
    }

    abort(403, 'Role tidak dikenali.');
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman',
            'status_peminjaman' => 'required|in:Menunggu,Disetujui,Ditolak,Dipinjam,Dikembalikan',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'user_id' => $request->user_id,
            'buku_id' => $request->buku_id,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'status_peminjaman' => $request->status_peminjaman,
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diupdate.');
    }

    public function destroy($id)
{
    $peminjaman = Peminjaman::findOrFail($id);

    if (in_array($peminjaman->status_peminjaman, ['Disetujui', 'Dipinjam'])) {
        return redirect()->route('peminjaman.index')
            ->with('error', 'Peminjaman dengan status Disetujui atau Dipinjam tidak bisa dihapus.');
    }

    $peminjaman->delete();

    return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus.');
}


public function tolak($id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    $peminjaman->update([
        'status_peminjaman' => 'Ditolak',
    ]);

    return redirect()->back()->with('error', 'Peminjaman ditolak.');
}
public function acc($id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    
    $peminjaman->update([
        'status_peminjaman' => 'Disetujui',
        'tanggal_peminjaman' => Carbon::now(),  // tanggal mulai pinjam saat disetujui
        'tanggal_pengembalian' => Carbon::now()->addDays(7), // misalnya durasi pinjam 7 hari
    ]);

    return redirect()->back()->with('success', 'Peminjaman disetujui.');
}


}

