@extends('layouts.app') 
@section('title', 'Data Barang') 
@section('content') 
<div class="space-y-6"> 

    {{-- PAGE HEADER --}}
    <div class="relative overflow-hidden p-8 rounded-[2.5rem] text-white card-3d">
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight mb-2 flex items-center gap-3">
                    <span class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center border border-white/20">
                        <i class="fas fa-boxes text-white"></i>
                    </span>
                    Data Barang
                </h1>
                <p class="text-white/80 font-medium max-w-lg">Stok barang per ruangan — filter berdasarkan nama ruangan.</p>
            </div>
            @if(Auth::user()->isAdmin() || Auth::user()->isSarpras())
            <a href="/items/create" class="group flex items-center gap-3 px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white rounded-2xl transition-all duration-300 font-bold text-sm shadow-lg shadow-primary-900/20">
                <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i> Tambah Barang
            </a>
            @endif
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">

        {{-- ===== SIDEBAR FILTER RUANGAN ===== --}}
        <div class="lg:w-64 flex-shrink-0">
            <div class="bg-white rounded-[1.5rem] border border-slate-100 shadow-sm overflow-hidden sticky top-24">
                <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/60">
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Filter Ruangan</p>
                </div>
                <nav class="p-3 space-y-1">
                    {{-- Semua --}}
                    <a href="/items"
                       class="flex items-center justify-between gap-2 px-3 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 {{ !$selectedRoomId ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-layer-group w-4 text-center {{ !$selectedRoomId ? 'text-white/70' : 'text-slate-400' }}"></i>
                            Semua Barang
                        </span>
                        <span class="text-[10px] font-black px-2 py-0.5 rounded-full {{ !$selectedRoomId ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500' }}">
                            {{ \App\Models\Item::count() }}
                        </span>
                    </a>
                    {{-- Tanpa Ruangan --}}
                    <a href="/items?room_id=none"
                       class="flex items-center justify-between gap-2 px-3 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 {{ $selectedRoomId === 'none' ? 'bg-slate-200 text-slate-800' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-box w-4 text-center text-slate-300"></i>
                            Tanpa Ruangan
                        </span>
                        <span class="text-[10px] font-black bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full">
                            {{ \App\Models\Item::whereNull('room_id')->count() }}
                        </span>
                    </a>

                    @if($rooms->isNotEmpty())
                    <div class="pt-2">
                        <p class="px-3 text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Per Ruangan</p>
                        @foreach($rooms as $room)
                        @php $roomItemCount = \App\Models\Item::where('room_id', $room->id)->count(); @endphp
                        @if($roomItemCount > 0 || true)
                        <a href="/items?room_id={{ $room->id }}"
                           class="flex items-center justify-between gap-2 px-3 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 {{ $selectedRoomId == $room->id ? 'bg-primary-600 text-white' : 'text-slate-600 hover:bg-slate-50 hover:text-primary-600' }}">
                            <span class="flex items-center gap-2 min-w-0">
                                <i class="fas fa-door-open w-4 text-center flex-shrink-0 {{ $selectedRoomId == $room->id ? 'text-white/70' : 'text-slate-300' }}"></i>
                                <span class="truncate">{{ $room->name }}</span>
                            </span>
                            <span class="text-[10px] font-black px-2 py-0.5 rounded-full flex-shrink-0 {{ $selectedRoomId == $room->id ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500' }}">
                                {{ $roomItemCount }}
                            </span>
                        </a>
                        @endif
                        @endforeach
                    </div>
                    @endif
                </nav>
            </div>
        </div>

        {{-- ===== MAIN CONTENT ===== --}}
        <div class="flex-1 space-y-5">

            {{-- Active filter badge --}}
            @if($selectedRoomId)
            @php
                $filterLabel = $selectedRoomId === 'none'
                    ? 'Tanpa Ruangan'
                    : ($rooms->firstWhere('id', $selectedRoomId)?->name ?? '');
            @endphp
            <div class="flex items-center gap-3">
                <span class="text-sm font-bold text-slate-500">Filter aktif:</span>
                <span class="inline-flex items-center gap-2 bg-primary-50 text-primary-700 border border-primary-100 px-3 py-1.5 rounded-xl text-xs font-bold">
                    <i class="fas fa-door-open text-primary-400"></i> {{ $filterLabel }}
                </span>
                <a href="/items" class="text-xs font-bold text-slate-400 hover:text-rose-500 transition-colors">
                    <i class="fas fa-times mr-1"></i>Hapus Filter
                </a>
            </div>
            @endif

            @forelse($items as $item)
            @php
                $activeBorrowings = $item->borrowings;
                $borrowedAmount   = $activeBorrowings->where('status', 'approved')->sum('amount');
                $pendingAmount    = $activeBorrowings->where('status', 'pending')->sum('amount');
            @endphp
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                {{-- Item Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-7 py-5 border-b border-slate-100 bg-slate-50/50">
                    <div class="flex items-center gap-4">
                        <div class="w-11 h-11 rounded-2xl bg-slate-900 text-white flex items-center justify-center shadow-md flex-shrink-0">
                            @if(str_contains(strtolower($item->name), 'kursi'))
                                <i class="fas fa-chair"></i>
                            @elseif(str_contains(strtolower($item->name), 'meja'))
                                <i class="fas fa-table"></i>
                            @elseif(str_contains(strtolower($item->name), 'tenda'))
                                <i class="fas fa-campground"></i>
                            @else
                                <i class="fas fa-box"></i>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h2 class="text-base font-extrabold text-slate-800">{{ $item->name }}</h2>
                                {{-- Room badge --}}
                                @if($item->room)
                                    <a href="/items?room_id={{ $item->room_id }}" class="inline-flex items-center gap-1 text-[10px] font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-lg hover:bg-indigo-100 transition-colors">
                                        <i class="fas fa-door-open text-indigo-400"></i> {{ $item->room->name }}
                                    </a>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-400 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded-lg">
                                        <i class="fas fa-box text-slate-300"></i> Tanpa Ruangan
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-3 mt-1 flex-wrap">
                                <span class="text-xs font-bold text-slate-400">Total: <span class="text-slate-700">{{ $item->total_stock }}</span></span>
                                <span class="text-xs font-bold {{ $item->available_stock > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                    <i class="fas fa-check-circle mr-0.5"></i>Tersedia: <b>{{ $item->available_stock }}</b>
                                </span>
                                @if($borrowedAmount > 0)
                                <span class="text-xs font-bold text-amber-500"><i class="fas fa-handshake mr-0.5"></i>Dipinjam: {{ $borrowedAmount }}</span>
                                @endif
                                @if($pendingAmount > 0)
                                <span class="text-xs font-bold text-violet-500 animate-pulse"><i class="fas fa-clock mr-0.5"></i>Pending: {{ $pendingAmount }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(Auth::user()->isAdmin() || Auth::user()->isSarpras())
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <a href="/items/{{ $item->id }}/edit" class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-amber-500 hover:bg-amber-500 hover:text-white hover:border-amber-500 font-bold text-xs transition-all duration-300 shadow-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="/items/{{ $item->id }}" method="POST" class="inline">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-rose-500 hover:bg-rose-500 hover:text-white hover:border-rose-500 font-bold text-xs transition-all duration-300 shadow-sm">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                    @endif
                </div>

                {{-- Active Borrowings --}}
                @if($activeBorrowings->isNotEmpty())
                <div class="px-7 py-4">
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-3">Peminjam Aktif</p>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-slate-100">
                                    <th class="pb-2 pr-5 text-[10px] font-black text-slate-400 uppercase tracking-wider">Peminjam</th>
                                    <th class="pb-2 pr-5 text-[10px] font-black text-slate-400 uppercase tracking-wider">Kelas</th>
                                    <th class="pb-2 pr-5 text-[10px] font-black text-slate-400 uppercase tracking-wider">Jurusan</th>
                                    <th class="pb-2 pr-5 text-[10px] font-black text-slate-400 uppercase tracking-wider">Jumlah</th>
                                    <th class="pb-2 pr-5 text-[10px] font-black text-slate-400 uppercase tracking-wider">Kembali</th>
                                    <th class="pb-2 text-[10px] font-black text-slate-400 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($activeBorrowings as $borrowing)
                                <tr>
                                    <td class="py-3 pr-5">
                                        <p class="text-sm font-bold text-slate-800">{{ $borrowing->borrower_name }}</p>
                                        <p class="text-xs text-slate-400 italic">{{ $borrowing->purpose }}</p>
                                    </td>
                                    <td class="py-3 pr-5">
                                        @if($borrowing->class_name)
                                            <span class="inline-flex items-center gap-1 text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-lg">
                                                <i class="fas fa-chalkboard-teacher text-indigo-400 text-[10px]"></i> {{ $borrowing->class_name }}
                                            </span>
                                        @else
                                            <span class="text-slate-300 text-xs">—</span>
                                        @endif
                                    </td>
                                    <td class="py-3 pr-5">
                                        @if($borrowing->department)
                                            <span class="inline-flex items-center gap-1 text-xs font-bold text-violet-700 bg-violet-50 border border-violet-100 px-2 py-0.5 rounded-lg">
                                                <i class="fas fa-graduation-cap text-violet-400 text-[10px]"></i> {{ $borrowing->department }}
                                            </span>
                                        @else
                                            <span class="text-slate-300 text-xs">—</span>
                                        @endif
                                    </td>
                                    <td class="py-3 pr-5">
                                        <span class="text-sm font-extrabold text-slate-700">{{ $borrowing->amount }} <span class="text-slate-400 font-normal text-xs">unit</span></span>
                                    </td>
                                    <td class="py-3 pr-5">
                                        <span class="text-xs font-bold text-slate-600">{{ $borrowing->return_date->format('d M Y') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="px-2 py-1 text-[10px] font-bold rounded-lg {{ $borrowing->getBadgeClasses() }} border">
                                            {{ $borrowing->getStatusLabel() }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="px-7 py-4 flex items-center gap-2 text-slate-400">
                    <i class="fas fa-info-circle text-slate-300 text-xs"></i>
                    <span class="text-xs font-medium">Tidak ada peminjaman aktif.</span>
                </div>
                @endif
            </div>
            @empty
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm px-8 py-20 text-center">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-20 h-20 rounded-3xl bg-slate-50 text-slate-200 flex items-center justify-center mb-6 ring-8 ring-slate-50/50">
                        <i class="fas fa-box-open text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">
                        @if($selectedRoomId)
                            Belum ada barang untuk ruangan ini
                        @else
                            Barang Kosong
                        @endif
                    </h3>
                    <p class="text-slate-400 max-w-xs mx-auto mt-1 text-sm">
                        @if($selectedRoomId)
                            Tambahkan barang dan pilih ruangan ini agar muncul di sini.
                        @else
                            Belum ada data barang yang ditambahkan ke sistem.
                        @endif
                    </p>
                    @if(Auth::user()->isAdmin() || Auth::user()->isSarpras())
                    <a href="/items/create" class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white rounded-xl font-bold text-sm hover:bg-slate-800 transition-all">
                        <i class="fas fa-plus"></i> Tambah Barang
                    </a>
                    @endif
                </div>
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
