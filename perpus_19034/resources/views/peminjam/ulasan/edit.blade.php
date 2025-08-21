<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ulasan - Perpustakaan Digital</title>
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

        /* Rating Stars */
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-start;
            gap: 0.5rem;
        }
        
        .rating input {
            display: none;
        }
        
        .rating label {
            cursor: pointer;
            font-size: 2rem;
            color: #d1d5db;
            transition: all 0.2s ease;
            padding: 0.25rem;
        }
        
        .rating label:hover,
        .rating label:hover ~ label,
        .rating input:checked ~ label {
            color: #fbbf24;
            transform: scale(1.1);
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
                <h1 class="text-3xl font-bold text-gray-800">Edit Ulasan</h1>
                <p class="text-gray-600 mt-1">{{ Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
            </div>
            <a href="{{ route('ulasanbuku.index') }}" 
               class="inline-flex items-center text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 fade-in" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
            <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden max-w-3xl mx-auto">
        <div class="p-6">
            <form action="{{ route('ulasanbuku.update', $ulasanbuku->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Pilih Buku -->
                <div>
                    <label for="buku_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Buku
                    </label>
                    <select id="buku_id" 
                            name="buku_id" 
                            class="w-full @error('buku_id') border-red-500 @enderror" 
                            required>
                        <option value="" disabled>-- Pilih Buku --</option>
                        @foreach($bukus as $buku)
                            <option value="{{ $buku->id }}" 
                                    {{ (old('buku_id', $ulasanbuku->buku_id) == $buku->id) ? 'selected' : '' }}>
                                {{ $buku->judul }} ({{ $buku->penulis }})
                            </option>
                        @endforeach
                    </select>
                    @error('buku_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rating -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Rating
                    </label>
                    <div class="rating p-2 bg-gray-50 rounded-lg inline-flex">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" 
                                   id="star{{ $i }}" 
                                   name="ranting" 
                                   value="{{ $i }}" 
                                   {{ (old('ranting', $ulasanbuku->ranting) == $i) ? 'checked' : '' }} />
                            <label for="star{{ $i }}">
                                <i class="fas fa-star"></i>
                            </label>
                        @endfor
                    </div>
                    @error('ranting')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ulasan -->
                <div>
                    <label for="ulasan" class="block text-sm font-medium text-gray-700 mb-2">
                        Ulasan
                    </label>
                    <textarea id="ulasan" 
                              name="ulasan" 
                              rows="5" 
                              class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('ulasan') border-red-500 @enderror"
                              required>{{ old('ulasan', $ulasanbuku->ulasan) }}</textarea>
                    @error('ulasan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Information Box -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                        <div class="text-sm">
                            <p class="font-medium text-blue-800">Informasi Ulasan</p>
                            <p class="text-gray-600 mt-1">Ulasan ini dibuat pada: {{ $ulasanbuku->created_at->format('d/m/Y H:i') }}</p>
                            @if($ulasanbuku->created_at != $ulasanbuku->updated_at)
                                <p class="text-gray-600">Terakhir diperbarui: {{ $ulasanbuku->updated_at->format('d/m/Y H:i') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-3">
                    <button type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Perbarui Ulasan
                    </button>
                    <a href="{{ route('ulasanbuku.show', $ulasanbuku->id) }}"
                       class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>

        <!-- ... rest of the content remains the same ... -->
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

        // Initialize Tom Select
        new TomSelect('#buku_id', {
            create: false,
            sortField: {
                field: 'text',
                direction: 'asc'
            }
        });

        // ... rest of your existing scripts ...
    </script>
</body>
</html>