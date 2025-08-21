<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-50 to-indigo-100">
    <div class="w-full max-w-md p-8 bg-white rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            <i class="fas fa-user-plus mr-2 text-blue-600"></i>Registrasi Akun Baru
        </h2>
        
        <!-- Pesan sukses -->
        @if (session('success'))
            <div class="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Pesan error -->
        @if ($errors->any())
            <div class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                <div class="flex items-center mb-1">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span class="font-medium">Mohon perbaiki kesalahan berikut:</span>
                </div>
                <ul class="ml-6 list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Registrasi -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            
            <!-- Nama Lengkap -->
            <div>
                <label for="nama_lengkap" class="block mb-1 text-sm font-medium text-gray-700">
                    <i class="fas fa-user text-gray-400 mr-1"></i>Nama Lengkap
                </label>
                <input id="nama_lengkap" type="text" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_lengkap') border-red-500 @enderror" 
                       name="nama_lengkap" 
                       value="{{ old('nama_lengkap') }}" required>
                @error('nama_lengkap')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block mb-1 text-sm font-medium text-gray-700">
                    <i class="fas fa-envelope text-gray-400 mr-1"></i>Email
                </label>
                <input id="email" type="email" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" 
                       name="email" 
                       value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Alamat -->
            <div>
                <label for="alamat" class="block mb-1 text-sm font-medium text-gray-700">
                    <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>Alamat
                </label>
                <textarea id="alamat" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat') border-red-500 @enderror" 
                          name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block mb-1 text-sm font-medium text-gray-700">
                    <i class="fas fa-lock text-gray-400 mr-1"></i>Password
                </label>
                <div class="relative">
                    <input id="password" type="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" 
                           name="password" required>
                    <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password-confirm" class="block mb-1 text-sm font-medium text-gray-700">
                    <i class="fas fa-lock text-gray-400 mr-1"></i>Konfirmasi Password
                </label>
                <div class="relative">
                    <input id="password-confirm" type="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           name="password_confirmation" required>
                    <button type="button" onclick="togglePassword('password-confirm')" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Tombol Daftar -->
            <button type="submit"
                    class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 flex items-center justify-center font-medium">
                <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
            </button>
        </form>

        <!-- Link Login -->
        <p class="text-center mt-5 text-gray-600">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">
                <i class="fas fa-sign-in-alt mr-1"></i>Login
            </a>
        </p>
    </div>
    
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>