@extends('layouts.app')

@section('title', 'Tambah Peminjam')

@section('content')
    <div class="max-w-4xl">
        <div class="flex items-center gap-4 mb-8">
            <a href="/borrowers" class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-primary-600 hover:border-primary-100 transition-all shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Peminjam Baru</h2>
                <p class="text-slate-500 text-sm">Silakan isi detail permohonan peminjaman ruangan di bawah ini.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8">
                <form action="/borrowers" method="POST" class="space-y-8">
                    @csrf

                    <!-- Section 1: Identitas -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 border-b border-slate-50 pb-4">
                            <div class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-sm">
                                <i class="fas fa-user"></i>
                            </div>
                            <h3 class="font-bold text-slate-700">Identitas Peminjam</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1" for="name">Nama Lengkap</label>
                                <input type="text" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('name') border-rose-400 ring-rose-400/10 @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Alif Surya" required>
                                @error('name') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1" for="phone">Nomor Telepon / WA</label>
                                <input type="text" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('phone') border-rose-400 ring-rose-400/10 @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                                @error('phone') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1" for="class_name">Kelas / Jurusan</label>
                                <input type="text" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('class_name') border-rose-400 ring-rose-400/10 @enderror" id="class_name" name="class_name" value="{{ old('class_name') }}" placeholder="Contoh: 12-RPL 1">
                                @error('class_name') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-6 col-span-full" x-data="{ 
                                search: '', 
                                category: 'all' 
                            }">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <label class="text-sm font-bold text-slate-700 ml-1">Pilih Ruangan</label>
                                    
                                    <!-- Filters -->
                                    <div class="flex flex-wrap items-center gap-3">
                                        <!-- Search -->
                                        <div class="relative min-w-[200px]">
                                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                            <input type="text" 
                                                   x-model="search" 
                                                   placeholder="Cari nama ruangan..." 
                                                   class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all">
                                        </div>

                                        <!-- Category Filter -->
                                        <select x-model="category" 
                                                class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-600 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all">
                                            <option value="all">Semua Kategori</option>
                                            @foreach($rooms->pluck('category.name')->unique() as $catName)
                                                <option value="{{ $catName }}">{{ $catName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <input type="hidden" name="room_id" id="room_id" value="{{ old('room_id') }}" required>
                                
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4" id="room-selector">
                                    @foreach($rooms as $room)
                                        @php
                                            $isOccupied = in_array($room->id, $occupiedRoomIds);
                                            $categoryName = $room->category->name ?? '';
                                            $isSpecial = str_contains(strtolower($categoryName), 'elektronika') || str_contains(strtolower($categoryName), 'mekatronika');
                                            
                                            $cardClasses = "relative group p-4 rounded-2xl border transition-all duration-300 cursor-pointer overflow-hidden ";
                                            if ($isOccupied) {
                                                $cardClasses .= $isSpecial ? "bg-rose-500 border-rose-600 text-white shadow-lg shadow-rose-100" : "bg-amber-400 border-amber-500 text-white shadow-lg shadow-amber-100";
                                            } else {
                                                $cardClasses .= "bg-white border-slate-100 hover:border-primary-400 hover:shadow-xl hover:shadow-primary-100/50 hover:-translate-y-1";
                                            }
                                        @endphp
                                        
                                        <div class="room-card {{ $cardClasses }} min-h-[160px] flex flex-col p-0 group" 
                                             x-show="(category === 'all' || category === '{{ $categoryName }}') && ('{{ strtolower($room->name) }}'.includes(search.toLowerCase()))"
                                             x-transition:enter="transition ease-out duration-300"
                                             x-transition:enter-start="opacity-0 scale-95"
                                             x-transition:enter-end="opacity-100 scale-100"
                                             data-room-id="{{ $room->id }}" 
                                             data-occupied="{{ $isOccupied ? 'true' : 'false' }}"
                                             onclick="selectRoom(this)">
                                            
                                            <!-- Image Header -->
                                            <div class="h-28 w-full relative overflow-hidden bg-slate-100">
                                                @if($room->image)
                                                    <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                        <i class="fas fa-door-open text-3xl"></i>
                                                    </div>
                                                @endif
                                                
                                                @if($isOccupied)
                                                    <div class="absolute inset-0 {{ $isSpecial ? 'bg-rose-600/60' : 'bg-amber-500/60' }} backdrop-blur-[1px] flex items-center justify-center">
                                                        <i class="fas fa-lock text-white/50 text-2xl"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="p-3 flex-1 flex flex-col items-center justify-center text-center gap-1">
                                                <span class="text-[11px] font-bold leading-tight {{ $isOccupied ? 'text-white' : 'text-slate-800 group-hover:text-primary-600' }} transition-colors">{{ $room->name }}</span>
                                                
                                                @if($isOccupied)
                                                    <span class="text-[8px] font-black uppercase tracking-tighter bg-white/20 text-white px-2 py-0.5 rounded-full">Sedang Dipakai</span>
                                                @endif
                                            </div>

                                            <!-- Selection Indicator -->
                                            <div class="selection-indicator absolute inset-0 border-4 border-primary-500 rounded-2xl opacity-0 transition-opacity pointer-events-none z-20">
                                                <div class="absolute top-2 right-2 w-6 h-6 bg-primary-500 text-white rounded-full flex items-center justify-center shadow-lg">
                                                    <i class="fas fa-check text-xs"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- No Results Message -->
                                <div x-show="document.querySelectorAll('.room-card:not([style*=\'display: none\'])').length === 0" 
                                     class="py-12 flex flex-col items-center justify-center text-slate-400 gap-3">
                                    <i class="fas fa-search text-4xl opacity-20"></i>
                                    <p class="text-sm font-medium">Tidak ada ruangan yang cocok dengan filter Anda.</p>
                                </div>

                                @error('room_id') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                            </div>


                            <script>
                                function selectRoom(element) {
                                    const isOccupied = element.getAttribute('data-occupied') === 'true';
                                    const roomId = element.getAttribute('data-room-id');
                                    
                                    if (isOccupied) {
                                        Swal.fire({
                                            title: 'Maaf, Ruangan Sedang Dipakai',
                                            text: 'Silakan pilih ruangan lain atau tunggu hingga waktu peminjaman selesai.',
                                            icon: 'warning',
                                            confirmButtonColor: '#3b82f6',
                                            confirmButtonText: 'Mengerti',
                                            background: '#ffffff',
                                            borderRadius: '1.5rem',
                                            customClass: {
                                                popup: 'rounded-3xl border-none shadow-2xl',
                                                title: 'text-slate-800 font-bold',
                                                htmlContainer: 'text-slate-500 font-medium'
                                            }
                                        });
                                        return;
                                    }

                                    // Clear previous selection
                                    document.querySelectorAll('.room-card').forEach(card => {
                                        card.classList.remove('ring-4', 'ring-primary-500/20', 'border-primary-500');
                                        card.querySelector('.selection-indicator').classList.add('opacity-0');
                                    });

                                    // Add new selection
                                    element.classList.add('ring-4', 'ring-primary-500/20', 'border-primary-500');
                                    element.querySelector('.selection-indicator').classList.remove('opacity-0');
                                    
                                    // Update hidden input
                                    document.getElementById('room_id').value = roomId;
                                }

                                // Handle old value on page load
                                window.addEventListener('load', () => {
                                    const oldId = "{{ old('room_id') }}";
                                    if (oldId) {
                                        const card = document.querySelector(`.room-card[data-room-id="${oldId}"]`);
                                        if (card && card.getAttribute('data-occupied') === 'false') {
                                            selectRoom(card);
                                        }
                                    }
                                });
                            </script>

                        </div>
                    </div>

                    <!-- Section 2: Keperluan -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 border-b border-slate-50 pb-4">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h3 class="font-bold text-slate-700">Detail Keperluan</h3>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1" for="purpose">Keperluan Peminjaman</label>
                            <textarea class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('purpose') border-rose-400 ring-rose-400/10 @enderror" id="purpose" name="purpose" rows="3" placeholder="Jelaskan tujuan peminjaman ruangan secara detail..." required>{{ old('purpose') }}</textarea>
                            @error('purpose') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-4">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Waktu Peminjaman</p>
                                <div class="space-y-4">
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-bold text-slate-500 ml-1" for="borrow_date">Tanggal</label>
                                        <input type="date" class="block w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-primary-500/20 outline-none" id="borrow_date" name="borrow_date" value="{{ old('borrow_date') }}" required>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-bold text-slate-500 ml-1" for="borrow_time">Jam Mulai</label>
                                        <input type="time" class="block w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-primary-500/20 outline-none" id="borrow_time" name="borrow_time" value="{{ old('borrow_time') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-4">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Waktu Pengembalian</p>
                                <div class="space-y-4">
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-bold text-slate-500 ml-1" for="return_date">Tanggal</label>
                                        <input type="date" class="block w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-primary-500/20 outline-none" id="return_date" name="return_date" value="{{ old('return_date') }}" required>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-bold text-slate-500 ml-1" for="return_time">Jam Selesai</label>
                                        <input type="time" class="block w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-primary-500/20 outline-none" id="return_time" name="return_time" value="{{ old('return_time') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="flex-1 px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-200 transition-all duration-300 hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane text-sm"></i>
                            Kirim Permohonan
                        </button>
                        <a href="/borrowers" class="px-8 py-4 bg-white border border-slate-200 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 transition-all text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
