<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Ulasan - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .book-cover {
            transition: transform 0.3s ease;
        }

        .book-cover:hover {
            transform: scale(1.05);
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 
                       0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body>
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
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-bookmark mr-3"></i>
                        <span>Koleksi Pribadi</span>
                    </a>

                    <a href="{{ route('peminjaman.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-clock mr-3"></i>
                        <span>Peminjaman</span>
                    </a>

                    <a href="{{ route('ulasanbuku.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-blue-50 text-blue-700">
                        <i class="fas fa-star mr-3"></i>
                        <span>Ulasan</span>
                    </a>
                </nav>

                <!-- Review Stats -->
                <!-- Review Stats -->

                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="ml-64 flex-1 p-8">
            <!-- Header Section -->
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Detail Ulasan</h1>
                        <p class="text-gray-600 mt-1">{{ Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                    </div>
                    <a href="{{ route('ulasanbuku.index') }}" 
                       class="text-blue-600 hover:text-blue-800 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Ulasan
                    </a>
                </div>
            </div>

            <!-- Content Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden max-w-4xl mx-auto fade-in">
                <div class="p-6">
                    <!-- Book Details -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                        <!-- Book Cover -->
                        <div class="col-span-1">
                            <div class="aspect-[3/4] rounded-lg overflow-hidden book-cover">
                                @if ($ulasanbuku->buku->cover)
                                    <img src="{{ asset('covers/' . $ulasanbuku->buku->cover) }}" 
                                         alt="{{ $ulasanbuku->buku->judul }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <i class="fas fa-book text-5xl text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Book Info -->
                        <div class="col-span-2">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $ulasanbuku->buku->judul }}</h2>
                            
                            <div class="space-y-3">
                                <div>
                                    <p class="text-gray-600">Penulis</p>
                                    <p class="font-medium">{{ $ulasanbuku->buku->penulis }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Penerbit</p>
                                    <p class="font-medium">{{ $ulasanbuku->buku->penerbit }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Tahun Terbit</p>
                                    <p class="font-medium">{{ $ulasanbuku->buku->tahun_terbit }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-600 mb-2">Kategori</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($ulasanbuku->buku->kategoribukus as $kategori)
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                                {{ $kategori->nama_kategori }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <a href="{{ route('buku.show', $ulasanbuku->buku_id) }}" 
                                       class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Lihat Detail Buku
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-8">

                    <!-- Review Section -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-semibold text-gray-800">Ulasan Saya</h3>

                        <!-- Rating -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-600 mb-2">Rating</p>
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $ulasanbuku->ranting)
                                        <i class="fas fa-star text-2xl"></i>
                                    @else
                                        <i class="far fa-star text-2xl"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>

                        <!-- Review Text -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <p class="text-gray-600 mb-2">Ulasan</p>
                            <p class="text-gray-800">{{ $ulasanbuku->ulasan }}</p>
                        </div>

                        <!-- Timestamps -->
                        <div class="text-sm text-gray-500 space-y-1">
                            <p>Dibuat pada: {{ $ulasanbuku->created_at->format('d/m/Y H:i') }}</p>
                            @if($ulasanbuku->created_at != $ulasanbuku->updated_at)
                                <p>Diperbarui pada: {{ $ulasanbuku->updated_at->format('d/m/Y H:i') }}</p>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4 pt-4">
                            <a href="{{ route('ulasanbuku.edit', $ulasanbuku->id) }}" 
                               class="inline-flex items-center justify-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition duration-200">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Ulasan
                            </a>
                            <form action="{{ route('ulasanbuku.destroy', $ulasanbuku->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Anda yakin ingin menghapus ulasan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center justify-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition duration-200">
                                    <i class="fas fa-trash mr-2"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Format time function
        function formatTime(date) {
            return date.getUTCFullYear() + '-' + 
                   String(date.getUTCMonth() + 1).padStart(2, '0') + '-' + 
                   String(date.getUTCDate()).padStart(2, '0') + ' ' + 
                   String(date.getUTCHours()).padStart(2, '0') + ':' + 
                   String(date.getUTCMinutes()).padStart(2, '0') + ':' + 
                   String(date.getUTCSeconds()).padStart(2, '0');
        }

        // Update time function
        function updateTime() {
            const now = new Date();
            document.getElementById('current-time').textContent = formatTime(now);
        }

        // Update time every second
        setInterval(updateTime, 1000);
        updateTime();

        // Animate elements on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
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