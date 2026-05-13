<!DOCTYPE html>
<html lang="id" class="h-full overflow-hidden">
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
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        body {
            touch-action: none;
            -webkit-overflow-scrolling: none;
            overflow: hidden;
            position: fixed;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body class="h-full font-sans text-slate-900 bg-[#021024]">
    <div class="relative h-screen flex items-center justify-center p-4 sm:p-6 bg-[#021024] overflow-hidden">
        <div class="absolute top-0 right-0 -mt-24 -mr-24 w-96 h-96 bg-primary-600/10 rounded-full blur-[100px] opacity-40"></div>
        <div class="absolute bottom-0 left-0 -mb-24 -ml-24 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px] opacity-20"></div>
        
        <div class="w-full max-w-md relative z-10 animate-in fade-in zoom-in duration-700 py-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Lupa Password?</h1>
                <p class="text-slate-300 font-medium mt-2">Masukkan email Anda. Admin akan membantu mengatur ulang password Anda.</p>
            </div>

            <div class="glass-card rounded-[2rem] shadow-2xl p-8 sm:p-10">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3">
                        <i class="fas fa-check-circle text-emerald-500"></i>
                        <p class="text-sm font-bold text-emerald-700">{{ session('success') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-rose-500"></i>
                        <p class="text-sm font-bold text-rose-700">{{ $errors->first() }}</p>
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-bold text-slate-700 mb-2 ml-1">Email Address</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-slate-400 group-focus-within:text-primary-500"></i>
                            </div>
                            <input type="email" id="email" name="email" required autofocus
                                class="block w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all"
                                placeholder="name@example.com">
                        </div>
                    </div>

                    <button type="submit" 
                        class="w-full py-4 px-6 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-200 flex items-center justify-center gap-3 transform transition-all hover:-translate-y-1 active:scale-95">
                        <span>Kirim Permintaan ke Admin</span>
                        <i class="fas fa-paper-plane text-sm"></i>
                    </button>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-sm font-bold text-primary-600 hover:text-primary-700 flex items-center justify-center gap-2">
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
