@extends('layouts.app')
@section('title', 'Edit Barang')

@section('content')
<div class="max-w-2xl mx-auto space-y-8">
    <div class="flex items-center gap-4">
        <a href="/items" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-primary-600 transition-all duration-300 shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">Edit Barang</h1>
            <p class="text-sm font-medium text-slate-500">Ubah data barang</p>
        </div>
    </div>

    <form action="/items/{{ $item->id }}" method="POST" class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm">
        @csrf
        @method('PUT')
        <div class="space-y-6">

            <div>
                <label for="room_id" class="block text-sm font-bold text-slate-700 mb-2">
                    <i class="fas fa-door-open text-slate-400 mr-1"></i> Ruangan
                    <span class="text-slate-400 font-normal text-xs ml-1">(opsional)</span>
                </label>
                <select name="room_id" id="room_id"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-primary-50 focus:border-primary-500 transition-all text-slate-700 bg-slate-50 focus:bg-white font-medium">
                    <option value="">— Tidak terikat ruangan —</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id', $item->room_id) == $room->id ? 'selected' : '' }}>
                            {{ $room->name }} ({{ $room->category->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Barang <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $item->name) }}" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-primary-50 focus:border-primary-500 transition-all text-slate-700 bg-slate-50 focus:bg-white placeholder-slate-400 font-medium">
            </div>

            <div>
                <label for="total_stock" class="block text-sm font-bold text-slate-700 mb-2">Total Stok <span class="text-rose-500">*</span></label>
                <input type="number" name="total_stock" id="total_stock" value="{{ old('total_stock', $item->total_stock) }}" min="0" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-primary-50 focus:border-primary-500 transition-all text-slate-700 bg-slate-50 focus:bg-white font-medium">
                <p class="mt-1.5 text-xs text-slate-500"><i class="fas fa-info-circle mr-1"></i> Sedang dipinjam: <span class="font-bold">{{ $item->total_stock - $item->available_stock }}</span> unit.</p>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <button type="submit" class="w-full py-4 bg-primary-600 hover:bg-primary-500 text-white rounded-xl font-bold text-sm shadow-lg shadow-primary-500/30 transition-all duration-300 active:scale-[0.98]">
                    <i class="fas fa-save mr-2"></i> Update Data Barang
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
