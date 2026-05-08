@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="max-w-3xl" x-data="{ showPw: false }">
        <div class="flex items-center gap-4 mb-8">
            <a href="/users" class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-primary-600 hover:border-primary-100 transition-all shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Edit User</h2>
                <p class="text-slate-500 text-sm">Perbarui profil dan hak akses untuk <span class="text-primary-600 font-bold">{{ $user->name }}</span>.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8">
                <form action="/users/{{ $user->id }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col items-center gap-4 pb-4 border-b border-slate-50">
                        <div class="relative group">
                            <div class="w-24 h-24 rounded-full border-4 border-slate-50 shadow-inner overflow-hidden bg-slate-100">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    @php
                                        $roleColor = match($user->role) {
                                            'admin' => 'f43f5e',
                                            'sarpras' => 'f59e0b',
                                            'toolman' => '0ea5e9',
                                            default => '64748b'
                                        };
                                    @endphp
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background={{ $roleColor }}&color=fff" alt="Avatar">
                                @endif
                            </div>
                            <label for="avatar" class="absolute bottom-0 right-0 w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center shadow-lg cursor-pointer transform hover:scale-110 transition-transform border-2 border-white">
                                <i class="fas fa-camera text-[10px]"></i>
                                <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*">
                            </label>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Foto Profil User</p>
                    </div>


                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1" for="name">Nama Lengkap</label>
                        <input type="text" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('name') border-rose-400 ring-rose-400/10 @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1" for="email">Alamat Email</label>
                            <input type="email" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('email') border-rose-400 ring-rose-400/10 @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1" for="phone">Nomor Telepon</label>
                            <input type="text" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('phone') border-rose-400 ring-rose-400/10 @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1" for="password">Password</label>
                        <div class="relative group">
                            <input :type="showPw ? 'text' : 'password'" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('password') border-rose-400 ring-rose-400/10 @enderror" id="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah">
                            <button type="button" @click="showPw = !showPw" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-primary-500 transition-colors">
                                <i class="fas" :class="showPw ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1" for="role">Hak Akses (Role)</label>
                            <select class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('role') border-rose-400 ring-rose-400/10 @enderror" id="role" name="role" required onchange="toggleCategory()">
                                <option value="sarpras" {{ old('role', $user->role) == 'sarpras' ? 'selected' : '' }}>Sarpras</option>
                                <option value="toolman" {{ old('role', $user->role) == 'toolman' ? 'selected' : '' }}>Toolman</option>
                            </select>
                        </div>

                        <div class="space-y-2" id="categoryDiv" style="display: none;">
                            <label class="text-sm font-bold text-slate-700 ml-1" for="category_id">Penempatan Jurusan</label>
                            <select class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('category_id') border-rose-400 ring-rose-400/10 @enderror" id="category_id" name="category_id">
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $user->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1" for="is_active">Status Akun</label>
                        <select class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('is_active') border-rose-400 ring-rose-400/10 @enderror" id="is_active" name="is_active" required>
                            <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="submit" class="flex-1 sm:flex-none px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-200 transition-all duration-300 hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                            <i class="fas fa-save text-sm"></i>
                            Simpan Perubahan
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