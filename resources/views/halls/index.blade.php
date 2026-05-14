@extends('layouts.app')

@section('title', 'Manajemen Aula')

@section('content')
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="relative overflow-hidden p-8 rounded-[2.5rem] bg-gradient-to-br from-slate-900 to-slate-800 text-white shadow-2xl shadow-slate-200">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-primary-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight mb-2 flex items-center gap-3">
                        <span class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-md border border-white/10">
                            <i class="fas fa-building text-primary-400"></i>
                        </span>
                        Manajemen Aula
                    </h1>
                    <p class="text-slate-400 font-medium max-w-md">
                        Kelola data aula, kapasitas, dan ketersediaan fasilitas gedung di lingkungan sekolah.
                    </p>
                </div>
                
                @if(auth()->user()->role === 'sarpras' || auth()->user()->role === 'admin')
                    <a href="{{ route('halls.create') }}" class="group flex items-center gap-3 px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white rounded-2xl transition-all duration-300 font-bold text-sm shadow-lg shadow-primary-900/20">
                        <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
                        Tambah Aula Baru
                    </a>
                @endif
            </div>
        </div>

        @if($message = Session::get('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-in fade-in duration-500">
                <i class="fas fa-check-circle text-emerald-500"></i>
                <p class="text-sm font-bold text-emerald-700">{{ $message }}</p>
            </div>
        @endif

        <!-- Table Section -->
        <div class="bg-white/60 backdrop-blur-xl rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Nama Aula</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kapasitas</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Lokasi</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($halls as $hall)
                            <tr class="hover:bg-primary-50/30 transition-all duration-300 group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100 flex items-center justify-center text-slate-400 border border-slate-200 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 shadow-sm">
                                            <i class="fas fa-landmark text-lg group-hover:text-primary-500"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-800 group-hover:text-primary-600 transition-colors">{{ $hall->name }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ Str::limit($hall->description, 30) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                        <i class="fas fa-users text-slate-300"></i>
                                        {{ $hall->capacity }} Orang
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-sm font-medium text-slate-600 flex items-center gap-2">
                                        <i class="fas fa-map-marker-alt text-slate-300"></i>
                                        {{ $hall->location }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    @if($hall->is_available)
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm">
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-100 shadow-sm">
                                            Tidak Tersedia
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center justify-center gap-3">
                                        @if(auth()->user()->role === 'sarpras' || auth()->user()->role === 'admin')
                                            <a href="{{ route('halls.edit', $hall) }}" class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-amber-500 hover:bg-amber-500 hover:text-white hover:border-amber-500 flex items-center justify-center transition-all duration-300 shadow-sm" title="Edit">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            <form action="{{ route('halls.destroy', $hall) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-rose-500 hover:bg-rose-500 hover:text-white hover:border-rose-500 flex items-center justify-center transition-all duration-300 shadow-sm" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 rounded-3xl bg-slate-50 text-slate-200 flex items-center justify-center mb-6 ring-8 ring-slate-50/50">
                                            <i class="fas fa-building text-3xl"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-800">Aula Kosong</h3>
                                        <p class="text-slate-400 max-w-xs mx-auto mt-1">Belum ada data aula yang ditambahkan ke sistem.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
