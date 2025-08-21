<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Ulasanbuku;

use App\Models\Peminjaman;
use App\Models\Koleksipribadi;  // Add this for total koleksi

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
    View::composer('*', function ($view) {
        if (Auth::check()) {
            $user = Auth::user();

            $peminjamans = Peminjaman::where('user_id', $user->id)->get();
            $totalPinjaman = Peminjaman::where('user_id', $user->id)
                                       ->where('status_peminjaman', 'dipinjam')
                                       ->count();

            $totalKoleksi = Koleksipribadi::where('user_id', $user->id)->count();
            $totalUlasan = Ulasanbuku::where('user_id', $user->id)->count();

            $view->with([
                'peminjamans'    => $peminjamans,
                'totalPinjaman'  => $totalPinjaman,
                'totalKoleksi'   => $totalKoleksi,
                'totalUlasan'    => $totalUlasan
            ]);
        }
    });
}
}