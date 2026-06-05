@extends('layouts.app')

@section('title', 'Kelola Background')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="relative overflow-hidden p-8 rounded-[2.5rem] text-white card-3d">
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight mb-2 flex items-center gap-3">
                    <span class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center border border-white/20">
                        <i class="fas fa-images text-white"></i>
                    </span>
                    Kelola Background Halaman
                </h1>
                <p class="text-white/85 font-medium max-w-lg">
                    Atur gambar latar belakang untuk halaman Login, Lupa Password, dan Atur Ulang Password secara dinamis.
                </p>
            </div>
            <a href="{{ route('auth-backgrounds.create') }}" class="group flex items-center gap-3 px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white rounded-2xl transition-all duration-300 font-bold text-sm shadow-lg shadow-primary-900/20">
                <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
                Tambah Background
            </a>
        </div>
    </div>

    <!-- Backgrounds Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">


        @forelse($backgrounds as $bg)
            <div class="group bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-500 hover:-translate-y-2 flex flex-col justify-between">
                <!-- Image Container -->
                <div class="relative h-48 overflow-hidden bg-slate-100 flex items-center justify-center">
                    <img src="{{ asset('storage/' . $bg->image) }}" alt="{{ $bg->name }}" class="w-full h-full object-cover group-hover:scale-115 transition-transform duration-700">
                    
                    <!-- Status Badges inside Image -->
                    <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                        @if($bg->is_active_login)
                            <span class="px-3 py-1 text-[10px] font-extrabold uppercase bg-emerald-500 text-white rounded-lg shadow-md flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-white rounded-full animate-ping"></span>
                                Login Aktif
                            </span>
                        @endif
                        @if($bg->is_active_forgot_password)
                            <span class="px-3 py-1 text-[10px] font-extrabold uppercase bg-cyan-500 text-white rounded-lg shadow-md flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-white rounded-full animate-ping"></span>
                                Lupa Password Aktif
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Card Info -->
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 tracking-tight mb-2 line-clamp-1">{{ $bg->name }}</h3>
                        <p class="text-xs text-slate-400 font-medium mb-4">
                            Diunggah {{ $bg->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <!-- Quick Toggles -->
                    <div class="space-y-2.5 mb-6">
                        @if(!$bg->is_active_login)
                            <form action="{{ route('auth-backgrounds.activate-login', $bg) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-2.5 px-4 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-xs rounded-xl transition-all flex items-center justify-center gap-2 cursor-pointer">
                                    <i class="fas fa-sign-in-alt"></i> Set Aktif Login
                                </button>
                            </form>
                        @else
                            <div class="w-full py-2.5 px-4 bg-emerald-500/10 text-emerald-800 font-bold text-xs rounded-xl flex items-center justify-center gap-2">
                                <i class="fas fa-check-circle"></i> Aktif untuk Login
                            </div>
                        @endif

                        @if(!$bg->is_active_forgot_password)
                            <form action="{{ route('auth-backgrounds.activate-forgot-password', $bg) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-2.5 px-4 bg-cyan-50 hover:bg-cyan-100 text-cyan-700 font-bold text-xs rounded-xl transition-all flex items-center justify-center gap-2 cursor-pointer">
                                    <i class="fas fa-key"></i> Set Aktif Lupa Password
                                </button>
                            </form>
                        @else
                            <div class="w-full py-2.5 px-4 bg-cyan-500/10 text-cyan-800 font-bold text-xs rounded-xl flex items-center justify-center gap-2">
                                <i class="fas fa-check-circle"></i> Aktif untuk Lupa Password
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-2 pt-4 border-t border-slate-50">
                        <a href="{{ route('auth-backgrounds.edit', $bg) }}" class="flex-1 px-4 py-2.5 bg-amber-50 text-amber-600 hover:bg-amber-100 font-bold text-xs rounded-xl transition-all text-center">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <form action="{{ route('auth-backgrounds.destroy', $bg) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2.5 bg-rose-50 text-rose-600 hover:bg-rose-100 font-bold text-xs rounded-xl transition-all cursor-pointer" onclick="return confirm('Apakah Anda yakin ingin menghapus background ini?')">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
        @endforelse
    </div>
</div>
@endsection
