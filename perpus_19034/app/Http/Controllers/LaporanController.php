<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            return view('admin.laporan.tampil');
        } elseif (Auth::user()->role === 'petugas') {
            return view('petugas.laporan.tampil');
        }

        abort(403, 'Role tidak dikenali.');
    }

    public function bukuIndex()
    {
        $penerbit = Buku::select('penerbit')->distinct()->pluck('penerbit');
        $tahun = Buku::select('tahun_terbit')->distinct()->orderBy('tahun_terbit', 'desc')->pluck('tahun_terbit');
        
        if (Auth::user()->role === 'admin') {
            return view('admin.laporan.buku', compact('penerbit', 'tahun'));
        } elseif (Auth::user()->role === 'petugas') {
            return view('petugas.laporan.buku', compact('penerbit', 'tahun'));
        }

        abort(403, 'Role tidak dikenali.');
    }

    public function peminjamanIndex()
    {
        $users = User::where('role', 'peminjam')->get();
        $status = ['dipinjam', 'dikembalikan', 'terlambat'];
        
        if (Auth::user()->role === 'admin') {
            return view('admin.laporan.peminjaman', compact('users', 'status'));
        } elseif (Auth::user()->role === 'petugas') {
            return view('petugas.laporan.peminjaman', compact('users', 'status'));
        }

        abort(403, 'Role tidak dikenali.');
    }

    public function generateBukuPDF(Request $request)
    {
        $request->validate([
            'penerbit' => 'nullable|string',
            'tahun_terbit' => 'nullable|numeric',
            'sort_by' => 'required|in:judul,penulis,penerbit,tahun_terbit',
            'sort_order' => 'required|in:asc,desc',
        ]);

        $query = Buku::with('kategoribukus');

        if ($request->filled('penerbit')) {
            $query->where('penerbit', $request->penerbit);
        }

        if ($request->filled('tahun_terbit')) {
            $query->where('tahun_terbit', $request->tahun_terbit);
        }

        $query->orderBy($request->sort_by, $request->sort_order);

        $buku = $query->get();

        $data = [
            'buku' => $buku,
            'tanggal' => Carbon::now()->locale('id')->isoFormat('LL'),
            'filter' => [
                'penerbit' => $request->penerbit ?: 'Semua',
                'tahun_terbit' => $request->tahun_terbit ?: 'Semua',
                'sort_by' => $request->sort_by,
                'sort_order' => $request->sort_order == 'asc' ? 'Menaik' : 'Menurun',
            ],
            'jumlah' => $buku->count(),
        ];

        $pdf = PDF::loadView('admin.laporan.laporan-buku', $data);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->stream('laporan-buku-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    public function generatePeminjamanPDF(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'status_peminjaman' => 'nullable|in:dipinjam,dikembalikan,terlambat',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'sort_by' => 'required|in:tanggal_peminjaman,tanggal_pengembalian,status_peminjaman',
            'sort_order' => 'required|in:asc,desc',
        ]);

        $query = Peminjaman::with(['user', 'buku']);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('status_peminjaman')) {
            $query->where('status_peminjaman', $request->status_peminjaman);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_peminjaman', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_peminjaman', '<=', $request->tanggal_selesai);
        }

        $query->orderBy($request->sort_by, $request->sort_order);

        $peminjaman = $query->get();

        foreach ($peminjaman as $pinjam) {
            if ($pinjam->status_peminjaman == 'dipinjam' && Carbon::now()->gt(Carbon::parse($pinjam->tanggal_pengembalian))) {
                $pinjam->status_peminjaman = 'terlambat';
            }
        }

        $data = [
            'peminjaman' => $peminjaman,
            'tanggal' => Carbon::now()->locale('id')->isoFormat('LL'),
            'filter' => [
            'user' => $request->filled('user_id') ? User::find($request->user_id)->name : 'Semua',
            'status' => $request->status_peminjaman ?: 'Semua',
            'tanggal_mulai' => $request->tanggal_mulai ?: null,
            'tanggal_selesai' => $request->tanggal_selesai ?: null,
            'sort_by' => $request->sort_by,
            'sort_order' => $request->sort_order == 'asc' ? 'Menaik' : 'Menurun',
        ],

            'jumlah' => $peminjaman->count(),
        ];

        $pdf = PDF::loadView('admin.laporan.laporan-peminjaman', $data);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->stream('laporan-peminjaman-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }
}