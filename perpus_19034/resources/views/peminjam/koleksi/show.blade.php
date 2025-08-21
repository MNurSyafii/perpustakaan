<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Koleksi - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }

        .book-cover {
            transition: transform 0.3s ease;
        }

        .book-cover:hover {
            transform: scale(1.05) rotate(2deg);
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 
                       0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .hover-scale {
            transition: all 0.3s ease;
        }

        .hover-scale:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-gray-50">
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
                        <span id="current-time">{{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
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

                
        </aside>

        <!-- Main Content -->
        <main class="ml-64 flex-1 p-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('koleksipribadi.index') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Koleksi
                </a>
            </div>

            <!-- Book Details Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden fade-in">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Book Cover -->
                        <div class="col-span-1">
                            <div class="relative aspect-[3/4] rounded-lg overflow-hidden book-cover">
                                @if($koleksipribadi->buku->cover)
                                    <img src="{{ asset('covers/' . $koleksipribadi->buku->cover) }}" 
                                         alt="{{ $koleksipribadi->buku->judul }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <i class="fas fa-book text-5xl text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Book Info -->
                        <div class="col-span-2 space-y-6">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $koleksipribadi->buku->judul }}</h1>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach($koleksipribadi->buku->kategoribukus as $kategori)
                                        <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                                            {{ $kategori->nama_kategori }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-gray-600 text-sm mb-1">Penulis</p>
                                    <p class="font-semibold">{{ $koleksipribadi->buku->penulis }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-sm mb-1">Penerbit</p>
                                    <p class="font-semibold">{{ $koleksipribadi->buku->penerbit }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-sm mb-1">Tahun Terbit</p>
                                    <p class="font-semibold">{{ $koleksipribadi->buku->tahun_terbit }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-sm mb-1">Ditambahkan pada</p>
                                    <p class="font-semibold">
                                        @if(is_string($koleksipribadi->created_at))
                                            {{ $koleksipribadi->created_at }}
                                        @else
                                            {{ $koleksipribadi->created_at->format('d F Y') }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-4 mt-8">
                                <a href="{{ route('peminjaman.create', ['buku_id' => $koleksipribadi->buku_id]) }}" 
                                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-3 px-4 rounded-lg transition duration-200">
                                    <i class="fas fa-book-reader mr-2"></i>
                                    Pinjam Buku
                                </a>
                                <form action="{{ route('koleksipribadi.destroy', $koleksipribadi->id) }}" 
                                      method="POST" 
                                      class="flex-1"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini dari koleksi?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-lg transition duration-200">
                                        <i class="fas fa-trash mr-2"></i>
                                        Hapus dari Koleksi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info Grid -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Book Status Card -->
                <div class="bg-white rounded-lg shadow-sm p-6 hover-scale">
                    <h2 class="text-lg font-semibold mb-4">Info Koleksi</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Dalam Koleksi Sejak</span>
                            <span class="font-semibold">
                                @if(is_string($koleksipribadi->created_at))
                                    {{ $koleksipribadi->created_at }}
                                @else
                                    {{ $koleksipribadi->created_at->diffForHumans() }}
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Kategori</span>
                            <span class="font-semibold">
                                @if($koleksipribadi->buku->kategoribukus->count() > 0)
                                    {{ $koleksipribadi->buku->kategoribukus->first()->nama_kategori }}
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            
                        </div>
                    </div>
                </div>

                <!-- Reading History Card -->
                <div class="bg-white rounded-lg shadow-sm p-6 hover-scale">
                    <h2 class="text-lg font-semibold mb-4">Riwayat Peminjaman</h2>
                    @php
                        $peminjamans = Auth::user()->peminjamans()
                            ->where('buku_id', $koleksipribadi->buku_id)
                            ->latest()
                            ->get();
                    @endphp

                    @if($peminjamans->count() > 0)
                        <div class="space-y-4">
                            @foreach($peminjamans as $peminjaman)
                                <div class="flex justify-between items-center p-3 rounded-lg {{ $loop->first ? 'bg-blue-50' : 'hover:bg-gray-50' }}">
                                    <div>
                                        <p class="text-sm text-gray-600">
                                            @if(is_string($peminjaman->tanggal_peminjaman))
                                                {{ $peminjaman->tanggal_peminjaman }} - {{ $peminjaman->tanggal_pengembalian }}
                                            @else
                                                {{ $peminjaman->tanggal_peminjaman->format('d M Y') }} - 
                                                {{ $peminjaman->tanggal_pengembalian->format('d M Y') }}
                                            @endif
                                        </p>
                                        <span class="text-xs px-2 py-1 rounded-full {{ $peminjaman->status_peminjaman == 'Dipinjam' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $peminjaman->status_peminjaman }}
                                        </span>
                                    </div>
                                    <a href="{{ route('peminjaman.show', $peminjaman->id) }}" 
                                       class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-history text-gray-400 text-3xl mb-2"></i>
                            <p class="text-gray-500">Belum ada riwayat peminjaman untuk buku ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script>
        // Format time function
        function formatTime(date) {
            return date.getFullYear() + '-' + 
                   String(date.getMonth() + 1).padStart(2, '0') + '-' + 
                   String(date.getDate()).padStart(2, '0') + ' ' + 
                   String(date.getHours()).padStart(2, '0') + ':' + 
                   String(date.getMinutes()).padStart(2, '0') + ':' + 
                   String(date.getSeconds()).padStart(2, '0');
        }

        // Update time function
        function updateTime() {
            const now = new Date();
            const timeElement = document.getElementById('current-time');
            if (timeElement) {
                timeElement.textContent = formatTime(now);
            }
        }

        // Update time every second
        setInterval(updateTime, 1000);
        updateTime();

        // Animation observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.transform = 'translateY(0)';
                }
            });
        });

        document.querySelectorAll('.fade-in').forEach((el) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            observer.observe(el);
        });
    </script>
</body>
</html>