@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
    <div class="max-w-4xl mx-auto" x-data="{ 
        showCurrent: false, 
        showNew: false, 
        showConfirm: false,
        newPassword: '',
        get isMin8() { return this.newPassword.length >= 8 },
        get hasUpper() { return /[A-Z]/.test(this.newPassword) },
        get hasLower() { return /[a-z]/.test(this.newPassword) },
        get hasNumber() { return /[0-9]/.test(this.newPassword) },
        get hasSymbol() { return /[@$!%*?&]/.test(this.newPassword) }
    }">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 rounded-2xl bg-primary-600 flex items-center justify-center text-white shadow-lg shadow-primary-200">
                <i class="fas fa-user-edit text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Pengaturan Profil</h2>
                <p class="text-slate-500 text-sm">Kelola informasi pribadi dan keamanan akun Anda.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Avatar Section (Outside main form to avoid nesting) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 text-center sticky top-24">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                        @csrf
                        @method('PUT')
                        <div class="relative inline-block group mb-6">
                            <div class="w-32 h-32 rounded-full border-4 border-slate-50 shadow-inner overflow-hidden bg-slate-100 mx-auto">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-primary-50 text-primary-600 text-3xl font-bold uppercase">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                @endif
                            </div>
                            <label for="avatar" class="absolute bottom-0 right-0 w-10 h-10 bg-primary-600 text-white rounded-full flex items-center justify-center shadow-lg cursor-pointer transform hover:scale-110 transition-transform border-4 border-white">
                                <i class="fas fa-camera text-sm"></i>
                                <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*" onchange="document.getElementById('avatarForm').submit()">
                            </label>
                        </div>
                    </form>

                    <h3 class="font-bold text-slate-800 text-lg">{{ $user->name }}</h3>
                    <p class="text-primary-600 font-bold text-xs uppercase tracking-widest mt-1">{{ $user->role }}</p>

                    @if($user->avatar)
                        <form action="{{ route('profile.avatar.destroy') }}" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-bold text-rose-500 hover:text-rose-600 transition-colors flex items-center justify-center gap-2 mx-auto px-4 py-2 rounded-xl hover:bg-rose-50">
                                <i class="fas fa-trash-alt"></i>
                                Hapus Foto Profil
                            </button>
                        </form>
                    @endif

                    <div class="mt-8 pt-8 border-t border-slate-50 text-left">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Informasi Akun</p>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 text-slate-600">
                                <i class="fas fa-envelope text-slate-400 w-4"></i>
                                <span class="text-sm font-medium truncate">{{ $user->email }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-600">
                                <i class="fas fa-phone text-slate-400 w-4"></i>
                                <span class="text-sm font-medium">{{ $user->phone ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fields Section -->
            <div class="lg:col-span-2 space-y-8">
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-50 flex items-center gap-3">
                            <i class="fas fa-id-card text-primary-500"></i>
                            <h3 class="font-bold text-slate-800">Informasi Dasar</h3>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1" for="name">Nama Lengkap</label>
                                <input type="text" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('name') border-rose-400 @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1" for="email">Alamat Email</label>
                                <input type="email" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('email') border-rose-400 @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-50 flex items-center gap-3">
                            <i class="fas fa-shield-alt text-amber-500"></i>
                            <h3 class="font-bold text-slate-800">Keamanan & Password</h3>
                        </div>
                        <div class="p-8 space-y-6">
                            <p class="text-sm text-slate-500 bg-slate-50 p-4 rounded-2xl border border-slate-100 italic">
                                <i class="fas fa-info-circle mr-2 text-primary-500"></i>
                                Biarkan kosong jika Anda tidak ingin mengubah password.
                            </p>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1" for="current_password">Password Saat Ini</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-key text-slate-400 group-focus-within:text-primary-500 transition-colors"></i>
                                    </div>
                                    <input :type="showCurrent ? 'text' : 'password'" class="block w-full pl-11 pr-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('current_password') border-rose-400 @enderror" id="current_password" name="current_password">
                                    <button type="button" @click="showCurrent = !showCurrent" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-primary-500 transition-colors">
                                        <i class="fas" :class="showCurrent ? 'fa-eye-slash' : 'fa-eye'"></i>
                                    </button>
                                </div>
                                @error('current_password') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700 ml-1" for="new_password">Password Baru</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-slate-400 group-focus-within:text-primary-500 transition-colors"></i>
                                        </div>
                                        <input x-model="newPassword" :type="showNew ? 'text' : 'password'" class="block w-full pl-11 pr-12 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('new_password') border-rose-400 @enderror" id="new_password" name="new_password">
                                        <button type="button" @click="showNew = !showNew" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-primary-500 transition-colors">
                                            <i class="fas" :class="showNew ? 'fa-eye-slash' : 'fa-eye'"></i>
                                        </button>
                                    </div>
                                    @error('new_password') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700 ml-1" for="new_password_confirmation">Konfirmasi Password Baru</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-slate-400 group-focus-within:text-primary-500 transition-colors"></i>
                                        </div>
                                        <input :type="showConfirm ? 'text' : 'password'" class="block w-full pl-11 pr-12 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all" id="new_password_confirmation" name="new_password_confirmation">
                                        <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-primary-500 transition-colors">
                                            <i class="fas" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Real-time Checklist -->
                            <div x-show="newPassword.length > 0" x-transition class="p-5 bg-slate-50 rounded-2xl border border-slate-100 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div class="flex items-center gap-2 text-xs font-bold transition-colors" :class="isMin8 ? 'text-emerald-600' : 'text-slate-400'">
                                    <i class="fas" :class="isMin8 ? 'fa-check-circle' : 'fa-circle-notch animate-spin-slow'"></i>
                                    Minimal 8 karakter
                                </div>
                                <div class="flex items-center gap-2 text-xs font-bold transition-colors" :class="hasUpper ? 'text-emerald-600' : 'text-slate-400'">
                                    <i class="fas" :class="hasUpper ? 'fa-check-circle' : 'fa-circle-notch animate-spin-slow'"></i>
                                    Huruf besar (A-Z)
                                </div>
                                <div class="flex items-center gap-2 text-xs font-bold transition-colors" :class="hasLower ? 'text-emerald-600' : 'text-slate-400'">
                                    <i class="fas" :class="hasLower ? 'fa-check-circle' : 'fa-circle-notch animate-spin-slow'"></i>
                                    Huruf kecil (a-z)
                                </div>
                                <div class="flex items-center gap-2 text-xs font-bold transition-colors" :class="hasNumber ? 'text-emerald-600' : 'text-slate-400'">
                                    <i class="fas" :class="hasNumber ? 'fa-check-circle' : 'fa-circle-notch animate-spin-slow'"></i>
                                    Angka (0-9)
                                </div>
                                <div class="flex items-center gap-2 text-xs font-bold transition-colors" :class="hasSymbol ? 'text-emerald-600' : 'text-slate-400'">
                                    <i class="fas" :class="hasSymbol ? 'fa-check-circle' : 'fa-circle-notch animate-spin-slow'"></i>
                                    Simbol (@$!%*?&)
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-white border border-slate-200 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 transition-all flex items-center justify-center gap-2">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-200 transition-all duration-300 hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                            <i class="fas fa-save text-sm"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
