<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ruang Nekat SMKN 1 Katapang</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    
    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full font-sans text-slate-900 bg-[#021024]">
    <div class="relative min-h-screen flex items-center justify-center p-4 sm:p-6 bg-[#021024]">
        <!-- Background Decorations (Adjusted for deeper theme) -->
        <div class="absolute top-0 right-0 -mt-24 -mr-24 w-96 h-96 bg-primary-600/10 rounded-full blur-[100px] opacity-40"></div>
        <div class="absolute bottom-0 left-0 -mb-24 -ml-24 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px] opacity-20"></div>
        
        <div class="w-full max-w-md relative z-10 animate-in fade-in zoom-in duration-700 py-8">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-32 h-32 rounded-[2.5rem] bg-white/10 backdrop-blur-2xl shadow-[0_20px_50px_rgba(0,0,0,0.3)] mb-6 transform hover:scale-110 hover:rotate-3 transition-all duration-500 border border-white/20 relative group">
                    <!-- Glow effect -->
                    <div class="absolute inset-0 rounded-[2.5rem] bg-primary-500/20 blur-2xl group-hover:bg-primary-500/40 transition-colors duration-500"></div>
                    
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-24 h-24 object-contain relative z-10 drop-shadow-2xl">
                </div>

                <h1 class="text-3xl font-extrabold text-white tracking-tight">Ruang Nekat</h1>
                <p class="text-slate-300 font-medium mt-1">Sistem Peminjaman Ruangan SMKN 1 Katapang</p>
            </div>

            <!-- Login Card -->
            <div class="glass-card rounded-[2rem] shadow-2xl shadow-black/40 p-8 sm:p-10 bg-white/95">
                @if($errors->any())
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-center gap-3 animate-in slide-in-from-top-2">
                        <i class="fas fa-exclamation-circle text-rose-500"></i>
                        <p class="text-sm font-bold text-rose-700">{{ $errors->first() }}</p>
                    </div>
                @endif

                <form action="/login" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-bold text-slate-700 mb-2 ml-1">Email Address</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-slate-400 group-focus-within:text-primary-500 transition-colors"></i>
                            </div>
                            <input type="email" id="email" name="email" required autofocus
                                class="block w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all duration-200"
                                placeholder="name@example.com">
                        </div>
                    </div>

                    <div x-data="{ show: false }">
                        <div class="flex justify-between items-center mb-2 ml-1">
                            <label for="password" class="block text-sm font-bold text-slate-700">Password</label>
                            <a href="{{ route('password.request') }}" class="text-xs font-bold text-primary-600 hover:text-primary-700 transition-colors">Lupa password?</a>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-slate-400 group-focus-within:text-primary-500 transition-colors"></i>
                            </div>
                            <input :type="show ? 'text' : 'password'" id="password" name="password" required
                                class="block w-full pl-11 pr-12 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all duration-200"
                                placeholder="••••••••">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-primary-600 transition-all duration-200 z-10 focus:outline-none">
                                <i class="fas fa-fw" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" 
                        class="w-full py-4 px-6 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-200 flex items-center justify-center gap-3 transform transition-all duration-300 hover:-translate-y-1 active:scale-95">
                        <span>Login</span>
                        <i class="fas fa-arrow-right text-sm"></i>
                    </button>
                </form>
            </div>

            <!-- Footer Link -->
            <div class="text-center mt-8 space-y-1">
                <p class="text-slate-400 text-sm font-medium">
                    &copy; {{ date('Y') }} SMKN 1 Katapang. All rights reserved.
                </p>
                <p class="text-slate-400 text-xs font-semibold">
                    Development by <a href="https://www.instagram.com/dream.inalgorithms/" target="_blank" class="text-primary-400 hover:text-primary-300 transition-colors">Alumni XII-RPL 1 Angkatan 2026</a>
                </p>
            </div>


        </div>
    </div>
</body>
</html>