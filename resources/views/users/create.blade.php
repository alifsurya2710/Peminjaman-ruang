@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
    <div class="max-w-3xl" x-data="{ 
        showPw: false, 
        showConfirm: false,
        password: '',
        get rules() {
            return {
                length: this.password.length >= 8,
                upper: /[A-Z]/.test(this.password),
                lower: /[a-z]/.test(this.password),
                number: /\d/.test(this.password),
                symbol: /[@$!%*?&]/.test(this.password)
            }
        }
    }">
        <div class="flex items-center gap-4 mb-8">
            <a href="/users" class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-primary-600 hover:border-primary-100 transition-all shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah User Baru</h2>
                <p class="text-slate-500 text-sm">Berikan hak akses sistem kepada personil sekolah.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8">
                <form action="/users" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="flex flex-col items-center gap-4 pb-4 border-b border-slate-50">
                        <div class="relative group">
                            <div class="w-24 h-24 rounded-full border-4 border-slate-50 shadow-inner overflow-hidden bg-slate-100 flex items-center justify-center">
                                <i class="fas fa-user text-slate-300 text-4xl"></i>
                            </div>
                            <label for="avatar" class="absolute bottom-0 right-0 w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center shadow-lg cursor-pointer transform hover:scale-110 transition-transform border-2 border-white">
                                <i class="fas fa-camera text-[10px]"></i>
                                <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*">
                            </label>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Unggah Foto (Opsional)</p>
                    </div>


                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1" for="name">Nama Lengkap</label>
                        <input type="text" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('name') border-rose-400 ring-rose-400/10 @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required>
                        @error('name') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1" for="email">Alamat Email</label>
                            <input type="email" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('email') border-rose-400 ring-rose-400/10 @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="name@school.id" required>
                            @error('email') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1" for="phone">Nomor Telepon</label>
                            <input type="text" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('phone') border-rose-400 ring-rose-400/10 @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1" for="password">Password</label>
                            <div class="relative group">
                                <input :type="showPw ? 'text' : 'password'" 
                                       class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('password') border-rose-400 ring-rose-400/10 @enderror" 
                                       id="password" name="password" x-model="password" required>
                                <button type="button" @click="showPw = !showPw" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-primary-500 transition-colors">
                                    <i class="fas" :class="showPw ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1" for="password_confirmation">Konfirmasi Password</label>
                            <div class="relative group">
                                <input :type="showConfirm ? 'text' : 'password'" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all" id="password_confirmation" name="password_confirmation" required>
                                <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-primary-500 transition-colors">
                                    <i class="fas" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100" x-show="password.length > 0">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Validasi Password:</p>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-1">
                            <li class="text-[11px] flex items-center gap-2 transition-colors duration-300" :class="rules.length ? 'text-emerald-600' : 'text-rose-500'">
                                <i class="fas" :class="rules.length ? 'fa-check-circle' : 'fa-times-circle'"></i> Minimal 8 karakter
                            </li>
                            <li class="text-[11px] flex items-center gap-2 transition-colors duration-300" :class="rules.upper ? 'text-emerald-600' : 'text-rose-500'">
                                <i class="fas" :class="rules.upper ? 'fa-check-circle' : 'fa-times-circle'"></i> Huruf besar (A-Z)
                            </li>
                            <li class="text-[11px] flex items-center gap-2 transition-colors duration-300" :class="rules.lower ? 'text-emerald-600' : 'text-rose-500'">
                                <i class="fas" :class="rules.lower ? 'fa-check-circle' : 'fa-times-circle'"></i> Huruf kecil (a-z)
                            </li>
                            <li class="text-[11px] flex items-center gap-2 transition-colors duration-300" :class="rules.number ? 'text-emerald-600' : 'text-rose-500'">
                                <i class="fas" :class="rules.number ? 'fa-check-circle' : 'fa-times-circle'"></i> Angka (0-9)
                            </li>
                            <li class="text-[11px] flex items-center gap-2 transition-colors duration-300" :class="rules.symbol ? 'text-emerald-600' : 'text-rose-500'">
                                <i class="fas" :class="rules.symbol ? 'fa-check-circle' : 'fa-times-circle'"></i> Simbol (@$!%*?&)
                            </li>
                        </ul>
                        @error('password') <p class="text-xs font-bold text-rose-500 mt-2">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1" for="role">Hak Akses (Role)</label>
                            <select class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('role') border-rose-400 ring-rose-400/10 @enderror" id="role" name="role" required onchange="toggleCategory()">
                                <option value="">-- Pilih Role --</option>
                                <option value="sarpras" {{ old('role') == 'sarpras' ? 'selected' : '' }}>Sarpras</option>
                                <option value="toolman" {{ old('role') == 'toolman' ? 'selected' : '' }}>Toolman</option>
                            </select>
                            @error('role') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2 transition-all duration-300" id="categoryDiv" style="display: none;">
                            <label class="text-sm font-bold text-slate-700 ml-1" for="category_id">Penempatan Jurusan</label>
                            <select class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('category_id') border-rose-400 ring-rose-400/10 @enderror" id="category_id" name="category_id">
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="submit" class="flex-1 sm:flex-none px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-200 transition-all duration-300 hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                            <i class="fas fa-save text-sm"></i>
                            Simpan User
                        </button>
                        <a href="/users" class="flex-1 sm:flex-none px-8 py-4 bg-white border border-slate-200 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 transition-all flex items-center justify-center gap-2">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleCategory() {
            const role = document.getElementById('role').value;
            const categoryDiv = document.getElementById('categoryDiv');
            const categorySelect = document.getElementById('category_id');

            if (role === 'toolman') {
                categoryDiv.style.display = 'block';
                categorySelect.required = true;
            } else {
                categoryDiv.style.display = 'none';
                categorySelect.required = false;
            }
        }

        document.addEventListener('DOMContentLoaded', toggleCategory);
    </script>
@endsection