@extends('layouts.app')

@section('title', 'Edit Ruangan')

@section('content')
    <div class="max-w-3xl">
        <div class="flex items-center gap-4 mb-8">
            <a href="/rooms" class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-primary-600 hover:border-primary-100 transition-all shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Ruangan</h2>
                <p class="text-slate-500 text-sm">Perbarui informasi ruangan <span class="text-primary-600 font-bold">{{ $room->name }}</span>.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8">
                <form action="/rooms/{{ $room->id }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1" for="category_id">Kategori Ruangan</label>
                            <div class="relative">
                                <select class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('category_id') border-rose-400 ring-rose-400/10 @enderror" id="category_id" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $room->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id')
                                <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1" for="name">Nama Ruangan</label>
                            <input type="text" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('name') border-rose-400 ring-rose-400/10 @enderror" id="name" name="name" value="{{ old('name', $room->name) }}" placeholder="Contoh: Lab RPL 1" required>
                            @error('name')
                                <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1" for="capacity">Kapasitas (Orang)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-users text-slate-300"></i>
                            </div>
                            <input type="number" class="block w-full pl-11 pr-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('capacity') border-rose-400 ring-rose-400/10 @enderror" id="capacity" name="capacity" value="{{ old('capacity', $room->capacity) }}" placeholder="0" required>
                        </div>
                        @error('capacity')
                            <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1" for="description">Deskripsi Ruangan</label>
                        <textarea class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('description') border-rose-400 ring-rose-400/10 @enderror" id="description" name="description" rows="4" placeholder="Jelaskan fasilitas atau kondisi ruangan...">{{ old('description', $room->description) }}</textarea>
                        @error('description')
                            <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="submit" class="flex-1 sm:flex-none px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-200 transition-all duration-300 hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>
                        <a href="/rooms" class="flex-1 sm:flex-none px-8 py-4 bg-white border border-slate-200 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 transition-all flex items-center justify-center gap-2">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection