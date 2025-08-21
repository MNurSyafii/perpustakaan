<!-- Current Date and Time (UTC - YYYY-MM-DD HH:MM:SS formatted): 2025-05-18 00:46:55 -->
<!-- Current User's Login: MNurSyafii -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Buku - Perpustakaan Digital</title>
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

        .status-badge {
            transition: all 0.3s ease;
        }

        .status-badge:hover {
            transform: translateY(-1px);
        }

        .table-hover tr:hover {
            background-color: rgba(249, 250, 251, 0.8);
            transition: background-color 0.2s ease;
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

                    <a href="{{ route('peminjaman.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-clock mr-3"></i>
                        <span>Peminjaman</span>
                    </a>

                    <a href="{{ route('koleksipribadi.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-blue-50 text-blue-700">
                        <i class="fas fa-bookmark mr-3"></i>
                        <span>Koleksi Pribadi</span>
                    </a>

                    <a href="{{ route('ulasanbuku.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-star mr-3"></i>
                        <span>Ulasan</span>
                    </a>
                </nav>

                <!-- Loan Stats -->
             
        </aside>

        <!-- Main Content -->
<main class="ml-64 flex-1 p-8">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Riwayat Peminjaman</h1>
                        <p class="text-gray-600 mt-2">
                            <i class="far fa-calendar-alt mr-2"></i>
                            {{ Carbon\Carbon::parse('2025-05-17')->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </p>            </div>
            <div class="flex items-center gap-4">
                <!-- Current Time Display -->
                <div class="text-sm text-gray-600">
                </div>
                <a href="{{ route('peminjaman.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Pinjam Buku
                </a>
            </div>
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

    

    <!-- Peminjaman Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 table-hover">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul Buku</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Kembali</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($peminjaman as $index => $p)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        @if($p->buku->cover)
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="{{ asset('covers/' . $p->buku->cover) }}" 
                                                 alt="{{ $p->buku->judul }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-book text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $p->buku->judul }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $p->buku->penulis }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                           <td>
    {{ $p->tanggal_peminjaman ? \Carbon\Carbon::parse($p->tanggal_peminjaman)->format('d/m/Y') : '-' }}
</td>
<td>
    {{ $p->tanggal_pengembalian ? \Carbon\Carbon::parse($p->tanggal_pengembalian)->format('d/m/Y') : '-' }}
</td>

                                <td>
                                    @php
                                        $statusClasses = [
                                            'Menunggu' => 'bg-info',
                                            'Disetujui' => 'bg-white',
                                            'Ditolak' => 'bg-danger',
                                            'Dipinjam' => 'bg-warning',
                                            'Dikembalikan' => 'bg-success'
                                        ];
                                        
                                        $statusIcons = [
                                            'Menunggu' => 'fas fa-clock',
                                            'Disetujui' => 'fas fa-check',
                                            'Ditolak' => 'fas fa-times',
                                            'Dipinjam' => 'fas fa-hand-holding',
                                            'Dikembalikan' => 'fas fa-check-circle'
                                        ];
                                    @endphp

                                    <span class="badge {{ $statusClasses[$p->status_peminjaman] ?? 'bg-secondary' }} text-black-{{ $statusClasses[$p->status_peminjaman] ? substr($statusClasses[$p->status_peminjaman], 3) : 'secondary' }}">
                                        <i class="{{ $statusIcons[$p->status_peminjaman] ?? 'fas fa-question' }} me-1"></i>
                                        {{ $p->status_peminjaman }}
                                    </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('peminjaman.show', $p->id) }}" 
                                   class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center py-6">
                                    <i class="fas fa-book-reader text-4xl mb-2"></i>
                                    <p>Belum ada data peminjaman</p>
                                    <a href="{{ route('peminjaman.create') }}" 
                                       class="mt-4 inline-flex items-center text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-plus mr-2"></i>
                                        Booking Buku Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

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

        // Auto-hide alerts after 3 seconds
        setTimeout(() => {
            document.querySelectorAll('[role="alert"]').forEach(alert => {
                alert.remove();
            });
        }, 3000);
    </script>
</body>
</html>