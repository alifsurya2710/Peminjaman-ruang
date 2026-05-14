@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="relative overflow-hidden p-8 rounded-[2.5rem] bg-gradient-to-br from-slate-900 to-slate-800 text-white shadow-2xl shadow-slate-200">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-primary-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 bg-slate-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight mb-2 flex items-center gap-3">
                        <span class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-md border border-white/10">
                            <i class="fas fa-history text-primary-400"></i>
                        </span>
                        Riwayat Peminjaman
                    </h1>
                    <p class="text-slate-400 font-medium max-w-md">
                        Pantau seluruh rekam jejak peminjaman ruangan yang telah dilakukan oleh seluruh pengguna sistem.
                    </p>
                </div>
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
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-20">No</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Peminjam</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Ruangan</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Waktu Peminjaman</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Status</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($history as $item)
                            <tr class="hover:bg-primary-50/30 transition-all duration-300 group">
                                <td class="px-8 py-5">
                                    <span class="text-xs font-black text-slate-300 group-hover:text-primary-400 transition-colors">
                                        {{ str_pad(($history->currentPage() - 1) * $history->perPage() + $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full border-2 border-white shadow-sm overflow-hidden ring-2 ring-slate-100">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=64748b&color=fff" alt="Avatar">
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-800 group-hover:text-primary-600 transition-colors">{{ $item->user->name }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $item->class_name ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200 group-hover:bg-primary-50 group-hover:text-primary-600 transition-colors">
                                        <i class="fas fa-door-closed text-slate-400 group-hover:text-primary-400"></i>
                                        {{ $item->room->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-700">{{ \Carbon\Carbon::parse($item->borrow_date)->format('d M Y') }}</span>
                                        <span class="text-xs text-slate-400 font-medium">{{ \Carbon\Carbon::parse($item->borrow_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->return_date)->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex justify-center">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $item->getBadgeClasses() }}">
                                            {{ $item->getStatusLabel() }}
                                        </span>
                                    </div>

                                </td>
                                <td class="px-8 py-5 text-center">
                                    <a href="{{ route('history.show', $item) }}" class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-primary-500 hover:bg-primary-500 hover:text-white hover:border-primary-500 inline-flex items-center justify-center transition-all duration-300 shadow-sm" title="Detail">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 rounded-3xl bg-slate-50 text-slate-200 flex items-center justify-center mb-6 ring-8 ring-slate-50/50">
                                            <i class="fas fa-history text-3xl"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-800">Riwayat Kosong</h3>
                                        <p class="text-slate-400 max-w-xs mx-auto mt-1">Belum ada riwayat peminjaman yang tercatat.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($history->hasPages())
                <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/30">
                    {{ $history->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
