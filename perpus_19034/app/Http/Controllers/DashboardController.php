<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Ulasanbuku;
use App\Models\Koleksipribadi;
use App\Models\Kategoribuku;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('admin.dashboard');
        }

        if ($user->role === 'petugas') {
            return view('petugas.dashboard');
        }

        if ($user->role === 'peminjam') {
            $totalPinjaman = Peminjaman::where('user_id', $user->id)
                ->where('status_peminjaman', 'dipinjam')
                ->count();

            $totalKoleksi = Koleksipribadi::where('user_id', $user->id)->count();
            $totalUlasan = Ulasanbuku::where('user_id', $user->id)->count();
            $totalKategori = Kategoribuku::count();

            $popularKategori = Kategoribuku::withCount('bukus')
                ->orderBy('bukus_count', 'desc')
                ->take(4)
                ->get();

            $activePinjaman = Peminjaman::where('user_id', $user->id)
                ->where('status_peminjaman', 'dipinjam')
                ->with('buku')
                ->latest('tanggal_peminjaman')
                ->take(5)
                ->get();

            $lastKoleksi = Koleksipribadi::where('user_id', $user->id)
                ->with('buku')
                ->latest()
                ->take(4)
                ->get();

            $lastUlasan = Ulasanbuku::where('user_id', $user->id)
                ->with('buku')
                ->latest()
                ->take(3)
                ->get();

            $peminjamans = Peminjaman::where('user_id', $user->id)->get();

            return view('peminjam.dashboard', compact(
                'totalPinjaman',
                'totalKoleksi',
                'totalUlasan',
                'totalKategori',
                'popularKategori',
                'activePinjaman',
                'lastKoleksi',
                'lastUlasan',
                'peminjamans'
            ));
        }
        abort(403, 'Role tidak dikenali.');
    }
}
