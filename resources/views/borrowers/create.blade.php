@extends('layouts.app')

@section('title', 'Tambah Peminjam')

@section('content')
    <div class="max-w-4xl">
        <div class="flex items-center gap-4 mb-8">
            <a href="/borrowers" class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-primary-600 hover:border-primary-100 transition-all shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Peminjam Baru</h2>
                <p class="text-slate-500 text-sm">Silakan isi detail permohonan peminjaman ruangan di bawah ini.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8">
                <form action="/borrowers" method="POST" class="space-y-8">
                    @csrf

                    <!-- Section 1: Identitas -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 border-b border-slate-50 pb-4">
                            <div class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-sm">
                                <i class="fas fa-user"></i>
                            </div>
                            <h3 class="font-bold text-slate-700">Identitas Peminjam</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1" for="name">Nama Lengkap</label>
                                <input type="text" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('name') border-rose-400 ring-rose-400/10 @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Alif Surya" required>
                                @error('name') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1" for="phone">Nomor Telepon / WA</label>
                                <input type="text" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('phone') border-rose-400 ring-rose-400/10 @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                                @error('phone') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1" for="class_name">Kelas / Jurusan</label>
                                <input type="text" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('class_name') border-rose-400 ring-rose-400/10 @enderror" id="class_name" name="class_name" value="{{ old('class_name') }}" placeholder="Contoh: 12-RPL 1">
                                @error('class_name') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1" for="room_id">Ruangan Yang Dipinjam</label>
                                <select class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('room_id') border-rose-400 ring-rose-400/10 @enderror" id="room_id" name="room_id" required>
                                    <option value="">-- Pilih Ruangan --</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            {{ $room->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Keperluan -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 border-b border-slate-50 pb-4">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h3 class="font-bold text-slate-700">Detail Keperluan</h3>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1" for="purpose">Keperluan Peminjaman</label>
                            <textarea class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('purpose') border-rose-400 ring-rose-400/10 @enderror" id="purpose" name="purpose" rows="3" placeholder="Jelaskan tujuan peminjaman ruangan secara detail..." required>{{ old('purpose') }}</textarea>
                            @error('purpose') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-4">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Waktu Peminjaman</p>
                                <div class="space-y-4">
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-bold text-slate-500 ml-1" for="borrow_date">Tanggal</label>
                                        <input type="date" class="block w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-primary-500/20 outline-none" id="borrow_date" name="borrow_date" value="{{ old('borrow_date') }}" required>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-bold text-slate-500 ml-1" for="borrow_time">Jam Mulai</label>
                                        <input type="time" class="block w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-primary-500/20 outline-none" id="borrow_time" name="borrow_time" value="{{ old('borrow_time') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 space-y-4">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Waktu Pengembalian</p>
                                <div class="space-y-4">
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-bold text-slate-500 ml-1" for="return_date">Tanggal</label>
                                        <input type="date" class="block w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-primary-500/20 outline-none" id="return_date" name="return_date" value="{{ old('return_date') }}" required>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-bold text-slate-500 ml-1" for="return_time">Jam Selesai</label>
                                        <input type="time" class="block w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-primary-500/20 outline-none" id="return_time" name="return_time" value="{{ old('return_time') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="flex-1 px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-200 transition-all duration-300 hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane text-sm"></i>
                            Kirim Permohonan
                        </button>
                        <a href="/borrowers" class="px-8 py-4 bg-white border border-slate-200 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 transition-all text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
