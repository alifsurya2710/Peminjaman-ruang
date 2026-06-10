@extends('layouts.app')
@section('title', 'Ubah Status Peminjaman')

@section('content')
<div class="max-w-2xl mx-auto space-y-8">
    <div class="flex items-center gap-4">
        <a href="/item_borrowings" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-300 shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Ubah Status Peminjaman</h1>
            <p class="text-sm font-medium text-slate-500">Edit status peminjaman barang dan cek stok</p>
        </div>
    </div>

    <form action="/item_borrowings/{{ $itemBorrowing->id }}" method="POST" class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm">
        @csrf
        @method('PUT')
        
        <div class="mb-6 p-4 rounded-xl border border-slate-100 bg-slate-50">
            <h3 class="text-sm font-extrabold text-slate-700 mb-3 uppercase tracking-widest border-b border-slate-200 pb-2">Detail Peminjaman</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Peminjam</p>
                    <p class="text-sm font-bold text-slate-800">{{ $itemBorrowing->borrower_name }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Kelas / Jurusan</p>
                    <p class="text-sm font-bold text-slate-800">
                        {{ $itemBorrowing->class_name ?? '-' }}
                        @if($itemBorrowing->department)
                            <span class="text-slate-500 font-medium">/ {{ $itemBorrowing->department }}</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Barang</p>
                    <p class="text-sm font-bold text-slate-800">{{ $itemBorrowing->item->name }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Jumlah</p>
                    <p class="text-sm font-bold text-slate-800">{{ $itemBorrowing->amount }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Tanggal</p>
                    <p class="text-sm font-bold text-slate-800">{{ $itemBorrowing->borrow_date->format('d M') }} - {{ $itemBorrowing->return_date->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Stok Tersedia Saat Ini</p>
                    <p class="text-sm font-bold text-indigo-600">{{ $itemBorrowing->item->available_stock }}</p>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div>
                <label for="status" class="block text-sm font-bold text-slate-700 mb-2">Status <span class="text-rose-500">*</span></label>
                <select name="status" id="status" required 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all text-slate-700 bg-slate-50 focus:bg-white font-medium">
                    <option value="pending" {{ $itemBorrowing->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $itemBorrowing->status == 'approved' ? 'selected' : '' }}>Disetujui (Stok akan berkurang)</option>
                    <option value="rejected" {{ $itemBorrowing->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    <option value="finished" {{ $itemBorrowing->status == 'finished' ? 'selected' : '' }}>Selesai (Stok akan dikembalikan)</option>
                </select>
                <p class="mt-2 text-xs text-slate-500"><i class="fas fa-info-circle mr-1"></i> Mengubah status menjadi <b>Disetujui</b> akan mengurangi stok barang secara otomatis. Mengubahnya menjadi <b>Selesai</b> akan mengembalikan stok barang.</p>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-500/30 transition-all duration-300 active:scale-[0.98]">
                    <i class="fas fa-save mr-2"></i> Update Status
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
