@extends('layouts.app')

@section('title', 'Tambah Denah')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('floor-plans.index') }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-primary-600 hover:border-primary-100 transition-all shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Denah Baru</h2>
                <p class="text-slate-500 text-sm">Upload foto denah sekolah atau gedung baru.</p>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8 md:p-12">
                <form action="{{ route('floor-plans.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1" for="title">Judul Denah</label>
                        <input type="text" id="title" name="title" required
                               class="block w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all"
                               placeholder="Contoh: Denah Lantai 1 Gedung Utama">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">File Denah (Foto atau PDF)</label>
                        <div x-data="{ preview: null, isPdf: false }" class="relative">
                            <input type="file" id="image" name="image" required
                                   @change="
                                    const file = $event.target.files[0]; 
                                    if (file) { 
                                        isPdf = file.type === 'application/pdf';
                                        if (isPdf) {
                                            preview = true;
                                        } else {
                                            const reader = new FileReader(); 
                                            reader.onload = (e) => { preview = e.target.result }; 
                                            reader.readAsDataURL(file);
                                        }
                                    }
                                   "
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
                            <div class="border-2 border-dashed border-slate-200 rounded-[2rem] p-12 flex flex-col items-center justify-center bg-slate-50/50 group-hover:bg-white transition-colors"
                                 :class="preview ? 'hidden' : 'flex'">
                                <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center shadow-sm text-slate-400 mb-4">
                                    <i class="fas fa-file-upload text-2xl"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-600">Klik atau seret file ke sini</p>
                                <p class="text-xs text-slate-400 mt-2">JPG, PNG, atau PDF (Maks. 10MB)</p>
                            </div>

                            <div x-show="preview" class="relative rounded-3xl overflow-hidden shadow-lg border border-slate-100 bg-white p-2">
                                <template x-if="!isPdf">
                                    <img :src="preview" class="w-full h-64 object-contain rounded-2xl">
                                </template>
                                <template x-if="isPdf">
                                    <div class="w-full h-64 flex flex-col items-center justify-center bg-slate-50 rounded-2xl text-rose-500">
                                        <i class="fas fa-file-pdf text-7xl mb-2"></i>
                                        <span class="text-sm font-bold">File PDF Terpilih</span>
                                    </div>
                                </template>
                                <button type="button" @click="preview = null; isPdf = false; document.getElementById('image').value = ''" 
                                        class="absolute top-4 right-4 w-10 h-10 rounded-full bg-rose-500 text-white flex items-center justify-center hover:bg-rose-600 shadow-lg">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        @error('image')
                            <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1" for="description">Deskripsi Singkat (Opsional)</label>
                        <textarea id="description" name="description" rows="3"
                                  class="block w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all"
                                  placeholder="Tambahkan informasi tambahan jika diperlukan..."></textarea>
                    </div>

                    <div class="pt-6 flex gap-4">
                        <button type="submit" class="flex-1 py-4 px-8 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-200 transition-all hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3">
                            <i class="fas fa-check"></i>
                            Simpan Denah
                        </button>
                        <a href="{{ route('floor-plans.index') }}" class="px-8 py-4 bg-white border border-slate-200 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 transition-all flex items-center justify-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
