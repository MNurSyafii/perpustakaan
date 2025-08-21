<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Koleksi - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
        }

        .dashboard-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(31, 38, 135, 0.15);
        }

        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

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

        .animate-fadeIn {
            animation: fadeInUp 0.5s ease forwards;
        }

        .book-card {
            transition: all 0.3s ease;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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
            <!-- Header Section -->
            <div class="mb-8 animate-fadeIn">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Tambah ke Koleksi</h1>
                        <p class="text-gray-600 mt-2">
                            <i class="far fa-calendar-alt mr-2"></i>
                            {{ Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </p>
                    </div>
                    <a href="{{ route('koleksipribadi.index') }}" 
                       class="flex items-center text-gray-600 hover:text-gray-800">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Quick Add Form -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="lg:col-span-1">
                    <div class="dashboard-card rounded-xl p-6">
                        <h2 class="text-lg font-semibold mb-6">Tambah Buku ke Koleksi</h2>
                        <form action="{{ route('koleksipribadi.store') }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <label for="buku_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pilih Buku
                                </label>
                                <select id="buku_id" name="buku_id" class="w-full" required>
                                    <option value="">-- Pilih Buku --</option>
                                    @foreach($bukus as $buku)
                                        <option value="{{ $buku->id }}">
                                            {{ $buku->judul }} ({{ $buku->penulis ?? 'Tidak tersedia' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                                <i class="fas fa-plus mr-2"></i>
                                Tambahkan ke Koleksi
                            </button>
                        </form>
                    </div>

                    <!-- Info Box -->
                    <div class="dashboard-card rounded-xl p-6 mt-6">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-info-circle text-blue-600 text-xl mr-3"></i>
                            <h3 class="text-lg font-medium">Petunjuk</h3>
                        </div>
                        <p class="text-gray-600 text-sm">
                            Anda dapat menambahkan buku ke koleksi pribadi dengan dua cara:
                        </p>
                        <ul class="mt-4 space-y-2 text-sm text-gray-600">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Menggunakan form pemilihan buku di atas</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <span>Mengklik tombol "Tambah ke Koleksi" pada kartu buku di bawah</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Available Books Grid -->
                <div class="lg:col-span-2">
                    <div class="dashboard-card rounded-xl overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h2 class="text-lg font-semibold mb-4">Daftar Buku Tersedia</h2>
                            <div class="relative">
                                <input type="text" 
                                       id="searchInput"
                                       placeholder="Cari judul buku atau penulis..." 
                                       class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="absolute left-3 top-2.5 text-gray-400">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="bukuContainer">
                                @foreach($bukus as $buku)
                                    <div class="book-card bg-white rounded-lg border hover:shadow-lg transition-all">
                                        <div class="p-4">
                                            <div class="flex space-x-4">
                                                <!-- Book Cover -->
                                                <div class="w-1/3">
                                                    <div class="aspect-[3/4] rounded-lg overflow-hidden bg-gray-100">
                                                        @if($buku->cover)
                                                            <img src="{{ asset('covers/' . $buku->cover) }}" 
                                                                 alt="{{ $buku->judul }}"
                                                                 class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center">
                                                                <i class="fas fa-book text-3xl text-gray-400"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- Book Info -->
                                                <div class="w-2/3">
                                                    <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $buku->judul }}</h3>
                                                    <div class="space-y-1 text-sm text-gray-600">
                                                        <p><i class="fas fa-user mr-2"></i>{{ $buku->penulis }}</p>
                                                        <p><i class="fas fa-building mr-2"></i>{{ $buku->penerbit }}</p>
                                                        <p><i class="fas fa-calendar mr-2"></i>{{ $buku->tahun_terbit }}</p>
                                                    </div>
                                                    
                                                    <form action="{{ route('koleksipribadi.store') }}" method="POST" class="mt-4">
                                                        @csrf
                                                        <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                                                        <button type="submit" 
                                                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 text-sm">
                                                            <i class="fas fa-plus mr-2"></i>Tambah ke Koleksi
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Initialize Tom Select
        new TomSelect('#buku_id', {
            create: false,
            sortField: {
                field: 'text',
                direction: 'asc'
            }
        });

        // Real-time search functionality
        const searchInput = document.getElementById('searchInput');
        const bukuItems = document.querySelectorAll('.book-card');

        searchInput.addEventListener('keyup', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            bukuItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

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