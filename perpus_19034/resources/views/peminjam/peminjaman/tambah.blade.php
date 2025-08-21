<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjam Buku - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(30px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        .hover-scale {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-scale:hover {
            transform: scale(1.02) translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 
                       0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .card-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 
                       0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .nav-link {
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: white !important;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: white !important;
        }

        .form-input {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }

        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-secondary {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            transform: translateY(-1px);
        }

        .info-box {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-left: 4px solid #3b82f6;
            border-radius: 12px;
        }

        .book-preview-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
            border-radius: 12px;
        }

        .book-preview-card:hover {
            border-color: #3b82f6;
            transform: translateY(-2px);
        }

        input[type="date"] {
            position: relative;
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            background: transparent;
            bottom: 0;
            color: transparent;
            cursor: pointer;
            height: auto;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: auto;
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper::after {
            content: '\f107';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6b7280;
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
                <nav class="space-y-2">
                    <a href="{{ route('peminjam.dashboard') }}" 
                       class="nav-link flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700">
                        <i class="fas fa-home w-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('buku.index') }}" 
                       class="nav-link flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700">
                        <i class="fas fa-book w-5 mr-3"></i>
                        <span>Katalog Buku</span>
                    </a>

                    <a href="{{ route('koleksipribadi.index') }}" 
                       class="nav-link flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700">
                        <i class="fas fa-bookmark w-5 mr-3"></i>
                        <span>Koleksi Pribadi</span>
                    </a>

                    <a href="{{ route('peminjaman.index') }}" 
                       class="nav-link active flex items-center px-4 py-3 text-sm font-medium rounded-lg">
                        <i class="fas fa-clock w-5 mr-3"></i>
                        <span>Peminjaman</span>
                    </a>

                    <a href="{{ route('ulasanbuku.index') }}" 
                       class="nav-link flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-700">
                        <i class="fas fa-star w-5 mr-3"></i>
                        <span>Ulasan</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="ml-64 flex-1 p-8">
            <!-- Header Section -->
            <div class="mb-8 fade-in">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                            Pinjam Buku
                        </h1>
                        <p class="text-gray-600 mt-2 text-lg">{{ Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                    </div>
                    <a href="{{ route('peminjaman.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-blue-600 hover:text-blue-800 font-medium transition-all hover:bg-blue-50 rounded-lg">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Peminjaman
                    </a>
                </div>
            </div>

            <!-- Form Card -->
            <div class="glass-effect rounded-2xl overflow-hidden fade-in hover-scale">
                <div class="p-8">
                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6" role="alert">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <h4 class="font-semibold">Terjadi kesalahan:</h4>
                            </div>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Info Box -->
                    <div class="info-box p-6 mb-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-600 text-xl mr-4 mt-1"></i>
                            </div>
                            <div>
                                <h5 class="font-semibold text-gray-800 mb-2">Informasi Peminjaman</h5>
                                <p class="text-gray-700 leading-relaxed">
                                    Setelah memilih buku, peminjaman Anda akan diproses oleh petugas perpustakaan.
                                    Anda akan mendapat notifikasi ketika peminjaman disetujui beserta informasi
                                    tanggal peminjaman dan pengembalian.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Pilih Buku -->
                        <div>
                            <label for="buku_id" class="block text-sm font-semibold text-gray-800 mb-3">
                                Pilih Buku <span class="text-red-500">*</span>
                            </label>
                            <div class="relative select-wrapper">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                    <i class="fas fa-book text-blue-500"></i>
                                </div>
                                <select id="buku_id" 
                                        name="buku_id" 
                                        class="form-input w-full pl-12 pr-12 py-4 text-lg rounded-xl appearance-none @error('buku_id') border-red-400 @enderror" 
                                        required>
                                    <option value="">-- Pilih Buku --</option>
                                    @foreach($buku as $b)
                                        <option value="{{ $b->id }}" 
                                                {{ old('buku_id') == $b->id ? 'selected' : '' }}
                                                data-cover="{{ $b->cover ? asset('covers/'.$b->cover) : '' }}"
                                                data-penulis="{{ $b->penulis }}"
                                                data-penerbit="{{ $b->penerbit }}">
                                            {{ $b->judul }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('buku_id')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Book Preview -->
                        <div id="bookPreview" class="hidden">
                            <div class="book-preview-card p-6">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4">Preview Buku</h4>
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <img id="bookCover" 
                                             src="" 
                                             alt="Book Cover" 
                                             class="w-24 h-32 object-cover rounded-lg shadow-md">
                                    </div>
                                    <div class="flex-1">
                                        <h5 id="bookTitle" class="text-xl font-bold text-gray-800 mb-2"></h5>
                                        <p class="text-gray-600 mb-1">
                                            <span class="font-medium">Penulis:</span> 
                                            <span id="bookAuthor"></span>
                                        </p>
                                        <p class="text-gray-600">
                                            <span class="font-medium">Penerbit:</span> 
                                            <span id="bookPublisher"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4 pt-6">
                            <a href="{{ route('peminjaman.index') }}" 
                               class="btn-secondary inline-flex items-center px-6 py-3 text-gray-700 font-medium rounded-xl">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                            <button type="submit" 
                                    class="btn-primary inline-flex items-center px-8 py-3 text-white font-medium rounded-xl">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Ajukan Peminjaman
                            </button>
                        </div>
                    </form>
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
            const timeElement = document.getElementById('current-time');
            if (timeElement) {
                timeElement.textContent = formatTime(now);
            }
        }

        // Update time every second
        setInterval(updateTime, 1000);
        updateTime();

        // Initialize Tom Select and Book Preview
        document.addEventListener('DOMContentLoaded', function() {
            const tomSelect = new TomSelect('#buku_id', {
                create: false,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                },
                onChange: function(value) {
                    const bookPreview = document.getElementById('bookPreview');
                    
                    if (value) {
                        const selectedOption = document.querySelector(`#buku_id option[value="${value}"]`);
                        if (selectedOption) {
                            // Update book preview
                            document.getElementById('bookTitle').textContent = selectedOption.textContent.trim();
                            document.getElementById('bookAuthor').textContent = selectedOption.getAttribute('data-penulis') || 'Tidak diketahui';
                            document.getElementById('bookPublisher').textContent = selectedOption.getAttribute('data-penerbit') || 'Tidak diketahui';
                            
                            const bookCover = document.getElementById('bookCover');
                            const coverUrl = selectedOption.getAttribute('data-cover');
                            if (coverUrl) {
                                bookCover.src = coverUrl;
                                bookCover.style.display = 'block';
                            } else {
                                bookCover.style.display = 'none';
                            }
                            
                            bookPreview.classList.remove('hidden');
                            bookPreview.classList.add('fade-in');
                        }
                    } else {
                        bookPreview.classList.add('hidden');
                    }
                }
            });

            // Handle date inputs if they exist
            const tanggalPeminjaman = document.getElementById('tanggal_peminjaman');
            const tanggalPengembalian = document.getElementById('tanggal_pengembalian');
            
            if (tanggalPeminjaman) {
                // Set minimum dates for inputs
                const today = new Date().toISOString().split('T')[0];
                tanggalPeminjaman.setAttribute('min', today);

                // Update tanggal_pengembalian when tanggal_peminjaman changes
                tanggalPeminjaman.addEventListener('change', function() {
                    if (tanggalPengembalian) {
                        const startDate = new Date(this.value);
                        const endDate = new Date(startDate);
                        endDate.setDate(startDate.getDate() + 7);
                        
                        const formattedEndDate = endDate.toISOString().split('T')[0];
                        tanggalPengembalian.setAttribute('min', this.value);
                        tanggalPengembalian.value = formattedEndDate;
                    }
                });
            }
        });
    </script>
</body>
</html>