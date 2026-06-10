@extends('layouts.app') 
@section('title', 'Peminjaman Barang') 
@section('content') 
<div class="space-y-8"> 
    <div class="relative overflow-hidden p-8 rounded-[2.5rem] bg-indigo-900 text-white card-3d"> 
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div> 
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div> 
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6"> 
            <div> 
                <h1 class="text-3xl font-extrabold tracking-tight mb-2 flex items-center gap-3"> 
                    <span class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center border border-white/20"> 
                        <i class="fas fa-people-carry-box text-white"></i> 
                    </span> 
                    Peminjaman Barang 
                </h1> 
                <p class="text-white/85 font-medium max-w-md">Kelola & setujui peminjaman barang (kursi, meja, tenda).</p> 
            </div> 
            <a href="/item_borrowings/create" class="group flex items-center gap-3 px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white rounded-2xl transition-all duration-300 font-bold text-sm shadow-lg shadow-primary-900/20"> 
                <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i> Peminjaman Baru 
            </a> 
        </div> 
    </div> 
    
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden"> 
        <div class="overflow-x-auto"> 
            <table class="w-full text-left border-collapse"> 
                <thead> 
                    <tr class="bg-slate-50/50 border-b border-slate-100"> 
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-14">No</th> 
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Peminjam</th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kelas & Jurusan</th>
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Barang & Jumlah</th> 
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tanggal</th> 
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th> 
                        <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Aksi</th> 
                    </tr> 
                </thead> 
                <tbody class="divide-y divide-slate-50"> 
                    @forelse($borrowings as $borrowing) 
                    <tr class="hover:bg-indigo-50/20 transition-all duration-300 group {{ $borrowing->status === 'pending' ? 'bg-amber-50/30' : '' }}"> 
                        <td class="px-6 py-5"> 
                            <span class="text-xs font-black text-slate-300 group-hover:text-indigo-400 transition-colors"> 
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} 
                            </span> 
                        </td> 
                        <td class="px-6 py-5"> 
                            <p class="text-sm font-black text-slate-800">{{ $borrowing->borrower_name }}</p> 
                            <p class="text-xs font-medium text-slate-400 italic mt-0.5">{{ $borrowing->purpose }}</p> 
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-col gap-1.5">
                                @if($borrowing->class_name)
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 px-2.5 py-1 rounded-lg w-fit">
                                        <i class="fas fa-chalkboard-teacher text-indigo-400 text-[10px]"></i>
                                        {{ $borrowing->class_name }}
                                    </span>
                                @endif
                                @if($borrowing->department)
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-violet-700 bg-violet-50 border border-violet-100 px-2.5 py-1 rounded-lg w-fit">
                                        <i class="fas fa-graduation-cap text-violet-400 text-[10px]"></i>
                                        {{ $borrowing->department }}
                                    </span>
                                @endif
                                @if(!$borrowing->class_name && !$borrowing->department)
                                    <span class="text-xs text-slate-300 italic">—</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-5"> 
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-bold text-slate-800">{{ $borrowing->item->name }}</span>
                                <span class="text-xs font-extrabold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-lg w-fit">{{ $borrowing->amount }} unit</span>
                            </div>
                        </td> 
                        <td class="px-6 py-5"> 
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-bold text-slate-600 flex items-center gap-1">
                                    <i class="fas fa-calendar-alt text-slate-300"></i> {{ $borrowing->borrow_date->format('d M Y') }}
                                </span>
                                <span class="text-xs font-bold text-slate-600 flex items-center gap-1">
                                    <i class="fas fa-calendar-check text-slate-300"></i> {{ $borrowing->return_date->format('d M Y') }}
                                </span>
                            </div>
                        </td> 
                        <td class="px-6 py-5"> 
                            <span class="px-3 py-1.5 text-xs font-bold rounded-xl {{ $borrowing->getBadgeClasses() }} border"> 
                                {{ $borrowing->getStatusLabel() }} 
                            </span> 
                        </td>
                        <td class="px-6 py-5"> 
                            <div class="flex items-center justify-center gap-2 flex-wrap">

                                {{-- APPROVE button: shown only when pending --}}
                                @if($borrowing->status === 'pending')
                                <form action="{{ route('item_borrowings.approve', $borrowing->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('Setujui peminjaman {{ $borrowing->item->name }} sebanyak {{ $borrowing->amount }} unit oleh {{ $borrowing->borrower_name }}?')"
                                        class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs transition-all duration-300 shadow-sm shadow-emerald-200"
                                        title="Setujui">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                </form>
                                <form action="{{ route('item_borrowings.reject', $borrowing->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('Tolak peminjaman ini?')"
                                        class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs transition-all duration-300 shadow-sm shadow-rose-200"
                                        title="Tolak">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </form>
                                @endif

                                {{-- SELESAI button: shown only when approved --}}
                                @if($borrowing->status === 'approved')
                                <form action="{{ route('item_borrowings.finish', $borrowing->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('Tandai peminjaman {{ $borrowing->item->name }} sebagai Selesai? Stok akan dikembalikan.')"
                                        class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs transition-all duration-300 shadow-sm"
                                        title="Selesai">
                                        <i class="fas fa-flag-checkered"></i> Selesai
                                    </button>
                                </form>
                                @endif

                                {{-- EDIT button: always --}}
                                @if(Auth::user()->isAdmin() || Auth::user()->isSarpras())
                                <a href="/item_borrowings/{{ $borrowing->id }}/edit"
                                   class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-amber-500 hover:bg-amber-500 hover:text-white hover:border-amber-500 flex items-center justify-center transition-all duration-300 shadow-sm"
                                   title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="/item_borrowings/{{ $borrowing->id }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Hapus data ini? Stok akan disesuaikan otomatis.')"
                                        class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-rose-500 hover:bg-rose-500 hover:text-white hover:border-rose-500 flex items-center justify-center transition-all duration-300 shadow-sm"
                                        title="Hapus">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                                @endif

                            </div> 
                        </td> 
                    </tr> 
                    @empty 
                    <tr> 
                        <td colspan="7" class="px-8 py-20 text-center"> 
                            <div class="flex flex-col items-center justify-center"> 
                                <div class="w-20 h-20 rounded-3xl bg-slate-50 text-slate-200 flex items-center justify-center mb-6 ring-8 ring-slate-50/50"> 
                                    <i class="fas fa-folder-open text-3xl"></i> 
                                </div> 
                                <h3 class="text-lg font-bold text-slate-800">Data Peminjaman Kosong</h3> 
                                <p class="text-slate-400 max-w-xs mx-auto mt-1">Belum ada transaksi peminjaman barang.</p> 
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
