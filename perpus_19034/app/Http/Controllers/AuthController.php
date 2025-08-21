<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Peminjaman; 

class AuthController extends Controller
{
    public function search(Request $request)
{
    if (!Auth::check()) {
        abort(403, 'Unauthorized action.');
    }

    $keyword = $request->input('keyword');

    // Query dasar
    $query = User::query();

    // Admin: bisa lihat semua user kecuali dirinya sendiri
    if (Auth::user()->role === 'admin') {
        $query->where('id', '!=', Auth::id());
    }
    // Petugas: hanya bisa lihat peminjam
    elseif (Auth::user()->role === 'petugas') {
        $query->where('role', 'peminjam');
    } else {
        abort(403, 'Unauthorized action.');
    }

    // Tambahkan filter berdasarkan keyword
    $query->where(function ($q) use ($keyword) {
        $q->where('name', 'like', "%$keyword%")
          ->orWhere('email', 'like', "%$keyword%");
    });

    $users = $query->latest()->paginate(10);

    return view('admin.petugas.tampil', compact('users'))->with('keyword', $keyword);
    }


    public function index()
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized action.');
        }

        // Jika admin, tampilkan semua user kecuali dirinya
        if (Auth::user()->role === 'admin') {
            $users = User::where('id', '!=', Auth::id())->latest()->paginate(10);
        }
        // Jika petugas, tampilkan hanya user dengan role 'peminjam'
        elseif (Auth::user()->role === 'petugas') {
            $users = User::where('role', 'peminjam')->latest()->paginate(10);
        } else {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.petugas.tampil', compact('users'));
    }


    protected function redirectBasedOnRole(User $user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'petugas':
                return redirect()->route('petugas.dashboard');
            case 'peminjam':
                return redirect()->route('peminjam.dashboard');
            default:
                abort(403, 'Role tidak dikenali.');
        }
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'alamat' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $bcryptHashedPassword = password_hash($request->password, PASSWORD_BCRYPT, ['cost' => 12]);

        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'password' => $bcryptHashedPassword, 
            'role' => 'peminjam',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        Auth::login($user);
        return redirect()->route('peminjam.dashboard')->with('success', 'Registrasi berhasil!');
    }
    
    public function createUser()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.petugas.tambah');
    }
    
    public function storeUser(Request $request)
    {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    $validator = Validator::make($request->all(), [
        'nama_lengkap' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'alamat' => 'required|string',
        'role' => 'required|in:admin,petugas,peminjam', 
        'password' => 'required|string|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->withInput($request->except('password', 'password_confirmation'));
    }

    $bcryptHashedPassword = password_hash($request->password, PASSWORD_BCRYPT, ['cost' => 12]);

    User::create([
        'name' => $request->nama_lengkap,
        'email' => $request->email,
        'alamat' => $request->alamat,
        'password' => $bcryptHashedPassword,
        'role' => $request->role, 
        'email_verified_at' => now(),
        'remember_token' => Str::random(10),
    ]);

    return redirect()->route('user.tampil')->with('success', 'Anggota berhasil ditambahkan!');
}
    public function show($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        
        return view('admin.petugas.show', compact('user'));
       
    }

    public function edit($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        return view('admin.petugas.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);

        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
        ];

        if ($request->email != $user->email) {
            $rules['email'] = 'required|string|email|max:255|unique:users';
        } else {
            $rules['email'] = 'required|string|email|max:255';
        }

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $user->name = $request->nama_lengkap;
        $user->email = $request->email;
        $user->alamat = $request->alamat;

        if ($request->filled('password')) {
            $user->password = password_hash($request->password, PASSWORD_BCRYPT, ['cost' => 12]);
        }

        $user->save();

        return redirect()->route('user.tampil')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy($id)
    {
       if (!Auth::check() || Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    try {
        $user = User::findOrFail($id);
        
        $activePeminjaman = Peminjaman::where('user_id', $id)
                            ->where('status_peminjaman', 'dipinjam')
                            ->count();
        
        if ($activePeminjaman > 0) {
            return redirect()->route('user.tampil')
                    ->with('error', 'Anggota tidak dapat dihapus karena masih memiliki peminjaman aktif.');
        }

        $hasLoanHistory = Peminjaman::where('user_id', $id)->exists();
        
        if ($hasLoanHistory) {
            $user->deleted_at = now();
            $user->save();
        } else {
            $user->delete();
        }

        return redirect()->route('user.tampil')
                ->with('success', 'Anggota berhasil dihapus!');
    } catch (\Exception $e) {
        return redirect()->route('user.tampil')
                ->with('error', 'Gagal menghapus anggota. Silakan coba lagi.');
    }
    }
    public function showLoanHistory($id)
{
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    $user = User::findOrFail($id);
    $peminjaman = Peminjaman::where('user_id', $id)
                           ->with('buku')
                           ->latest()
                           ->get();

    return view('admin.petugas.loan_history', compact('user', 'peminjaman'));
}

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
    public function resetPassword($id)
{
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    try {
        $user = User::findOrFail($id);
        
        // Generate a default password
        $defaultPassword = 'password123';
        $user->password = Hash::make($defaultPassword);
        $user->save();

        return redirect()->route('user.tampil')
            ->with('success', "Password berhasil direset menjadi: $defaultPassword");
    } catch (\Exception $e) {
        return redirect()->route('user.tampil')
            ->with('error', 'Gagal mereset password. Silakan coba lagi.');
    }
}

}