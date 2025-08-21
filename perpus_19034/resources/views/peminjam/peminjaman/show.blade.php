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

        .sidebar-full-height {
            height: calc(100vh - 4rem);
        }

        .main-content {
            margin-left: 16rem;
            min-height: calc(100vh - 4rem);
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
            .sidebar-mobile {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
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
        <aside class="fixed left-0 top-16 w-64 bg-white border-r border-gray-200 sidebar-full-height overflow-y-auto sidebar-mobile md:translate-x-0">
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
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-home mr-3"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('buku.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-book mr-3"></i>
                        <span>Katalog Buku</span>
                    </a>

                    <a href="{{ route('koleksipribadi.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-blue-50 text-blue-700">
                        <i class="fas fa-bookmark mr-3"></i>
                        <span>Koleksi Pribadi</span>
                    </a>

                    <a href="{{ route('peminjaman.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-clock mr-3"></i>
                        <span>Peminjaman</span>
                    </a>

                    <a href="{{ route('ulasanbuku.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-star mr-3"></i>
                        <span>Ulasan</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content p-8">
            <!-- Back Button -->
            <div class="mb-6 fade-in">
                <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Peminjaman
                </a>
            </div>

            <!-- Peminjaman Details Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden fade-in">
                <div class="md:flex">
                    <!-- Book Cover Section -->
                    <div class="md:w-1/3 p-6">
                        <div class="aspect-[3/4] rounded-lg overflow-hidden shadow-lg book-cover">
                            @if($peminjaman->buku->cover)
                                <img src="{{ asset('covers/' . $peminjaman->buku->cover) }}" 
                                     alt="{{ $peminjaman->buku->judul }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                    <i class="fas fa-book text-gray-400 text-5xl"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                   <!-- Peminjaman Information -->
<div class="md:w-2/3 p-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $peminjaman->buku->judul }}</h1>
    
    <!-- Status Badge -->
    <div class="flex flex-wrap gap-2 mb-6">
        <span class="px-4 py-2 rounded-full text-sm font-medium
            @if($peminjaman->status_peminjaman == 'Menunggu')
                bg-gray-50 text-gray-700 border border-gray-200
            @elseif($peminjaman->status_peminjaman == 'Disetujui')
                bg-blue-50 text-blue-700 border border-blue-200
            @elseif($peminjaman->status_peminjaman == 'Ditolak')
                bg-red-50 text-red-700 border border-red-200
            @elseif($peminjaman->status_peminjaman == 'Dipinjam')
                bg-yellow-50 text-yellow-700 border border-yellow-200
            @elseif($peminjaman->status_peminjaman == 'Dikembalikan')
                bg-green-50 text-green-700 border border-green-200
            @endif">
            <i class="fas 
                @if($peminjaman->status_peminjaman == 'Menunggu') fa-clock
                @elseif($peminjaman->status_peminjaman == 'Disetujui') fa-check
                @elseif($peminjaman->status_peminjaman == 'Ditolak') fa-times-circle
                @elseif($peminjaman->status_peminjaman == 'Dipinjam') fa-book
                @elseif($peminjaman->status_peminjaman == 'Dikembalikan') fa-check-circle
                @endif 
                mr-2"></i>
            {{ ucfirst($peminjaman->status_peminjaman) }}
        </span>
    </div>

    <!-- Peminjaman Details -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-gray-500 mb-1">Peminjam</h3>
            <p class="text-lg font-semibold text-gray-900">{{ $peminjaman->user->name }}</p>
        </div>
        @if($peminjaman->status_peminjaman != 'Menunggu' && $peminjaman->status_peminjaman != 'Ditolak')
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-gray-500 mb-1">Tanggal Peminjaman</h3>
            <p class="text-lg font-semibold text-gray-900">
                {{ Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d M Y') }}
            </p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-gray-500 mb-1">Tanggal Pengembalian</h3>
            <p class="text-lg font-semibold text-gray-900">
                {{ Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d M Y') }}
            </p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-gray-500 mb-1">Durasi Peminjaman</h3>
            <p class="text-lg font-semibold text-gray-900">
                {{ Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)
                    ->diffInDays($peminjaman->tanggal_pengembalian) }} Hari
            </p>
        </div>
        @endif
    </div>

    <!-- Action Buttons -->
    @if($peminjaman->status_peminjaman == 'Dipinjam')
        <div class="flex gap-4">
            <a href="{{ route('ulasanbuku.create') }}" 
               class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-all duration-200 text-center font-medium shadow-sm hover:shadow-md">
                <i class="fas fa-star mr-2"></i>
                Beri Ulasan
            </a>
        </div>
    @endif
</div>

<!-- Book Details Section -->
<div class="border-t border-gray-200 p-6 fade-in">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">
        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
        Detail Buku
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-gray-500 mb-1">Penulis</h3>
            <p class="text-lg font-semibold text-gray-900">{{ $peminjaman->buku->penulis }}</p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-gray-500 mb-1">Penerbit</h3>
            <p class="text-lg font-semibold text-gray-900">{{ $peminjaman->buku->penerbit }}</p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-gray-500 mb-1">Tahun Terbit</h3>
            <p class="text-lg font-semibold text-gray-900">{{ $peminjaman->buku->tahun_terbit }}</p>
        </div>
    </div>
</div>

<!-- Status Timeline -->
<div class="border-t border-gray-200 p-6 fade-in">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">
        <i class="fas fa-clock text-blue-600 mr-2"></i>
        Status Peminjaman
    </h2>

    <div class="relative">
        <div class="absolute h-full w-0.5 bg-gray-200 left-3 top-0"></div>
        <div class="space-y-8 relative">
            <!-- Menunggu Status -->
            <div class="flex items-start">
                <div class="z-10 flex items-center justify-center w-8 h-8 rounded-full 
                    @if($peminjaman->status_peminjaman == 'Menunggu') bg-blue-600
                    @else bg-gray-400 @endif text-white shadow-lg">
                    <i class="fas fa-clock text-sm"></i>
                </div>
                <div class="ml-6 bg-white rounded-lg shadow-sm border border-gray-100 p-4 flex-1">
                    <h4 class="text-lg font-semibold text-gray-900">Menunggu Persetujuan</h4>
                    <p class="text-sm text-gray-500 mt-1">
                        <i class="far fa-calendar mr-1"></i>
                        {{ Carbon\Carbon::parse($peminjaman->created_at)->format('d M Y H:i') }}
                    </p>
                    <p class="text-sm text-gray-600 mt-2">Permintaan peminjaman sedang menunggu persetujuan</p>
                </div>
            </div>

            <!-- Disetujui/Ditolak Status -->
            @if(in_array($peminjaman->status_peminjaman, ['Disetujui', 'Ditolak', 'Dipinjam', 'Dikembalikan']))
            <div class="flex items-start">
                <div class="z-10 flex items-center justify-center w-8 h-8 rounded-full 
                    @if($peminjaman->status_peminjaman == 'Ditolak') bg-red-600
                    @else bg-green-600 @endif text-white shadow-lg">
                    <i class="fas @if($peminjaman->status_peminjaman == 'Ditolak') fa-times @else fa-check @endif text-sm"></i>
                </div>
                <div class="ml-6 bg-white rounded-lg shadow-sm border border-gray-100 p-4 flex-1">
                    <h4 class="text-lg font-semibold text-gray-900">
                        @if($peminjaman->status_peminjaman == 'Ditolak')
                            Peminjaman Ditolak
                        @else
                            Peminjaman Disetujui
                        @endif
                    </h4>
                    <p class="text-sm text-gray-500 mt-1">
                        <i class="far fa-calendar mr-1"></i>
                        {{ Carbon\Carbon::parse($peminjaman->updated_at)->format('d M Y H:i') }}
                    </p>
                    <p class="text-sm text-gray-600 mt-2">
                        @if($peminjaman->status_peminjaman == 'Ditolak')
                            Peminjaman buku ini ditolak
                        @else
                            Peminjaman buku ini telah disetujui
                        @endif
                    </p>
                </div>
            </div>
            @endif

            <!-- Dipinjam Status -->
            @if(in_array($peminjaman->status_peminjaman, ['Dipinjam', 'Dikembalikan']))
            <div class="flex items-start">
                <div class="z-10 flex items-center justify-center w-8 h-8 rounded-full 
                    @if($peminjaman->status_peminjaman == 'Dipinjam') bg-yellow-600
                    @else bg-gray-400 @endif text-white shadow-lg">
                    <i class="fas fa-book text-sm"></i>
                </div>
                <div class="ml-6 bg-white rounded-lg shadow-sm border border-gray-100 p-4 flex-1">
                    <h4 class="text-lg font-semibold text-gray-900">Buku Dipinjam</h4>
                    <p class="text-sm text-gray-500 mt-1">
                        <i class="far fa-calendar mr-1"></i>
{{ $peminjaman->tanggal_peminjaman ? Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d M Y H:i') : '-' }}
                    </p>
                    <p class="text-sm text-gray-600 mt-2">Buku berhasil dipinjam dan siap dibaca</p>
                </div>
            </div>
            @endif

            <!-- Dikembalikan Status -->
            @if($peminjaman->status_peminjaman == 'Dikembalikan')
                <div class="flex items-start">
                    <div class="z-10 flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white shadow-lg">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <div class="ml-6 bg-white rounded-lg shadow-sm border border-gray-100 p-4 flex-1">
                        <h4 class="text-lg font-semibold text-gray-900">Buku Dikembalikan</h4>
                        <p class="text-sm text-gray-500 mt-1">
                            <i class="far fa-calendar mr-1"></i>
                            {{ Carbon\Carbon::parse($peminjaman->updated_at)->format('d M Y H:i') }}
                        </p>
                        <p class="text-sm text-gray-600 mt-2">Buku telah dikembalikan dengan selamat</p>
                    </div>
                </div>
            @elseif($peminjaman->status_peminjaman == 'Dipinjam')
                <div class="flex items-start opacity-60">
                    <div class="z-10 flex items-center justify-center w-8 h-8 rounded-full bg-gray-400 text-white">
                        <i class="fas fa-clock text-sm"></i>
                    </div>
                    <div class="ml-6 bg-gray-50 rounded-lg border border-gray-200 p-4 flex-1">
                        <h4 class="text-lg font-semibold text-gray-700">Menunggu Pengembalian</h4>
                        <p class="text-sm text-gray-500 mt-1">
                            <i class="far fa-calendar mr-1"></i>
                    {{ $peminjaman->tanggal_pengembalian ? Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d M Y') : '-' }}
                        </p>
                        <p class="text-sm text-gray-600 mt-2">
                            @if($peminjaman->tanggal_pengembalian && Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->isPast())
                            Buku telah melewati batas waktu pengembalian
                        @elseif($peminjaman->tanggal_pengembalian)
                            Harap kembalikan buku sebelum tanggal tenggat
                        @else
                            Belum ada tanggal pengembalian ditentukan
                        @endif
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
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
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-in').forEach((el) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            observer.observe(el);
        });

        // Mobile sidebar toggle (if needed in future)
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar-mobile');
            if (sidebar) {
                sidebar.classList.toggle('-translate-x-full');
            }
        }
    </script>
</body>
</html>