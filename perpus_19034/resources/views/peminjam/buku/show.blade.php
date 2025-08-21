<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
        }

        /* Book Cover */
        .book-cover-large {
            height: 400px;
            width: 280px;
            border-radius: 0.75rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s ease;
            object-fit: cover;
        }

        .book-cover-large:hover {
            transform: scale(1.02);
        }

        /* Info Cards */
        .info-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Category Pills */
        .category-pill {
            font-size: 0.8rem;
            padding: 0.3rem 0.75rem;
            border-radius: 9999px;
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #dbeafe;
            display: inline-block;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
        }

        .category-pill:hover {
            background-color: #dbeafe;
            transform: scale(1.05);
        }

        /* Review Cards */
        .review-card {
            background: white;
            border-radius: 0.75rem;
            border-left: 4px solid #3b82f6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .review-card:hover {
            transform: translateX(4px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        /* Star Rating */
        .star-rating {
            color: #fbbf24;
        }

        /* Action Buttons */
        .action-btn {
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
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
                    <a href="{{ route('peminjam.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-home mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('buku.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-blue-50 text-blue-700">
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
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-book-open text-blue-600 mr-3"></i>
                            Detail Buku
                        </h1>
                        <p class="text-gray-600 mt-1 text-sm">
                            <i class="far fa-calendar-alt mr-2"></i>
                            {{ Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </p>
                    </div>
                    
                    <!-- Back Button -->
                    <a href="{{ route('buku.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Katalog
                    </a>
                </div>
            </div>

            <!-- Book Detail Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Book Cover -->
                <div class="lg:col-span-1">
                    <div class="info-card p-6 text-center">
                        @if($buku->cover)
                            <img src="{{ asset('covers/' . $buku->cover) }}" 
                                 alt="{{ $buku->judul }}"
                                 class="book-cover-large mx-auto">
                        @else
                            <div class="book-cover-large mx-auto flex items-center justify-center bg-gray-100">
                                <i class="fas fa-book text-gray-400 text-6xl"></i>
                            </div>
                        @endif
                        
                        <!-- Action Buttons -->
                        <div class="mt-6 space-y-3">
                            <a href="{{ route('peminjaman.create', ['buku_id' => $buku->id]) }}" 
                               class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors action-btn inline-flex items-center justify-center">
                                <i class="fas fa-book-reader mr-2"></i>
                                Booking Buku
                            </a>
                            
                            <form action="{{ route('koleksipribadi.create') }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                                <button type="submit" 
                                        class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-green-700 transition-colors action-btn">
                                    <i class="fas fa-bookmark mr-2"></i>
                                    Tambah ke Koleksi
                                </button>
                            </form>
                            
                            <a href="{{ route('ulasanbuku.create', ['buku_id' => $buku->id]) }}" 
                               class="w-full bg-yellow-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-yellow-700 transition-colors action-btn inline-flex items-center justify-center">
                                <i class="fas fa-star mr-2"></i>
                                Tulis Ulasan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Book Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Main Info -->
                    <div class="info-card p-6">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ $buku->judul }}</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-user-edit w-5 mr-3 text-blue-600"></i>
                                <div>
                                    <p class="text-sm text-gray-500">Penulis</p>
                                    <p class="font-medium">{{ $buku->penulis }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-building w-5 mr-3 text-blue-600"></i>
                                <div>
                                    <p class="text-sm text-gray-500">Penerbit</p>
                                    <p class="font-medium">{{ $buku->penerbit }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar-alt w-5 mr-3 text-blue-600"></i>
                                <div>
                                    <p class="text-sm text-gray-500">Tahun Terbit</p>
                                    <p class="font-medium">{{ $buku->tahun_terbit }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-tags w-5 mr-3 text-blue-600"></i>
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Tersedia
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="mb-6">
                            <p class="text-sm text-gray-500 mb-2">Kategori</p>
                            <div class="flex flex-wrap">
                                @foreach($buku->kategoribukus as $kategori)
                                    <span class="category-pill">
                                        <i class="fas fa-tag mr-1"></i>
                                        {{ $kategori->nama_kategori }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="info-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-800">
                                <i class="fas fa-star text-yellow-500 mr-2"></i>
                                Ulasan & Rating
                            </h3>
                            <span class="text-sm text-gray-500">
                                {{ $buku->ulasanbukus->count() }} ulasan
                            </span>
                        </div>

                        @if($buku->ulasanbukus->count() > 0)
                            <!-- Average Rating -->
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <div class="flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-gray-800 mb-1">
                                            {{ number_format($buku->ulasanbukus->avg('rating'), 1) }}
                                        </div>
                                        <div class="flex justify-center mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= round($buku->ulasanbukus->avg('rating')) ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                            @endfor
                                        </div>
                                        <p class="text-sm text-gray-600">dari {{ $buku->ulasanbukus->count() }} ulasan</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Reviews List -->
                            <div class="space-y-4 max-h-96 overflow-y-auto">
                                @foreach($buku->ulasanbukus->take(5) as $ulasan)
                                    <div class="review-card p-4">
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-medium mr-3">
                                                    {{ substr($ulasan->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-800">{{ $ulasan->user->name }}</p>
                                                    <div class="flex items-center">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star text-xs {{ $i <= $ulasan->rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                                        @endfor
                                                        <span class="text-xs text-gray-500 ml-2">{{ $ulasan->rating }}/5</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-500">
                                                {{ $ulasan->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p class="text-gray-600 text-sm">{{ $ulasan->ulasan }}</p>
                                    </div>
                                @endforeach
                                
                                @if($buku->ulasanbukus->count() > 5)
                                    <div class="text-center">
                                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Lihat semua ulasan ({{ $buku->ulasanbukus->count() }})
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-star text-4xl mb-4 text-gray-300"></i>
                                <p class="text-lg font-medium mb-2">Belum ada ulasan</p>
                                <p class="text-sm">Jadilah yang pertama memberikan ulasan untuk buku ini!</p>
                            </div>
                        @endif
                    </div>
                </div>
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

        // Smooth scroll for reviews
        document.querySelectorAll('.review-card').forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-fadeInUp');
        });
    </script>
</body>
</html>