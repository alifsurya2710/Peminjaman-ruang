<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#021024">
    <title>@yield('title') - Ruang Nekat SMKN 1 Katapang</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Instrument+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @php
        $primaryColor = '#3b82f6'; // Default Blue
        $primaryHover = '#2563eb';
        $primaryLight = '#eff6ff';
        $primaryGlow = 'rgba(59, 130, 246, 0.2)';

        $sidebarBg = 'bg-white';
        $sidebarText = 'text-slate-600';
        $sidebarIcon = 'text-slate-400';
        $sidebarBorder = 'border-slate-100';
        $logoBg = 'bg-white';
        $navHeader = 'text-slate-400';

        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                $sidebarBg = 'bg-slate-900';
                $sidebarText = 'text-slate-300';
                $sidebarIcon = 'text-slate-500';
                $sidebarBorder = 'border-slate-800';
                $logoBg = 'bg-slate-800';
                $navHeader = 'text-slate-500';
            } elseif (Auth::user()->role === 'sarpras') {
                $sidebarBg = 'bg-blue-900';
                $sidebarText = 'text-blue-100';
                $sidebarIcon = 'text-blue-300';
                $sidebarBorder = 'border-blue-800';
                $logoBg = 'bg-blue-800';
                $navHeader = 'text-blue-400';
            }
            
            if (Auth::user()->role === 'toolman') {
                $categoryName = Auth::user()->category->name ?? '';
                
                // Default Toolman (Blue)
                $sidebarBg = 'bg-primary-600';
                $sidebarText = 'text-white';
                $sidebarIcon = 'text-white/80';
                $sidebarBorder = 'border-white/10';
                $logoBg = 'bg-white/20';
                $navHeader = 'text-white/60';

                if (str_contains($categoryName, 'Elektronika') || str_contains($categoryName, 'Mekatronika')) {
                    $primaryColor = '#eab308'; // Yellow
                    $primaryHover = '#ca8a04';
                    $primaryLight = '#fefce8';
                    $primaryGlow = 'rgba(234, 179, 8, 0.2)';
                    $sidebarBg = 'bg-[#eab308]';
                } elseif (str_contains($categoryName, 'Mesin')) {
                    $primaryColor = '#ef4444'; // Red
                    $primaryHover = '#dc2626';
                    $primaryLight = '#fef2f2';
                    $primaryGlow = 'rgba(239, 68, 68, 0.2)';
                    $sidebarBg = 'bg-[#ef4444]';
                } elseif (str_contains($categoryName, 'Otomotif')) {
                    $primaryColor = '#f97316'; // Orange
                    $primaryHover = '#ea580c';
                    $primaryLight = '#fff7ed';
                    $primaryGlow = 'rgba(249, 115, 22, 0.2)';
                    $sidebarBg = 'bg-[#f97316]';
                } elseif (str_contains($categoryName, 'Tekstil')) {
                    $primaryColor = '#22c55e'; // Green
                    $primaryHover = '#16a34a';
                    $primaryLight = '#f0fdf4';
                    $primaryGlow = 'rgba(34, 197, 94, 0.2)';
                    $sidebarBg = 'bg-[#22c55e]';
                } elseif (str_contains($categoryName, 'TJKT')) {
                    $primaryColor = '#1e3a8a'; // Dark Blue
                    $primaryHover = '#172554';
                    $primaryLight = '#eff6ff';
                    $primaryGlow = 'rgba(30, 58, 138, 0.2)';
                    $sidebarBg = 'bg-[#1e3a8a]';
                } elseif (str_contains($categoryName, 'RPL') || str_contains($categoryName, 'PPLG')) {
                    $primaryColor = '#0ea5e9'; // Sky Blue
                    $primaryHover = '#0284c7';
                    $primaryLight = '#f0f9ff';
                    $primaryGlow = 'rgba(14, 165, 233, 0.2)';
                    $sidebarBg = 'bg-[#0ea5e9]';
                } elseif (str_contains($categoryName, 'BP')) {
                    $primaryColor = '#64748b'; // Gray
                    $primaryHover = '#475569';
                    $primaryLight = '#f8fafc';
                    $primaryGlow = 'rgba(100, 116, 139, 0.2)';
                    $sidebarBg = 'bg-[#64748b]';
                }
            }

        }
    @endphp

    <style>
        :root {
            --color-primary-50: {{ $primaryLight }};
            --color-primary-500: {{ $primaryColor }};
            --color-primary-600: {{ $primaryHover }};
            --color-primary-200: {{ $primaryGlow }}; /* Used for shadows/glows */
        }
    </style>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>
        [x-cloak] { display: none !important; }
        
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .sidebar-active {
            @apply bg-primary-600 text-white shadow-lg shadow-primary-200;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            @apply bg-slate-200 rounded-full;
        }
        ::-webkit-scrollbar-thumb:hover {
            @apply bg-slate-300;
        }
    </style>
