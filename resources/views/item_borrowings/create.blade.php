@extends('layouts.app')
@section('title', 'Peminjaman Barang Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-8">
    <div class="flex items-center gap-4">
        <a href="/item_borrowings" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-primary-600 transition-all duration-300 shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Peminjaman Baru</h1>
            <p class="text-sm font-medium text-slate-500">Form pengajuan peminjaman barang</p>
        </div>
    </div>

    <form action="/item_borrowings" method="POST" class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm">
        @csrf
        <div class="space-y-6">

            {{-- Nama Peminjam --}}
            <div>
                <label for="borrower_name" class="block text-sm font-bold text-slate-700 mb-2">Nama Peminjam <span class="text-rose-500">*</span></label>
                <input type="text" name="borrower_name" id="borrower_name" value="{{ old('borrower_name') }}" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-primary-50 focus:border-primary-500 transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 font-medium"
                       placeholder="Misal: Budi Santoso">
            </div>

            {{-- Kelas & Jurusan --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="class_name" class="block text-sm font-bold text-slate-700 mb-2">Kelas</label>
                    <input type="text" name="class_name" id="class_name" value="{{ old('class_name') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-primary-50 focus:border-primary-500 transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 font-medium"
                           placeholder="Misal: XII, XI, X">
                </div>
                <div>
                    <label for="department" class="block text-sm font-bold text-slate-700 mb-2">Jurusan</label>
                    <input type="text" name="department" id="department" value="{{ old('department') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-primary-50 focus:border-primary-500 transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 font-medium"
                           placeholder="Misal: TJKT, RPL, Mesin">
                </div>
            </div>

            {{-- Tujuan --}}
            <div>
                <label for="purpose" class="block text-sm font-bold text-slate-700 mb-2">Tujuan Peminjaman <span class="text-rose-500">*</span></label>
                <input type="text" name="purpose" id="purpose" value="{{ old('purpose') }}" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-primary-50 focus:border-primary-500 transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 font-medium"
                       placeholder="Misal: Acara Rapat Osis">
            </div>

            {{-- FILTER RUANGAN - desain sama dengan Kelola Peminjam --}}
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-5 space-y-4">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-50">
                    <div class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-sm">
                        <i class="fas fa-filter"></i>
                    </div>
                    <h3 class="font-bold text-slate-700">Filter Barang Berdasarkan Ruangan</h3>
                </div>

                <div x-data="{
                    open: false,
                    selected: '',
                    label: 'Semua Ruangan',
                    rooms: {
                        '': 'Semua Ruangan',
                        'none': 'Tanpa Ruangan',
                        @foreach($rooms as $room)
                        '{{ $room->id }}': '{{ addslashes($room->name) }}',
                        @endforeach
                    },
                    selectRoom(val, lbl) {
                        this.selected = val;
                        this.label = lbl;
                        this.open = false;
                        filterItems(val);
                    }
                }" class="relative">
                    <label class="text-xs font-bold text-slate-500 ml-1 block mb-1.5">Ruangan</label>
                    <button type="button"
                            @click="open = !open"
                            @click.away="open = false"
                            class="flex items-center justify-between w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-bold focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all text-left shadow-sm">
                        <span x-text="label"></span>
                        <i class="fas fa-chevron-down text-[10px] text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" style="display:none;" x-transition.opacity.duration.200ms
                         class="absolute z-50 w-full mt-2 bg-white border border-slate-200 rounded-xl shadow-xl max-h-52 overflow-y-auto py-2">
                        <div @click="selectRoom('', 'Semua Ruangan')"
                             class="px-4 py-2 text-xs font-bold hover:bg-slate-50 cursor-pointer transition-colors"
                             :class="selected === '' ? 'text-primary-600 bg-primary-50/50' : 'text-slate-600'">
                            Semua Ruangan
                        </div>
                        <div @click="selectRoom('none', 'Tanpa Ruangan')"
                             class="px-4 py-2 text-xs font-bold hover:bg-slate-50 cursor-pointer transition-colors"
                             :class="selected === 'none' ? 'text-primary-600 bg-primary-50/50' : 'text-slate-600'">
                            Tanpa Ruangan
                        </div>
                        @foreach($rooms as $room)
                        <div @click="selectRoom('{{ $room->id }}', '{{ addslashes($room->name) }}')"
                             class="px-4 py-2 text-xs font-bold hover:bg-slate-50 cursor-pointer transition-colors"
                             :class="selected === '{{ $room->id }}' ? 'text-primary-600 bg-primary-50/50' : 'text-slate-600'">
                            {{ $room->name }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Barang yang Dipinjam --}}
            <div>
                <label for="item_id" class="block text-sm font-bold text-slate-700 mb-2">Barang yang Dipinjam <span class="text-rose-500">*</span></label>
                <select name="item_id" id="item_id" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-primary-50 focus:border-primary-500 transition-all text-slate-700 bg-slate-50 focus:bg-white font-medium">
                    <option value="" disabled selected>Pilih Barang</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id }}"
                                data-room="{{ $item->room_id ?? 'none' }}"
                                {{ old('item_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                            @if($item->room) — {{ $item->room->name }}@endif
                            (Tersedia: {{ $item->available_stock }})
                        </option>
                    @endforeach
                </select>
                <div id="no-items-msg" class="hidden mt-2 text-xs font-bold text-amber-500">
                    <i class="fas fa-exclamation-triangle mr-1"></i> Tidak ada barang tersedia untuk ruangan ini.
                </div>
                @if($items->isEmpty())
                    <p class="mt-2 text-xs font-bold text-rose-500">Semua barang sedang habis atau belum ditambahkan!</p>
                @endif
            </div>

            {{-- Jumlah --}}
            <div>
                <label for="amount" class="block text-sm font-bold text-slate-700 mb-2">Jumlah <span class="text-rose-500">*</span></label>
                <input type="number" name="amount" id="amount" value="{{ old('amount', 1) }}" min="1" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-primary-50 focus:border-primary-500 transition-all text-slate-700 bg-slate-50 focus:bg-white font-medium">
            </div>

            {{-- Tanggal --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="borrow_date" class="block text-sm font-bold text-slate-700 mb-2">Tanggal Pinjam <span class="text-rose-500">*</span></label>
                    <input type="date" name="borrow_date" id="borrow_date" value="{{ old('borrow_date') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-primary-50 focus:border-primary-500 transition-all text-slate-700 bg-slate-50 focus:bg-white font-medium">
                </div>
                <div>
                    <label for="return_date" class="block text-sm font-bold text-slate-700 mb-2">Tanggal Kembali <span class="text-rose-500">*</span></label>
                    <input type="date" name="return_date" id="return_date" value="{{ old('return_date') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-primary-50 focus:border-primary-500 transition-all text-slate-700 bg-slate-50 focus:bg-white font-medium">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <button type="submit" class="w-full py-4 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold text-sm shadow-lg shadow-slate-900/20 transition-all duration-300 active:scale-[0.98]">
                    <i class="fas fa-save mr-2"></i> Ajukan Peminjaman
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function filterItems(selectedRoom) {
        const itemSelect  = document.getElementById('item_id');
        const noItemsMsg  = document.getElementById('no-items-msg');
        const allOptions  = Array.from(itemSelect.querySelectorAll('option[data-room]'));
        let visibleCount  = 0;

        // Reset selection
        itemSelect.value = '';

        allOptions.forEach(opt => {
            const roomVal = opt.getAttribute('data-room');
            const show = !selectedRoom
                || (selectedRoom === 'none' && roomVal === 'none')
                || (selectedRoom !== '' && selectedRoom !== 'none' && roomVal === selectedRoom);

            opt.style.display = show ? '' : 'none';
            opt.disabled = !show;
            if (show) visibleCount++;
        });

        noItemsMsg.classList.toggle('hidden', visibleCount > 0);
    }
</script>
@endsection
