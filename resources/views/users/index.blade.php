@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="relative overflow-hidden p-8 rounded-[2.5rem] bg-gradient-to-br from-slate-900 to-slate-800 text-white shadow-2xl shadow-slate-200">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-primary-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 bg-rose-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight mb-2 flex items-center gap-3">
                        <span class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-md border border-white/10">
                            <i class="fas fa-users text-primary-400"></i>
                        </span>
                        Kelola Pengguna
                    </h1>
                    <p class="text-slate-400 font-medium max-w-md">
                        Manajemen hak akses, profil pengguna, dan kontrol keamanan sistem dalam satu panel.
                    </p>
                </div>
                
                <a href="/users/create" class="group flex items-center gap-3 px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white rounded-2xl transition-all duration-300 font-bold text-sm shadow-lg shadow-primary-900/20">
                    <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
                    Tambah User Baru
                </a>
            </div>
        </div>


        <!-- Table Section -->
        <div class="bg-white/60 backdrop-blur-xl rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest w-20">No</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Pengguna</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Role & Status</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Kategori</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Kontak</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-slate-400">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full border-2 border-white shadow-sm overflow-hidden ring-2 ring-slate-100 flex items-center justify-center bg-slate-100">
                                        @php
                                            $roleColor = match($user->role) {
                                                'admin' => 'f43f5e',
                                                'sarpras' => 'f59e0b',
                                                'toolman' => '0ea5e9',
                                                default => '64748b'
                                            };
                                        @endphp
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background={{ $roleColor }}&color=fff" alt="Avatar">
                                        @endif
                                    </div>

                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-700 group-hover:text-primary-600 transition-colors">{{ $user->name }}</span>
                                        <span class="text-xs text-slate-400 font-medium">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col items-center gap-1.5">
                                    @if($user->role == 'admin')
                                        <span class="px-3 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-100">Admin</span>
                                    @elseif($user->role == 'sarpras')
                                        <span class="px-3 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-600 border border-amber-100">Sarpras</span>
                                    @else
                                        <span class="px-3 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-sky-50 text-sky-600 border border-sky-100">Toolman</span>
                                    @endif
                                    
                                    @if($user->is_active)
                                        <span class="flex items-center gap-1 text-[10px] font-bold text-emerald-500 uppercase tracking-tight">
                                            <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="flex items-center gap-1 text-[10px] font-bold text-slate-300 uppercase tracking-tight">
                                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-slate-600">{{ $user->category->name ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-slate-600 italic">{{ $user->phone ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="/users/{{ $user->id }}/edit" class="p-2 rounded-xl text-amber-500 hover:bg-amber-50 border border-transparent hover:border-amber-100 transition-all duration-200" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/users/{{ $user->id }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl text-rose-500 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition-all duration-200" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-slate-50 text-slate-300 flex items-center justify-center mb-4">
                                        <i class="fas fa-user-slash text-2xl"></i>
                                    </div>
                                    <p class="text-slate-400 font-medium">Tidak ada data pengguna ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
                {{ $users->links() }}
            </div>
        @endif
        </div>
    </div>
@endsection