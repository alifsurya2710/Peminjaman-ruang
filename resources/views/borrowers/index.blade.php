@extends('layouts.app')

@section('title', 'Kelola Peminjam')

@section('content')
    <div class="space-y-8">
        <!-- Header Section (Dynamic color matching user role with 3D effect) -->
        <div class="relative overflow-hidden p-8 rounded-[2.5rem] text-white card-3d">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight mb-2 flex items-center gap-3">
                        <span class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center backdrop-blur-md border border-white/20">
                            <i class="fas fa-handshake text-white"></i>
                        </span>
                        Kelola Peminjam
                    </h1>
                    <p class="text-white/85 font-medium max-w-md">
                        Daftar semua permohonan peminjaman ruangan yang terdaftar di sistem.
                    </p>
                </div>
                
                <a href="/borrowers/create" class="group flex items-center gap-3 px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white rounded-2xl transition-all duration-300 font-bold text-sm shadow-lg shadow-primary-900/20">
                    <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
                    Tambah Peminjam
                </a>
            </div>
        </div>


        <!-- Filter Section -->
        <div class="bg-white/60 backdrop-blur-xl rounded-[2rem] border border-slate-100 shadow-sm p-6 space-y-6">
            <div class="flex items-center gap-3 pb-4 border-b border-slate-50">
                <div class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-sm">
                    <i class="fas fa-filter"></i>
                </div>
                <h3 class="font-bold text-slate-700">Filter Pencarian</h3>
            </div>
            
            <form method="GET" action="/borrowers" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div class="space-y-1.5">
                    <label for="name" class="text-xs font-bold text-slate-500 ml-1">Nama Peminjam</label>
                    <input type="text" class="block w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all" id="name" name="name" placeholder="Cari nama..." value="{{ request('name') }}">
                </div>

                <div class="space-y-1.5">
                    <label for="room_id" class="text-xs font-bold text-slate-500 ml-1">Ruangan</label>
                    <select class="block w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-bold focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all" id="room_id" name="room_id">
                        <option value="">Semua Ruangan</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                                {{ $room->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label for="class_name" class="text-xs font-bold text-slate-500 ml-1">Kelas</label>
                    <input type="text" class="block w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all" id="class_name" name="class_name" placeholder="Cari kelas..." value="{{ request('class_name') }}">
                </div>

                <div class="space-y-1.5">
                    <label for="status" class="text-xs font-bold text-slate-500 ml-1">Status</label>
                    <select class="block w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-bold focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <!-- Advanced Date Filter -->
                <div class="col-span-full pt-2">
                    <details class="group border border-slate-100 rounded-2xl bg-slate-50/50 p-4 transition-all">
                        <summary class="flex items-center justify-between cursor-pointer font-bold text-xs text-primary-600 select-none">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-calendar"></i> Filter Lanjutan (Berdasarkan Tanggal)
                            </span>
                            <span class="transition-transform group-open:rotate-180">
                                <i class="fas fa-chevron-down text-[10px]"></i>
                            </span>
                        </summary>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                            <div class="space-y-1.5">
                                <label for="borrow_date_from" class="text-xs font-bold text-slate-500 ml-1">Dari Tanggal</label>
                                <input type="date" class="block w-full px-4 py-2 text-xs bg-white border border-slate-200 rounded-xl text-slate-700 font-bold focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all" id="borrow_date_from" name="borrow_date_from" value="{{ request('borrow_date_from') }}">
                            </div>

                            <div class="space-y-1.5">
                                <label for="borrow_date_to" class="text-xs font-bold text-slate-500 ml-1">Sampai Tanggal</label>
                                <input type="date" class="block w-full px-4 py-2 text-xs bg-white border border-slate-200 rounded-xl text-slate-700 font-bold focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all" id="borrow_date_to" name="borrow_date_to" value="{{ request('borrow_date_to') }}">
                            </div>
                        </div>
                    </details>
                </div>
                
                <div class="col-span-full flex flex-wrap items-center justify-between gap-3 pt-2">
                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-500 text-white font-bold rounded-xl shadow-lg shadow-primary-200 transition-all duration-200 flex items-center justify-center gap-2 text-xs">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        
                        @if(request()->anyFilled(['name', 'room_id', 'status', 'class_name', 'borrow_date_from', 'borrow_date_to']))
                            <a href="/borrowers" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 text-xs text-center">
                                <i class="fas fa-redo"></i> Reset Filter
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Table Section -->
        <div class="bg-white/60 backdrop-blur-xl rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">

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
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $borrower->getBadgeClasses() }}">
                                        {{ $borrower->getStatusLabel() }}
                                    </span>
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
                                    @if($borrower->isFinished())
                                        <button onclick="Swal.fire({
                                            title: 'Peminjaman Selesai',
                                            text: 'Peminjaman ini sudah selesai dan tidak dapat diubah lagi.',
                                            icon: 'info',
                                            confirmButtonColor: '#0f172a',
                                            confirmButtonText: 'Tutup',
                                            customClass: {
                                                popup: 'rounded-[2rem] border-none shadow-2xl',
                                                title: 'text-slate-800 font-bold',
                                                confirmButton: 'rounded-xl px-6 py-3 font-bold'
                                            }
                                        })" class="p-2 rounded-xl text-slate-400 hover:bg-slate-100 transition-all duration-200" title="Selesai">
                                            <i class="fas fa-check-double"></i>
                                        </button>
                                    @else
                                        <a href="/borrowers/{{ $borrower->id }}/edit" class="p-2 rounded-xl text-amber-500 hover:bg-amber-50 border border-transparent hover:border-amber-100 transition-all duration-200" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

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
    </div>
@endsection

