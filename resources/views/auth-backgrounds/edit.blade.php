@extends('layouts.app')

@section('title', 'Edit Background')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('auth-backgrounds.index') }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-primary-600 hover:border-primary-100 transition-all shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Background</h2>
            <p class="text-slate-500 text-sm">Perbarui detail atau ganti gambar latar belakang halaman autentikasi.</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 md:p-12">
            <form action="{{ route('auth-backgrounds.update', $authBackground) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Name Input -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1" for="name">Nama Background</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $authBackground->name) }}" required class="block w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all" placeholder="Contoh: Gedung SMKN 1 Katapang Depan">
                    @error('name')
                        <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Upload with Alpine Preview -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">File Gambar Latar Belakang (Biarkan kosong jika tidak ingin diubah)</label>
                    <div x-data="{ 
                        preview: '{{ asset('storage/' . $authBackground->image) }}',
                        initialPreview: '{{ asset('storage/' . $authBackground->image) }}'
                    }" class="relative">
                        <input type="file" id="image" name="image" accept="image/*" @change="
                            const file = $event.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = (e) => { preview = e.target.result };
                                reader.readAsDataURL(file);
                            }
                        " class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="border-2 border-dashed border-slate-200 rounded-[2rem] p-12 flex flex-col items-center justify-center bg-slate-50/50 group-hover:bg-white transition-colors" :class="preview ? 'hidden' : 'flex'">
                            <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center shadow-sm text-slate-400 mb-4">
                                <i class="fas fa-image text-2xl"></i>
                            </div>
                            <p class="text-sm font-bold text-slate-600">Klik atau seret file gambar ke sini</p>
                            <p class="text-xs text-slate-400 mt-2">JPEG, JPG, PNG, atau WEBP (Maks. 10MB)</p>
                        </div>
                        <div x-show="preview" class="relative rounded-3xl overflow-hidden shadow-lg border border-slate-100 bg-white p-2" x-cloak>
                            <img :src="preview" class="w-full h-64 object-contain rounded-2xl">
                            <!-- Toggle button to reset back to initial or clear -->
                            <button type="button" @click="
                                if (preview !== initialPreview) {
                                    preview = initialPreview;
                                    document.getElementById('image').value = '';
                                }
                            " x-show="preview !== initialPreview" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-amber-500 text-white flex items-center justify-center hover:bg-amber-600 shadow-lg cursor-pointer" title="Batalkan Perubahan Gambar">
                                <i class="fas fa-undo"></i>
                            </button>
                        </div>
                    </div>
                    @error('image')
                        <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status Toggles -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                    <!-- Login Active Checkbox Card -->
                    <label class="relative flex items-start gap-4 p-5 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-slate-50 transition-all cursor-pointer">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="is_active_login" name="is_active_login" value="1" {{ old('is_active_login', $authBackground->is_active_login) ? 'checked' : '' }} class="w-5 h-5 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                        </div>
                        <div class="text-sm">
                            <span class="block font-bold text-slate-800">Aktifkan untuk Login</span>
                            <span class="block text-slate-500 text-xs mt-1">Set gambar ini sebagai latar belakang utama halaman login.</span>
                        </div>
                    </label>

                    <!-- Forgot Password Active Checkbox Card -->
                    <label class="relative flex items-start gap-4 p-5 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-slate-50 transition-all cursor-pointer">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="is_active_forgot_password" name="is_active_forgot_password" value="1" {{ old('is_active_forgot_password', $authBackground->is_active_forgot_password) ? 'checked' : '' }} class="w-5 h-5 rounded text-cyan-600 focus:ring-cyan-500 border-slate-300">
                        </div>
                        <div class="text-sm">
                            <span class="block font-bold text-slate-800">Aktifkan untuk Lupa Password</span>
                            <span class="block text-slate-500 text-xs mt-1">Set gambar ini sebagai latar belakang utama halaman lupa password.</span>
                        </div>
                    </label>
                </div>

                <!-- Action buttons -->
                <div class="pt-6 flex gap-4">
                    <button type="submit" class="flex-1 py-4 px-8 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-200 transition-all hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3 cursor-pointer">
                        <i class="fas fa-check"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('auth-backgrounds.index') }}" class="px-8 py-4 bg-white border border-slate-200 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 transition-all flex items-center justify-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
