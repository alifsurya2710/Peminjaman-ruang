<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Lupa Password - Ruang Nekat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .glass-card {
            background: rgba(10, 25, 47, 0.65);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(56, 189, 248, 0.15);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.05);
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

        @keyframes pulse-slow {
            0%, 100% {
                transform: scale(1) translate(0px, 0px);
                opacity: 0.3;
            }
            50% {
                transform: scale(1.1) translate(15px, -15px);
                opacity: 0.55;
            }
        }

        .animate-pulse-slow {
            animation: pulse-slow 12s infinite ease-in-out;
        }
    </style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
</head>
<body class="h-full font-sans text-slate-200 bg-[#020a18] antialiased">
    <div class="relative min-h-screen flex items-center justify-center p-4 sm:p-6 bg-[#020a18] overflow-hidden">
        <!-- Beautiful Background Image with Overlay and Zoom Animation (Optimized for mobile performance & visibility) -->
        <div class="absolute inset-0 bg-cover bg-center animate-subtle-zoom opacity-70 transition-all duration-1000" style="background-image: url('{{ asset('images/bg-login.jpg') }}'); z-index: 1;"></div>
        <div class="absolute inset-0" style="z-index: 2; background: linear-gradient(to top right, rgba(2, 10, 24, 0.8) 0%, rgba(2, 10, 24, 0.5) 50%, rgba(10, 25, 47, 0.4) 100%);"></div>

        <!-- Background Decorations (Pulsing glowing cyber blobs) -->
        <div class="absolute top-0 right-0 -mt-24 -mr-24 w-96 h-96 bg-cyan-500/15 rounded-full blur-[120px] animate-pulse-slow" style="z-index: 3;"></div>
        <div class="absolute bottom-0 left-0 -mb-24 -ml-24 w-96 h-96 bg-blue-600/15 rounded-full blur-[120px] animate-pulse-slow" style="animation-delay: 4s; z-index: 3;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/5 rounded-full blur-[150px] pointer-events-none" style="z-index: 3;"></div>
        
        <div class="w-full max-w-md relative animate-in fade-in zoom-in duration-700 py-8" style="z-index: 10;">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-32 h-32 rounded-[2.5rem] bg-white/5 backdrop-blur-2xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] mb-6 transform hover:scale-110 hover:rotate-3 transition-all duration-500 border border-white/10 relative group">
                    <!-- Glow effect -->
                    <div class="absolute inset-0 rounded-[2.5rem] bg-cyan-500/10 blur-2xl group-hover:bg-cyan-500/25 transition-colors duration-500"></div>
                    
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-24 h-24 object-contain relative z-10 drop-shadow-[0_10px_10px_rgba(0,0,0,0.5)]">
                </div>

                <h1 class="text-3xl font-extrabold text-white tracking-tight drop-shadow-md">Lupa Password?</h1>
                <p class="text-cyan-400/80 font-medium mt-2 tracking-wide">Masukkan email Anda. Admin akan membantu mengatur ulang password Anda.</p>
            </div>

            <div class="glass-card rounded-[2rem] p-8 sm:p-10">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-950/40 border border-emerald-500/30 rounded-2xl flex items-center gap-3 animate-in slide-in-from-top-2">
                        <i class="fas fa-check-circle text-emerald-400"></i>
                        <p class="text-sm font-semibold text-emerald-200">{{ session('success') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-rose-950/40 border border-rose-500/30 rounded-2xl flex items-center gap-3 animate-in slide-in-from-top-2">
                        <i class="fas fa-exclamation-circle text-rose-400"></i>
                        <p class="text-sm font-semibold text-rose-200">{{ $errors->first() }}</p>
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-300 mb-2 ml-1">Alamat Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-slate-500 group-focus-within:text-cyan-400 transition-colors"></i>
                            </div>
                            <input type="email" id="email" name="email" required autofocus
                                class="block w-full pl-11 pr-4 py-4 bg-slate-950/40 border border-slate-700/50 rounded-2xl text-white font-medium placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-400 transition-all duration-300"
                                placeholder="name@example.com">
                        </div>
                    </div>

                    <button type="submit" 
                        class="w-full py-4 px-6 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white font-bold rounded-2xl shadow-[0_0_20px_rgba(37,99,235,0.2)] hover:shadow-[0_0_25px_rgba(6,182,212,0.35)] flex items-center justify-center gap-3 transform transition-all duration-300 hover:-translate-y-0.5 active:scale-95 cursor-pointer">
                        <span>Kirim Permintaan ke Admin</span>
                        <i class="fas fa-paper-plane text-sm"></i>
                    </button>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-cyan-400 hover:text-cyan-300 transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left text-xs"></i>
                            Kembali ke Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
