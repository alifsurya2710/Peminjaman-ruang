<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans text-slate-900 bg-slate-50 flex items-center justify-center p-6">
    <div class="max-w-md w-full text-center space-y-8 animate-in fade-in zoom-in duration-700">
        <div class="relative inline-block">
            <div class="absolute inset-0 bg-rose-200 rounded-full blur-3xl opacity-50 scale-150"></div>
            <h1 class="relative text-9xl font-black text-rose-600 tracking-tighter">403</h1>
        </div>
        
        <div class="space-y-3 relative z-10">
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Terlarang!</h2>
            <p class="text-slate-500 font-medium">Maaf, Anda tidak memiliki hak akses yang cukup untuk membuka area ini.</p>
        </div>

        <div class="pt-6 relative z-10">
            <a href="/dashboard" class="inline-flex items-center gap-3 px-8 py-4 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-2xl shadow-lg shadow-rose-200 transition-all duration-300 hover:-translate-y-1 active:scale-95">
                <i class="fas fa-lock text-sm"></i>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </div>
</body>
</html>
