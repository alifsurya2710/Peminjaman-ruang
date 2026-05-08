@extends('layouts.app')

@section('title', 'Tambah Jadwal')

@section('content')
    <div class="max-w-4xl">
        <div class="flex items-center gap-4 mb-8">
            <a href="/schedules" class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-primary-600 hover:border-primary-100 transition-all shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Jadwal Pembelajaran</h2>
                <p class="text-slate-500 text-sm">Input jadwal penggunaan ruangan rutin untuk kegiatan KBM.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8">
                <form action="/schedules" method="POST" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1" for="room_id">Ruangan</label>
                                <select class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('room_id') border-rose-400 ring-rose-400/10 @enderror" id="room_id" name="room_id" required>
                                    <option value="">-- Pilih Ruangan --</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            {{ $room->name }} ({{ $room->category->name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1" for="day">Hari Pelaksanaan</label>
                                <select class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('day') border-rose-400 ring-rose-400/10 @enderror" id="day" name="day" required>
                                    <option value="">-- Pilih Hari --</option>
                                    @foreach($days as $day)
                                        <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                                    @endforeach
                                </select>
                                @error('day') <p class="text-xs font-bold text-rose-500 ml-1 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700 ml-1" for="start_time">Jam Mulai</label>
                                    <input type="time" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('start_time') border-rose-400 ring-rose-400/10 @enderror" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700 ml-1" for="end_time">Jam Selesai</label>
                                    <input type="time" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('end_time') border-rose-400 ring-rose-400/10 @enderror" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700 ml-1" for="block">Blok</label>
                                    <select class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('block') border-rose-400 ring-rose-400/10 @enderror" id="block" name="block" required>
                                        <option value="1" {{ old('block') == '1' ? 'selected' : '' }}>Blok 1</option>
                                        <option value="2" {{ old('block') == '2' ? 'selected' : '' }}>Blok 2</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700 ml-1" for="semester">Semester</label>
                                    <select class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('semester') border-rose-400 ring-rose-400/10 @enderror" id="semester" name="semester" required>
                                        <option value="1" {{ old('semester') == '1' ? 'selected' : '' }}>Ganjil (1)</option>
                                        <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>Genap (2)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1" for="class_name">Nama Kelas</label>
                                <input type="text" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('class_name') border-rose-400 ring-rose-400/10 @enderror" id="class_name" name="class_name" value="{{ old('class_name') }}" placeholder="Contoh: X RPL 1">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1" for="teacher_name">Guru Pengajar</label>
                                <input type="text" class="block w-full px-4 py-3 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-700 font-medium placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all @error('teacher_name') border-rose-400 ring-rose-400/10 @enderror" id="teacher_name" name="teacher_name" value="{{ old('teacher_name') }}" placeholder="Nama lengkap guru">
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="flex-1 px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-200 transition-all duration-300 hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                            <i class="fas fa-save text-sm"></i>
                            Simpan Jadwal
                        </button>
                        <a href="/schedules" class="px-8 py-4 bg-white border border-slate-200 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 transition-all text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection