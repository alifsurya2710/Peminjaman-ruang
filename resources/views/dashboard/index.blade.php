@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Dashboard Header -->
    <div class="relative overflow-hidden rounded-[2rem] sm:rounded-[2.5rem] bg-[#0f172a] p-6 sm:p-8 lg:p-10 mb-6 sm:mb-8 shadow-2xl shadow-slate-900/20 border border-white/5">
        <div class="relative z-10 max-w-4xl mx-auto">
            <!-- Text Container with Image Background -->
            <div class="relative p-6 sm:p-8 md:p-12 rounded-[1.5rem] sm:rounded-[2rem] overflow-hidden border border-white/5 shadow-inner group">
                <!-- The Department Logos as Background (Made clearer) -->
                <div class="absolute inset-0 z-0">
                    <img src="{{ asset('images/departments.png') }}" alt="" class="w-full h-full object-cover opacity-60 group-hover:opacity-80 transition-opacity duration-700">
                    <div class="absolute inset-0 bg-black/30"></div>
                </div>

                <!-- Content on top (Made more transparent) -->
                <div class="relative z-10 text-center opacity-80 group-hover:opacity-100 transition-opacity duration-500">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-white/70 text-[10px] font-bold uppercase tracking-[0.2em] mb-6">
                        Sistem Manajemen Digital
                    </div>
                    
                    <h1 class="text-2xl sm:text-3xl lg:text-5xl font-black text-white/90 mb-3 sm:mb-4 tracking-tight leading-tight">
                        Selamat Datang, <span class="bg-clip-text text-transparent bg-gradient-to-r from-primary-400/80 to-blue-400/80 italic">{{ Auth::user()->name }}</span> ! 👋
                    </h1>
                    
                    <p class="text-white/60 text-sm sm:text-base md:text-lg font-medium leading-relaxed max-w-2xl mx-auto">
                        Sistem Manajemen Ruangan Digital SMKN 1 Katapang. Kelola inventaris dan jadwal dengan lebih efisien dan modern.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Decorative elements -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary-600/10 rounded-full blur-[100px]"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px]"></div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-door-open text-xl"></i>
                </div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total</span>
            </div>
            <h3 class="text-sm font-semibold text-slate-500 mb-1">Total Ruangan</h3>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-800">{{ $totalRooms }}</span>
                <span class="text-xs font-medium text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">Unit</span>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-handshake text-xl"></i>
                </div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">History</span>
            </div>
            <h3 class="text-sm font-semibold text-slate-500 mb-1">Total Peminjam</h3>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-800">{{ $totalBorrowers }}</span>
                <span class="text-xs font-medium text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">Data</span>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Users</span>
            </div>
            <h3 class="text-sm font-semibold text-slate-500 mb-1">Total User</h3>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-800">{{ $totalUsers }}</span>
                <span class="text-xs font-medium text-purple-500 bg-purple-50 px-2 py-0.5 rounded-full">Aktif</span>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Status</span>
            </div>
            <h3 class="text-sm font-semibold text-slate-500 mb-1">Peminjaman Pending</h3>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-bold text-slate-800">{{ $pendingBorrowers }}</span>
                <span class="text-xs font-medium text-orange-500 bg-orange-50 px-2 py-0.5 rounded-full">Menunggu</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-10">
        <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center">
                    <i class="fas fa-bolt"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 tracking-tight">Aksi Cepat</h3>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-wider">Akses fitur utama dengan sekali klik</p>
                </div>
            </div>
        </div>
        
        <div class="p-6 sm:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @if(Auth::user()->isAdmin())
                    <a href="/users/create" class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 hover:bg-primary-50 border border-slate-100 hover:border-primary-100 transition-all duration-300 group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-primary-600 group-hover:scale-110 transition-transform">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <span class="font-bold text-slate-700 group-hover:text-primary-700">Tambah User</span>
                        </div>
                        <i class="fas fa-chevron-right text-slate-300 group-hover:text-primary-400 group-hover:translate-x-1 transition-all"></i>
                    </a>
                @endif

                @if(Auth::user()->isAdmin() || Auth::user()->isSarpras() || Auth::user()->isToolman())
                    <a href="/rooms/create" class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 hover:bg-primary-50 border border-slate-100 hover:border-primary-100 transition-all duration-300 group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-primary-600 group-hover:scale-110 transition-transform">
                                <i class="fas fa-plus"></i>
                            </div>
                            <span class="font-bold text-slate-700 group-hover:text-primary-700">Tambah Ruangan</span>
                        </div>
                        <i class="fas fa-chevron-right text-slate-300 group-hover:text-primary-400 group-hover:translate-x-1 transition-all"></i>
                    </a>

                    <a href="/borrowers/create" class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 hover:bg-primary-50 border border-slate-100 hover:border-primary-100 transition-all duration-300 group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-primary-600 group-hover:scale-110 transition-transform">
                                <i class="fas fa-hand-holding"></i>
                            </div>
                            <span class="font-bold text-slate-700 group-hover:text-primary-700">Peminjaman Baru</span>
                        </div>
                        <i class="fas fa-chevron-right text-slate-300 group-hover:text-primary-400 group-hover:translate-x-1 transition-all"></i>
                    </a>

                    <a href="/schedules/create" class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 hover:bg-primary-50 border border-slate-100 hover:border-primary-100 transition-all duration-300 group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-primary-600 group-hover:scale-110 transition-transform">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <span class="font-bold text-slate-700 group-hover:text-primary-700">Tambah Jadwal</span>
                        </div>
                        <i class="fas fa-chevron-right text-slate-300 group-hover:text-primary-400 group-hover:translate-x-1 transition-all"></i>
                    </a>

                    <a href="{{ route('reports.borrowers-pdf') }}" target="_blank" class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-100 hover:border-emerald-100 transition-all duration-300 group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <span class="font-bold text-slate-700 group-hover:text-emerald-700 text-sm">Laporan Peminjam</span>
                        </div>
                        <i class="fas fa-download text-slate-300 group-hover:text-emerald-400 group-hover:translate-y-0.5 transition-all"></i>
                    </a>

                    <a href="{{ route('reports.schedules-pdf') }}" target="_blank" class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-100 hover:border-emerald-100 transition-all duration-300 group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <span class="font-bold text-slate-700 group-hover:text-emerald-700 text-sm">Laporan Jadwal</span>
                        </div>
                        <i class="fas fa-download text-slate-300 group-hover:text-emerald-400 group-hover:translate-y-0.5 transition-all"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
