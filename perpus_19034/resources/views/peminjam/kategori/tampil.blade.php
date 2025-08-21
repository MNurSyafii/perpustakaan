<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Buku - Perpustakaan Digital</title>
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
                       class="block py-2.5 px-4 rounded transition duration-200 bg-blue-100 text-blue-800">
                        <i class="fas fa-star mr-2"></i> Ulasan
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="ml-64 flex-1 p-8">
            <!-- Header Section -->
            <div class="mb-8 fade-in">
                <h1 class="text-3xl font-bold text-gray-800">Kategori Buku</h1>
                <p class="text-gray-600">{{ Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
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

            <!-- Search Section -->
            <div class="mb-6 fade-in">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <form action="{{ route('kategoribuku.index') }}" method="GET" class="relative">
                            <input type="text" 
                                   name="search"
                                   placeholder="Cari kategori..." 
                                   value="{{ request('search') }}"
                                   class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @forelse($kategoribuku as $kategori)
                    <div class="bg-white rounded-lg overflow-hidden hover-scale card-shadow fade-in">
                        <div class="p-6">
                            <div class="text-center mb-4">
                                <div class="inline-block p-3 rounded-full bg-blue-100 text-blue-800 mb-3">
                                    <i class="fas fa-book-open text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $kategori->nama_kategori }}</h3>
                                <div class="text-gray-600">
                                    <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                                        {{ $kategori->bukus_count }} Buku
                                    </span>
                                </div>
                            </div>
                            
                            <a href="{{ route('kategoribuku.show', $kategori->id) }}" 
                               class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                <i class="fas fa-eye mr-2"></i>
                                Lihat Buku
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <i class="fas fa-folder-open text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">Tidak ada kategori yang tersedia.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $kategoribuku->links() }}
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