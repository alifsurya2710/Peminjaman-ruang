<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Ruang Nekat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
 
        @keyframes subtle-zoom {
            0% {
                transform: scale(1) translateZ(0);
            }
            100% {
                transform: scale(1.08) translateZ(0);
            }
        }
        
        .animate-subtle-zoom {
            animation: subtle-zoom 30s infinite alternate ease-in-out;
            will-change: transform;
            backface-visibility: hidden;
            perspective: 1000px;
        }
    </style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
</head>
<body class="h-full font-sans text-slate-900 bg-[#021024]">
    <div class="relative min-h-screen flex items-center justify-center p-4 sm:p-6 bg-[#021024] overflow-hidden">
        <!-- Beautiful Background Image with Overlay and Zoom Animation -->
        <div class="absolute inset-0 bg-cover bg-center animate-subtle-zoom opacity-50 transition-all duration-1000" style="background-image: url('{{ asset('images/bg-login.jpg') }}'); z-index: 1;"></div>
        <div class="absolute inset-0" style="z-index: 2; background: linear-gradient(to top right, #021024 0%, rgba(2, 16, 36, 0.9) 50%, rgba(11, 36, 71, 0.7) 100%);"></div>

        <!-- Background Decorations (Adjusted for deeper theme) -->
        <div class="absolute top-0 right-0 -mt-24 -mr-24 w-96 h-96 bg-primary-600/20 rounded-full blur-[120px] opacity-40" style="z-index: 3;"></div>
        <div class="absolute bottom-0 left-0 -mb-24 -ml-24 w-96 h-96 bg-blue-600/20 rounded-full blur-[120px] opacity-30" style="z-index: 3;"></div>
        
        <div class="w-full max-w-md relative animate-in fade-in zoom-in duration-700 py-8" style="z-index: 10;">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-32 h-32 rounded-[2.5rem] bg-white/10 backdrop-blur-2xl shadow-[0_20px_50px_rgba(0,0,0,0.3)] mb-6 transform hover:scale-110 hover:rotate-3 transition-all duration-500 border border-white/20 relative group">
                    <!-- Glow effect -->
                    <div class="absolute inset-0 rounded-[2.5rem] bg-primary-500/20 blur-2xl group-hover:bg-primary-500/40 transition-colors duration-500"></div>
                    
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-24 h-24 object-contain relative z-10 drop-shadow-2xl">
                </div>

                <h1 class="text-3xl font-extrabold text-white tracking-tight">Atur Ulang Password</h1>
                <p class="text-slate-300 font-medium mt-2">Silakan masukkan password baru Anda.</p>
            </div>

            <div class="glass-card rounded-[2rem] shadow-2xl p-8 sm:p-10">
                <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ request()->email }}">

                    <div>
                        <label for="password" class="block text-sm font-bold text-slate-700 mb-2 ml-1">Password Baru</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-slate-400 group-focus-within:text-primary-500"></i>
                            </div>
                            <input type="password" id="password" name="password" required autofocus
                                class="block w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-2 ml-1">Konfirmasi Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-check-double text-slate-400 group-focus-within:text-primary-500"></i>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="block w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" 
                        class="w-full py-4 px-6 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-200 flex items-center justify-center gap-3 transform transition-all hover:-translate-y-1 active:scale-95">
                        <span>Perbarui Password</span>
                        <i class="fas fa-save text-sm"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
