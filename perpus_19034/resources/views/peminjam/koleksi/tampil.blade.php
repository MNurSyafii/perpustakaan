<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Pribadi - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        /* Fix untuk scroll smooth */
        html {
            scroll-behavior: smooth;
        }

        /* Pastikan main content area dimulai dari posisi yang tepat */
        .main-content {
            min-height: calc(100vh - 4rem);
            margin-top: 0;
            padding-top: 2rem;
        }

    </style>
</head>
<body>
     <!-- Navbar -->
    <nav class="fixed top-0 w-full bg-white backdrop-blur-md bg-opacity-80 z-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-blue-600">
                        <i class="fas fa-book-reader mr-2"></i>
                        Perpustakaan Digital
                    </span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Current Date Time -->
                    <div class="hidden md:flex items-center text-gray-600 text-sm">
                        <i class="far fa-clock mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
                    </div>

                    <!-- User Info -->
                    <div class="flex items-center space-x-3">
                        <div class="text-right mr-2">
                            <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Peminjam</p>
                        </div>
                        <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                <i class="fas fa-sign-out-alt mr-1"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen pt-16">
        <!-- Sidebar -->
        <aside class="fixed left-0 top-16 h-screen w-64 bg-white border-r border-gray-200">
            <div class="p-4">
                <div class="flex flex-col items-center p-4 mb-6 bg-blue-50 rounded-lg">
                    <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-center text-white text-xl font-bold mb-2">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <h3 class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</h3>
                    <p class="text-xs text-gray-500">Member sejak {{ Auth::user()->created_at->format('M Y') }}</p>
                </div>

                <!-- Navigation -->
                <nav class="space-y-1">
                    <a href="{{ route('peminjam.dashboard') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-home mr-3"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('buku.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-book mr-3"></i>
                        <span>Katalog Buku</span>
                    </a>

                    <a href="{{ route('koleksipribadi.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-blue-50 text-blue-700">
                        <i class="fas fa-bookmark mr-3"></i>
                        <span>Koleksi Pribadi</span>
                        <span class="ml-auto bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                            {{ $koleksipribadi->total() }}
                        </span>
                    </a>

                    <a href="{{ route('peminjaman.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-clock mr-3"></i>
                        <span>Peminjaman</span>
                    </a>

                    <a href="{{ route('ulasanbuku.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-star mr-3"></i>
                        <span>Ulasan</span>
                    </a>
                </nav>



                    </div>
                </div>
            </div>
        </aside>

       <!-- Main Content Area -->
<main class="ml-64 flex-1 p-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Koleksi Pribadi</h1>
                <p class="text-gray-600 mt-2">
                    <i class="far fa-calendar-alt mr-2"></i>
                    {{ Carbon\Carbon::parse('2025-05-17')->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Info Box -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white mb-8">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-lightbulb text-yellow-300 text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium">Tentang Koleksi Pribadi</h3>
                <p class="mt-1 text-blue-100">
                    Koleksi pribadi memungkinkan Anda menyimpan daftar buku favorit untuk akses cepat. 
                    Tambahkan buku ke koleksi dan akses kapan saja!
                </p>
            </div>
        </div>
    </div>

    <!-- Collection Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Collection List -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Daftar Koleksi</h2>
                    <div class="flex space-x-2">
                        <button class="p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                            <i class="fas fa-sort-amount-down"></i>
                        </button>
                        <button class="p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>
                </div>

                <!-- Collection Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($koleksipribadi as $koleksi)
                        <div class="bg-white rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                            <div class="p-4">
                                <div class="flex space-x-4">
                                    <!-- Book Cover -->
                                    <div class="w-1/3 min-w-[100px]">
                                        <div class="aspect-[3/4] rounded-lg overflow-hidden bg-gray-100">
                                            @if($koleksi->buku && $koleksi->buku->cover)
                                                <img src="{{ asset('covers/' . $koleksi->buku->cover) }}" 
                                                     alt="{{ $koleksi->buku->judul }}"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <i class="fas fa-book-open text-3xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Book Info -->
                                    <div class="w-2/3">
                                        <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $koleksi->buku->judul }}</h3>
                                        <div class="space-y-1">
                                            <p class="text-sm text-gray-600 truncate">
                                                <i class="fas fa-user mr-2"></i>
                                                {{ $koleksi->buku->penulis }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                <i class="fas fa-calendar mr-2"></i>
                                                {{ $koleksi->buku->tahun_terbit }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="grid grid-cols-3 gap-2 mt-4">
                                    <a href="{{ route('koleksipribadi.show', $koleksi->id) }}" 
                                       class="flex items-center justify-center px-2 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 text-sm">
                                        <i class="fas fa-eye mr-1"></i>
                                        Detail
                                    </a>
                                    <a href="{{ route('peminjaman.create', ['buku_id' => $koleksi->buku_id]) }}" 
                                       class="flex items-center justify-center px-2 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 text-sm">
                                        <i class="fas fa-book mr-1"></i>
                                        Booking
                                    </a>
                                    <form action="{{ route('koleksipribadi.destroy', $koleksi->id) }}" 
                                          method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini dari koleksi?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full flex items-center justify-center px-2 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 text-sm">
                                            <i class="fas fa-trash mr-1"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <i class="fas fa-book text-gray-400 text-4xl mb-4"></i>
                            <h4 class="text-xl font-bold text-gray-800 mb-2">Koleksi Masih Kosong</h4>
                            <p class="text-gray-600 mb-6">Tambahkan buku favorit Anda ke koleksi pribadi</p>
                            <a href="{{ route('koleksipribadi.create') }}" 
                               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Buku ke Koleksi
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($koleksipribadi->hasPages())
                    <div class="mt-6">
                        {{ $koleksipribadi->links() }}
                    </div>
                @endif
            </div>
        </div>

        

    <script>
        // Update time
        function updateTime() {
            const now = new Date();
            const timeString = now.toISOString().slice(0, 19).replace('T', ' ');
            document.getElementById('current-time').textContent = timeString;
        }

        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>