</head>
<body class="h-full font-sans text-slate-900 overflow-x-hidden">
    <div x-data="{ sidebarOpen: false }" class="relative min-h-screen flex">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-md z-40 lg:hidden">
        </div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 w-72 {{ $sidebarBg }} border-r {{ $sidebarBorder }} z-50 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 lg:flex-shrink-0 shadow-xl lg:shadow-none">
            
            <!-- Sidebar Header -->
            <div class="h-20 flex items-center px-6 border-b {{ $sidebarBorder }}">
                <a href="/dashboard" class="flex items-center gap-3 group">
                    <div class="w-14 h-14 rounded-2xl {{ $logoBg }} flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-2 transition-all duration-500 border {{ $sidebarBorder }} relative overflow-hidden">
                        <!-- Subtle inner glow -->
                        <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain relative z-10">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-extrabold text-white leading-tight tracking-tight">Ruang Nekat</span>
                        <span class="text-[10px] font-bold text-white/60 uppercase tracking-widest">SMKN 1 Katapang</span>
                    </div>
                </a>
            </div>


            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <p class="px-4 text-[10px] font-bold {{ $navHeader }} uppercase tracking-widest mb-4">Menu Utama</p>
                
                <a href="/dashboard" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('dashboard') ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : $sidebarText . ' hover:bg-white/5' }}">
                    <i class="fas fa-chart-line w-5 text-center {{ request()->is('dashboard') ? 'text-white' : $sidebarIcon . ' group-hover:text-primary-500' }}"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="/floor-plans" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('floor-plans*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : $sidebarText . ' hover:bg-white/5' }}">
                    <i class="fas fa-map w-5 text-center {{ request()->is('floor-plans*') ? 'text-white' : $sidebarIcon . ' group-hover:text-primary-500' }}"></i>
                    <span class="font-medium">Denah</span>
                </a>

                @if(Auth::user()->isAdmin())
                    <a href="/users" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('users*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : $sidebarText . ' hover:bg-white/5' }}">
                        <i class="fas fa-users w-5 text-center {{ request()->is('users*') ? 'text-white' : $sidebarIcon . ' group-hover:text-primary-500' }}"></i>
                        <span class="font-medium">Kelola User</span>
                    </a>

                    @php
                        $unreadNotificationsCount = Auth::user()->unreadNotifications->count();
                    @endphp
                    <a href="{{ route('notifications.index') }}" 
                       class="flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('notifications*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : $sidebarText . ' hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-bell w-5 text-center {{ request()->is('notifications*') ? 'text-white' : $sidebarIcon . ' group-hover:text-primary-500' }}"></i>
                            <span class="font-medium">Notifikasi</span>
                        </div>
                        @if($unreadNotificationsCount > 0)
                            <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                                {{ $unreadNotificationsCount }}
                            </span>
                        @endif
                    </a>
                @endif

                @if(Auth::user()->isAdmin() || Auth::user()->isSarpras() || Auth::user()->isToolman())
                    <p class="px-4 text-[10px] font-bold {{ $navHeader }} uppercase tracking-widest mt-8 mb-4">Manajemen</p>
                    
                    <a href="/rooms" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('rooms*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : $sidebarText . ' hover:bg-white/5' }}">
                        <i class="fas fa-door-open w-5 text-center {{ request()->is('rooms*') ? 'text-white' : $sidebarIcon . ' group-hover:text-primary-500' }}"></i>
                        <span class="font-medium">Ruangan</span>
                    </a>

                    <a href="/borrowers" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('borrowers*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : $sidebarText . ' hover:bg-white/5' }}">
                        <i class="fas fa-handshake w-5 text-center {{ request()->is('borrowers*') ? 'text-white' : $sidebarIcon . ' group-hover:text-primary-500' }}"></i>
                        <span class="font-medium">Peminjam</span>
                    </a>

                    <a href="/schedules" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('schedules*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : $sidebarText . ' hover:bg-white/5' }}">
                        <i class="fas fa-calendar w-5 text-center {{ request()->is('schedules*') ? 'text-white' : $sidebarIcon . ' group-hover:text-primary-500' }}"></i>
                        <span class="font-medium">Jadwal</span>
                    </a>

                    <a href="/reports" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('reports*') ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : $sidebarText . ' hover:bg-white/5' }}">
                        <i class="fas fa-file-pdf w-5 text-center {{ request()->is('reports*') ? 'text-white' : $sidebarIcon . ' group-hover:text-primary-500' }}"></i>
                        <span class="font-medium">Laporan</span>
                    </a>
                @endif
            </nav>


            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-slate-100">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-all duration-200 group">
                        <i class="fas fa-sign-out-alt w-5 text-center group-hover:scale-110 transition-transform"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Header -->
            <header class="h-20 {{ $sidebarBg }} sticky top-0 z-30 flex items-center justify-between px-4 sm:px-6 border-b {{ $sidebarBorder }} shadow-sm">
                <div class="flex items-center gap-3 sm:gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 {{ str_contains($sidebarBg, 'white') ? 'text-slate-600 hover:bg-slate-100' : 'text-white/80 hover:bg-white/10' }} rounded-lg transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <!-- Mobile Logo -->
                    <div class="lg:hidden flex items-center gap-2 px-3 py-1.5 rounded-2xl {{ str_contains($sidebarBg, 'white') ? 'bg-slate-100 border-slate-200' : 'bg-white/10 border-white/10 shadow-inner' }} border">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                        <span class="{{ str_contains($sidebarBg, 'white') ? 'text-slate-900' : 'text-white' }} font-extrabold text-sm sm:text-base tracking-tight">Ruang Nekat</span>
                    </div>
                    <h2 class="text-xl font-bold {{ str_contains($sidebarBg, 'white') ? 'text-slate-800' : 'text-white' }} lg:block hidden">@yield('title')</h2>
                </div>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 sm:gap-4 group hover:bg-white/5 p-1.5 sm:p-2 rounded-2xl transition-all duration-300">
                    <div class="hidden sm:flex flex-col items-end mr-2">
                        <span class="text-sm font-bold {{ str_contains($sidebarBg, 'white') ? 'text-slate-800 group-hover:text-primary-600' : 'text-white group-hover:text-white/80' }} transition-colors">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] font-extrabold {{ str_contains($sidebarBg, 'white') ? 'text-slate-400' : 'text-white/60' }} uppercase tracking-widest">{{ Auth::user()->role }}</span>
                    </div>
                    <div class="relative">
                        <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-full bg-white/10 flex items-center justify-center border-2 border-white/20 shadow-lg overflow-hidden group-hover:ring-4 ring-white/10 transition-all duration-300">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                @php
                                    $roleColor = match(Auth::user()->role) {
                                        'admin' => 'f43f5e',
                                        'sarpras' => '3b82f6',
                                        'toolman' => '0ea5e9',
                                        default => '64748b'
                                    };
                                @endphp
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background={{ $roleColor }}&color=fff" alt="Avatar">
                            @endif
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-3 h-3 sm:w-4 sm:h-4 bg-emerald-500 border-2 border-white rounded-full shadow-sm"></div>
                    </div>
                </a>

            </header>


            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    
                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                                <span class="font-bold text-red-800 text-sm">Terjadi Kesalahan!</span>
                            </div>
                            <ul class="list-disc list-inside text-xs text-red-700 space-y-1 ml-6">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl shadow-sm flex items-center gap-3">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                            <span class="font-medium text-emerald-800 text-sm">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-xl shadow-sm flex items-center gap-3">
                            <i class="fas fa-times-circle text-rose-500"></i>
                            <span class="font-medium text-rose-800 text-sm">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="animate-in fade-in slide-in-from-bottom-4 duration-700">
                        @yield('content')
                    </div>
                </div>
            </main>
    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
