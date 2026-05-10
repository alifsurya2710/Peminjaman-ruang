@extends('layouts.app')

@section('title', 'Kelola Peminjam')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center shadow-sm">
                    <i class="fas fa-handshake"></i>
                </div>
                Kelola Peminjam
            </h2>
            <p class="text-slate-500 text-sm mt-1 ml-0 sm:ml-13">Daftar semua permohonan peminjaman ruangan.</p>
        </div>
        <div>
            <a href="/borrowers/create" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-200 transition-all duration-300 hover:-translate-y-0.5 active:scale-95 group">
                <i class="fas fa-plus group-hover:rotate-90 transition-transform duration-300"></i>
                Tambah Peminjam
            </a>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest w-20">No</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Peminjam</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Kontak & Kelas</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Ruangan</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Waktu Pinjam</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($borrowers as $borrower)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-slate-400">{{ ($borrowers->currentPage() - 1) * $borrowers->perPage() + $loop->iteration }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700 group-hover:text-primary-600 transition-colors">{{ $borrower->name }}</span>
                                    <span class="text-xs text-slate-400 italic line-clamp-1 mt-0.5">{{ $borrower->purpose }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-1.5 text-xs font-medium text-slate-600">
                                        <i class="fas fa-phone text-slate-300 w-4"></i>
                                        {{ $borrower->phone ?? '-' }}
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        @if($borrower->class_name)
                                            <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                                {{ $borrower->class_name }}
                                            </span>
                                        @else
                                            <span class="text-[10px] text-slate-300">-</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    <i class="fas fa-door-closed text-slate-400"></i>
                                    {{ $borrower->room->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700">{{ $borrower->borrow_date->format('d M Y') }}</span>
                                    <span class="text-xs text-slate-400 font-medium">{{ $borrower->borrow_time }} - {{ $borrower->return_time }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    @if($borrower->status == 'pending')
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-600 border border-amber-100 animate-pulse">
                                            Pending
                                        </span>
                                    @elseif($borrower->status == 'approved')
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            Disetujui
                                        </span>
                                    @elseif($borrower->status == 'rejected')
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-100">
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600 border border-slate-200">
                                            Selesai
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-1">
                                    @if($borrower->status == 'pending')
                                        <form action="/borrowers/{{ $borrower->id }}/approve" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 rounded-xl text-emerald-500 hover:bg-emerald-50 border border-transparent hover:border-emerald-100 transition-all duration-200" title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="/borrowers/{{ $borrower->id }}/reject" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 rounded-xl text-rose-500 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition-all duration-200" title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="/borrowers/{{ $borrower->id }}/edit" class="p-2 rounded-xl text-amber-500 hover:bg-amber-50 border border-transparent hover:border-amber-100 transition-all duration-200" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/borrowers/{{ $borrower->id }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition-all duration-200" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-slate-50 text-slate-300 flex items-center justify-center mb-4">
                                        <i class="fas fa-handshake-slash text-2xl"></i>
                                    </div>
                                    <p class="text-slate-400 font-medium">Belum ada permohonan peminjaman</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($borrowers->hasPages())
            <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
                {{ $borrowers->links() }}
            </div>
        @endif
    </div>
@endsection
