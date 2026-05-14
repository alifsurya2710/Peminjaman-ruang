@extends('layouts.app')

@section('title', 'Detail Ruangan')

@section('content')
    <div class="max-w-4xl">
        <div class="flex items-center gap-4 mb-8">
            <a href="/rooms" class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-primary-600 hover:border-primary-100 transition-all shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Detail Ruangan</h2>
                <p class="text-slate-500 text-sm">Informasi lengkap mengenai ruangan <span class="text-primary-600 font-bold">{{ $room->name }}</span>.</p>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <!-- Room Image Section -->
                <div class="relative h-64 lg:h-auto bg-slate-100 overflow-hidden">
                    @if($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 gap-4">
                            <i class="fas fa-image text-6xl"></i>
                            <span class="text-xs font-bold uppercase tracking-widest">Tidak Ada Foto</span>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider {{ $room->category->getBadgeClasses() }} border shadow-lg backdrop-blur-md">
                            {{ $room->category->name }}
                        </span>
                    </div>
                </div>

                <!-- Room Info Section -->
                <div class="p-8 lg:p-12 space-y-8">
                    <div>
                        <p class="text-[10px] font-black text-primary-500 uppercase tracking-[0.2em] mb-2">Informasi Ruangan</p>
                        <h1 class="text-3xl font-black text-slate-800 tracking-tight mb-4">{{ $room->name }}</h1>
                        <p class="text-slate-500 leading-relaxed italic">"{{ $room->description ?? 'Tidak ada deskripsi tersedia.' }}"</p>
                    </div>

                    <div class="grid grid-cols-2 gap-6 pt-8 border-t border-slate-50">
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kapasitas</p>
                            <div class="flex items-center gap-2 text-slate-700 font-black">
                                <i class="fas fa-users text-primary-500"></i>
                                <span>{{ $room->capacity }} Orang</span>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID Ruangan</p>
                            <div class="flex items-center gap-2 text-slate-700 font-black">
                                <i class="fas fa-hashtag text-primary-500"></i>
                                <span>#RM-{{ $room->id }}</span>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->role === 'admin')
                        <div class="pt-8 flex gap-3">
                            <a href="/rooms/{{ $room->id }}/edit" class="flex-1 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-2xl transition-all text-center flex items-center justify-center gap-2 shadow-lg shadow-amber-200">
                                <i class="fas fa-edit"></i>
                                Edit Ruangan
                            </a>
                            <form action="/rooms/{{ $room->id }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-6 py-3 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-2xl transition-all flex items-center justify-center gap-2 shadow-lg shadow-rose-200" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
