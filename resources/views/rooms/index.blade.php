@extends('layouts.app')

@section('title', 'Kelola Ruangan')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center shadow-sm">
                    <i class="fas fa-door-open"></i>
                </div>
                Kelola Ruangan
            </h2>
            <p class="text-slate-500 text-sm mt-1 ml-0 sm:ml-13">Daftar semua ruangan yang tersedia untuk dipinjam.</p>
        </div>
        <div>
            <a href="/rooms/create" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-200 transition-all duration-300 hover:-translate-y-0.5 active:scale-95 group">
                <i class="fas fa-plus group-hover:rotate-90 transition-transform duration-300"></i>
                Tambah Ruangan
            </a>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest w-20">No</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Nama Ruangan</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Kategori</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Kapasitas</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Deskripsi</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($rooms as $room)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-slate-400">{{ ($rooms->currentPage() - 1) * $rooms->perPage() + $loop->iteration }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg {{ $room->category->getBadgeClasses() }} flex items-center justify-center text-xs font-bold border">
                                        {{ substr($room->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-slate-700 group-hover:text-primary-600 transition-colors">{{ $room->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $room->category->getBadgeClasses() }} border">
                                    {{ $room->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-slate-600 flex items-center gap-2">
                                    <i class="fas fa-users text-slate-300"></i>
                                    {{ $room->capacity }} orang
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-500 line-clamp-1 max-w-xs">{{ $room->description }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="/rooms/{{ $room->id }}/edit" class="p-2 rounded-xl text-amber-500 hover:bg-amber-50 border border-transparent hover:border-amber-100 transition-all duration-200" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/rooms/{{ $room->id }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl text-rose-500 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition-all duration-200" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-slate-50 text-slate-300 flex items-center justify-center mb-4">
                                        <i class="fas fa-folder-open text-2xl"></i>
                                    </div>
                                    <p class="text-slate-400 font-medium">Tidak ada data ruangan ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($rooms->hasPages())
            <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
                {{ $rooms->links() }}
            </div>
        @endif
    </div>
@endsection