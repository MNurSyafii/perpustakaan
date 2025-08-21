<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-50 to-indigo-100">
    <div class="w-full max-w-md p-8 bg-white rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            <i class="fas fa-sign-in-alt mr-2 text-blue-600"></i>Login
        </h2>
        
        <!-- Pesan Sukses -->
        @if (session('success'))
            <div class="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Pesan Error -->
        @if ($errors->any())
            <div class="p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ $errors->first() }}
            </div>
        @endif
        
        <!-- Form Login -->
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            
            <!-- Email -->
            <div>
                <label for="email" class="block mb-1 text-sm font-medium text-gray-700">
                    <i class="fas fa-envelope text-gray-400 mr-1"></i>Email
                </label>
                <input type="email" id="email" name="email" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <!-- Password -->
            <div>
                <label for="password" class="block mb-1 text-sm font-medium text-gray-700">
                    <i class="fas fa-lock text-gray-400 mr-1"></i>Password
                </label>
                <div class="relative">
                    <input type="password" id="password" name="password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="button" onclick="togglePassword()" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <!-- Remember Me -->
            <div class="flex items-center">
                <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">
                    Ingat saya
                </label>
            </div>
            
            <!-- Tombol Login -->
            <button type="submit"
                class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 flex items-center justify-center font-medium">
                <i class="fas fa-sign-in-alt mr-2"></i>Login
            </button>
        </form>
        
        <!-- Link Daftar -->
        <div class="mt-6 space-y-4">
            <div class="flex items-center justify-center">
                <div class="h-px bg-gray-300 w-1/3"></div>
                <p class="mx-4 text-sm text-gray-500">atau</p>
                <div class="h-px bg-gray-300 w-1/3"></div>
            </div>
            
            <p class="text-center text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">
                    <i class="fas fa-user-plus mr-1"></i>Daftar Sekarang
                </a>
            </p>
    
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.querySelector('.fa-eye, .fa-eye-slash');
            
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