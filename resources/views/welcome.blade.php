<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Nekat - SMKN 1 Katapang</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <style>
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .hero-gradient {
            background: radial-gradient(circle at top right, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at bottom left, rgba(59, 130, 246, 0.05) 0%, transparent 50%);
        }

        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(37, 99, 235, 0.1) 100%);
            filter: blur(80px);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            z-index: -1;
            animation: blob-animate 20s infinite alternate;
        }

        @keyframes blob-animate {
            0% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; transform: translate(0, 0) scale(1); }
            33% { border-radius: 50% 50% 30% 70% / 50% 70% 30% 50%; transform: translate(100px, 50px) scale(1.1); }
            66% { border-radius: 70% 30% 50% 50% / 30% 30% 70% 70%; transform: translate(-50px, 100px) scale(0.9); }
            100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; transform: translate(0, 0) scale(1); }
        }
    </style>
</head>
<body class="h-full font-sans text-slate-900 bg-white selection:bg-primary-100 selection:text-primary-700 overflow-x-hidden">
    <!-- Blobs -->
    <div class="blob top-[-200px] right-[-100px]"></div>
    <div class="blob bottom-[-200px] left-[-100px] opacity-50"></div>

    <!-- Navigation -->
    <nav class="fixed top-0 inset-x-0 z-50 p-4 sm:p-6">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-8 py-3 sm:py-4 glass rounded-[1.5rem] sm:rounded-[2rem] shadow-xl shadow-slate-200/50">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center shadow-lg shadow-primary-200/20 p-1.5">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <div class="hidden sm:flex flex-col">
                    <span class="text-lg font-bold text-slate-800 leading-tight">Ruang Nekat</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SMKN 1 Katapang</span>
                </div>
            </div>

            <div class="flex items-center gap-6">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl shadow-lg transition-all active:scale-95">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-primary-600 transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('login') }}" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl shadow-lg shadow-primary-200 transition-all active:scale-95">
                            Mulai Sekarang
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="relative pt-40 pb-20 px-6 overflow-hidden">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-16">
            <!-- Left Content -->
            <div class="flex-1 text-center lg:text-left space-y-8 animate-in fade-in slide-in-from-left-8 duration-1000">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-50 border border-primary-100 text-primary-600 text-xs font-bold uppercase tracking-widest">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-600"></span>
                    </span>
                    Digitalisasi Peminjaman Ruangan
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold text-slate-900 leading-[1.1] tracking-tight">
                    Kelola Ruangan Sekolah Jadi <span class="text-primary-600 italic">Lebih Mudah.</span>
                </h1>
                
                <p class="text-xl text-slate-500 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-medium">
                    Sistem informasi peminjaman ruangan SMKN 1 Katapang yang modern, cepat, dan transparan. Pantau ketersediaan ruangan secara real-time.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-10 py-5 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-2xl shadow-primary-200 transition-all hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3">
                        <span>Cek Ketersediaan</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="#features" class="w-full sm:w-auto px-10 py-5 bg-white border border-slate-200 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 transition-all flex items-center justify-center gap-3">
                        Lihat Fitur
                    </a>
                </div>

                <div class="flex items-center justify-center lg:justify-start gap-8 pt-4">
                    <div class="flex flex-col">
                        <span class="text-3xl font-bold text-slate-800 tracking-tight">50+</span>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Ruangan</span>
                    </div>
                    <div class="w-px h-10 bg-slate-100"></div>
                    <div class="flex flex-col">
                        <span class="text-3xl font-bold text-slate-800 tracking-tight">100%</span>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Transparan</span>
                    </div>
                    <div class="w-px h-10 bg-slate-100"></div>
                    <div class="flex flex-col">
                        <span class="text-3xl font-bold text-slate-800 tracking-tight">Real-time</span>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Update</span>
                    </div>
                </div>
            </div>

            <!-- Right Content / Image -->
            <div class="flex-1 relative animate-in fade-in zoom-in duration-1000 delay-200">
                <div class="relative z-10 p-4 bg-white/50 glass rounded-[3rem] shadow-2xl overflow-hidden group">
                    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=1000" 
                         alt="SMKN 1 Katapang" 
                         class="rounded-[2.5rem] w-full h-auto object-cover transform transition-transform duration-700 group-hover:scale-105">
                    
                    <!-- Floating Card -->
                    <div class="absolute bottom-4 left-4 right-4 sm:bottom-8 sm:left-8 sm:right-8 glass p-4 sm:p-6 rounded-2xl sm:rounded-3xl shadow-xl animate-bounce-slow">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ruangan Tersedia</p>
                                <p class="text-lg font-bold text-slate-800 tracking-tight">Lab RPL 1 - Tersedia</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Decorative elements -->
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-yellow-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse delay-700"></div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-12 border-t border-slate-100 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-4">
                <div class="w-8 h-8 rounded-lg bg-primary-600 flex items-center justify-center text-white text-xs">
                    <i class="fas fa-building"></i>
                </div>
                <p class="text-sm font-bold text-slate-800">Ruang Nekat SMKN 1 Katapang</p>
            </div>
            
            <div class="flex gap-6 text-sm font-medium text-slate-500">
                <a href="#" class="hover:text-primary-600 transition-colors">Tentang</a>
                <a href="#" class="hover:text-primary-600 transition-colors">Panduan</a>
                <a href="#" class="hover:text-primary-600 transition-colors">Kontak</a>
            </div>

            <p class="text-xs text-slate-400 font-medium">
                &copy; {{ date('Y') }} SMKN 1 Katapang. Designed with Passion.
            </p>
        </div>
    </footer>

    <style>
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(-5px); }
            50% { transform: translateY(5px); }
        }
        .animate-bounce-slow {
            animation: bounce-slow 4s ease-in-out infinite;
        }
    </style>
</body>
</html>
