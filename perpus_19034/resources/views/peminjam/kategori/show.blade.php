<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kategoribuku->nama_kategori }} - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 
                       0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-blue-800 text-white fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <span class="text-xl font-bold">Perpustakaan Digital</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="ml-4 flex items-center md:ml-6">
                        <div class="ml-3 relative">
                            <div class="flex items-center">
                                <span class="mr-4">{{ Auth::user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="bg-blue-700 hover:bg-blue-600 px-4 py-2 rounded-md text-sm">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen pt-16">
        <!-- Sidebar -->
        <aside class="fixed left-0 top-16 h-screen w-64 bg-white border-r">
            <div class="p-4">
                <nav class="space-y-2">
                    <a href="{{ route('peminjam.dashboard') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-100">
                        <i class="fas fa-home mr-2"></i> Dashboard
                    </a>
                    <a href="{{ route('buku.index') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-100">
                        <i class="fas fa-book mr-2"></i> Katalog Buku
                    </a>
                    <a href="{{ route('koleksipribadi.index') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-100">
                        <i class="fas fa-bookmark mr-2"></i> Koleksi Pribadi
                    </a>
                    <a href="{{ route('peminjaman.index') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-100">
                        <i class="fas fa-clock-rotate-left mr-2"></i> Peminjaman
                    </a>
                    <a href="{{ route('ulasanbuku.index') }}" 
                       class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-100">
                        <i class="fas fa-star mr-2"></i> Ulasan
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="ml-64 flex-1 p-8">
            <!-- Header Section -->
            <div class="mb-6 fade-in">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">{{ $kategoribuku->nama_kategori }}</h1>
                        <p class="text-gray-600">{{ Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                    </div>
                    <a href="{{ route('kategoribuku.index') }}" 
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 fade-in" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 fade-in" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Books Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($kategoribuku->bukus as $buku)
                    <div class="bg-white rounded-lg overflow-hidden hover-scale card-shadow fade-in">
                        <div class="relative aspect-[3/4] overflow-hidden bg-gray-200">
                            @if ($buku->cover)
                                <img src="{{ asset('covers/' . $buku->cover) }}" 
                                     alt="{{ $buku->judul }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-book text-5xl"></i>
                                </div>
                            @endif
                            <div class="absolute top-2 right-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $buku->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $buku->stok > 0 ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $buku->judul }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $buku->penulis }}</p>
                            <p class="text-gray-500 text-sm mb-2">Tahun: {{ $buku->tahun_terbit }}</p>
                            
                            <!-- Kategori -->
                            <div class="mb-3">
                                @foreach($buku->kategoribukus as $kategori)
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1 mb-1">
                                        {{ $kategori->nama_kategori }}
                                    </span>
                                @endforeach
                            </div>

                            <div class="flex justify-between items-center mt-4">
                                <span class="text-sm text-gray-500">
                                    <i class="fas fa-book-open mr-1"></i>
                                    Stok: {{ $buku->stok }}
                                </span>
                                <a href="{{ route('buku.show', $buku->id) }}" 
                                   class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm">
                                    Detail <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <i class="fas fa-books text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">Tidak ada buku dalam kategori ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </main>
    </div>

    <script>
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

        // Auto-hide alerts after 3 seconds
        setTimeout(() => {
            document.querySelectorAll('[role="alert"]').forEach(alert => {
                alert.remove();
            });
        }, 3000);
    </script>
</body>
</html>