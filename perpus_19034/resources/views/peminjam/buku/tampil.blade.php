<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
        }

        /* Navbar Styles */
        .glass-navbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }

        /* Search Input */
        .search-input {
            transition: all 0.3s ease;
        }

        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        /* Book Card - Compact Version */
        .book-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .book-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Book Cover */
        .book-cover-container {
            height: 180px;
            overflow: hidden;
            position: relative;
        }

        .book-cover-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .book-card:hover .book-cover-container img {
            transform: scale(1.05);
        }

        /* Cover Overlay */
        .cover-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 100%);
            height: 50%;
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: flex-end;
            padding: 0.5rem;
        }

        .book-card:hover .cover-overlay {
            opacity: 1;
        }

        /* Book Info */
        .book-info {
            padding: 0.75rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .book-title {
            font-size: 0.95rem;
            font-weight: 600;
            line-height: 1.3;
            height: 2.6rem;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .book-card:hover .book-title {
            color: #3b82f6;
        }

        /* Book Meta */
        .book-meta {
            font-size: 0.8rem;
            color: #6b7280;
            display: flex;
            align-items: center;
            margin-bottom: 0.25rem;
        }

        .book-meta i {
            margin-right: 0.25rem;
            font-size: 0.7rem;
        }

        /* Categories */
        .category-pill {
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 9999px;
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #dbeafe;
            display: inline-block;
            margin-right: 0.25rem;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease forwards;
        }

        /* Filter Dropdown */
        .filter-dropdown {
            transition: all 0.3s ease;
        }

        .filter-dropdown:hover {
            border-color: #3b82f6;
        }
    </style>
</head>
<body>
    <nav class="fixed top-0 w-full bg-white bg-opacity-80 z-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <button class="mobile-menu-btn mr-4 text-gray-600 md:hidden">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <span class="text-xl font-bold text-blue-600">
                        <i class="fas fa-book-reader mr-2"></i>
                        Perpustakaan Digital
                    </span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center text-gray-600 text-sm">
                        <i class="far fa-clock mr-2"></i>
                        <span id="current-time">{{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</span>
                    </div>


                    <div class="flex items-center space-x-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Peminjam</p>
                        </div>
                        <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                <i class="fas fa-sign-out-alt mr-1"></i> <span class="hidden sm:inline">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen pt-16">
        <!-- Sidebar -->
        <aside class="sidebar fixed left-0 top-16 h-screen w-64 bg-white border-r border-gray-200">
            <div class="p-4 h-full overflow-y-auto">
                <div class="flex flex-col items-center p-4 mb-6 bg-blue-50 rounded-lg">
                    <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-center text-white text-xl font-bold mb-2">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <h3 class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</h3>
                    <p class="text-xs text-gray-500">Member sejak {{ Auth::user()->created_at->format('M Y') }}</p>
                </div>

                <nav class="space-y-1">
                    <a href="{{ route('peminjam.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-blue-50 text-blue-700">
                        <i class="fas fa-home mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('buku.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-book mr-3"></i>
                        <span>Katalog Buku</span>
                    </a>
                    <a href="{{ route('peminjaman.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-clock mr-3"></i>
                        <span>Peminjaman</span>
                    </a>
                    <a href="{{ route('koleksipribadi.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-bookmark mr-3"></i>
                        <span>Koleksi Pribadi</span>
                    </a>
                    <a href="{{ route('ulasanbuku.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-star mr-3"></i>
                        <span>Ulasan</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="ml-64 flex-1 p-6">
            <!-- Header Section -->
            <div class="mb-6 animate-fadeInUp">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-books text-blue-600 mr-3"></i>
                    Katalog Buku
                </h1>
                <p class="text-gray-600 mt-1 text-sm">
                    <i class="far fa-calendar-alt mr-2"></i>
                    {{ Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </p>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
                <div class="flex flex-col md:flex-row gap-3">
                    <!-- Search Bar -->
                    <div class="flex-1">
                        <form action="{{ route('buku.index') }}" method="GET" class="relative">
                            <input type="text" 
                                   name="search"
                                   placeholder="Cari judul, penulis, atau kategori..." 
                                   value="{{ request('search') }}"
                                   class="w-full pl-10 pr-4 py-2 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 transition-all search-input">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </form>
                    </div>

                    <!-- Category Filter -->
                    <div class="flex gap-3">
                        <form action="{{ route('buku.index') }}" method="GET">
                            <select name="kategori" onchange="this.form.submit()" 
                                    class="pl-3 pr-8 py-2 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-0 filter-dropdown text-sm">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoribukus as $kategori)
                                    <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Active Filters -->
                <div class="flex flex-wrap gap-2 mt-3">
                    @if(request('search'))
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-800">
                            Pencarian: {{ request('search') }}
                            <a href="{{ route('buku.index', ['kategori' => request('kategori')]) }}" 
                               class="ml-1 text-blue-600 hover:text-blue-800">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif

                    @if(request('kategori'))
                        @php
                            $selectedKategori = $kategoribukus->firstWhere('id', request('kategori'));
                        @endphp
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-800">
                            Kategori: {{ $selectedKategori->nama_kategori ?? '' }}
                            <a href="{{ route('buku.index', ['search' => request('search')]) }}" 
                               class="ml-1 text-blue-600 hover:text-blue-800">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Books Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @forelse($buku as $item)
                    <div class="book-card overflow-hidden group">
                        <!-- Book Cover -->
                        <div class="book-cover-container">
                            @if($item->cover)
                                <img src="{{ asset('covers/' . $item->cover) }}" 
                                     alt="{{ $item->judul }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                    <i class="fas fa-book text-gray-400 text-3xl"></i>
                                </div>
                            @endif
                            
                            <!-- Hover Overlay -->
                            <div class="cover-overlay">
                                <a href="{{ route('buku.show', $item->id) }}" 
                                   class="w-full bg-white bg-opacity-90 text-blue-600 text-center py-1 rounded text-xs">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>

                        <!-- Book Info -->
                        <div class="book-info">
                            <h3 class="book-title">
                                {{ $item->judul }}
                            </h3>
                            
                            <div class="book-meta">
                                <i class="fas fa-user-edit"></i>
                                <p class="truncate">{{ $item->penulis }}</p>
                            </div>
                            
                            <div class="book-meta">
                                <i class="fas fa-calendar-alt"></i>
                                <p>{{ $item->tahun_terbit }}</p>
                            </div>

                            <!-- Categories -->
                            <div class="mt-auto pt-2">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($item->kategoribukus->take(2) as $kategori)
                                        <span class="category-pill">
                                            {{ Str::limit($kategori->nama_kategori, 12) }}
                                        </span>
                                    @endforeach
                                    @if($item->kategoribukus->count() > 2)
                                        <span class="category-pill bg-gray-50 text-gray-600 border-gray-100">
                                            +{{ $item->kategoribukus->count() - 2 }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                            <i class="fas fa-books text-gray-400 text-4xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-800 mb-2">Tidak ada buku</h3>
                            <p class="text-gray-500">Belum ada buku yang tersedia dalam katalog.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $buku->links() }}
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Real-time clock
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleString('id-ID', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });
            document.getElementById('current-time').textContent = timeString;
        }

        // Update time every second
        setInterval(updateTime, 1000);
        updateTime(); // Initial call
    </script>
</body>
</html>