@extends('layouts.app')

@section('title', 'Kelola Jadwal')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center shadow-sm">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                Jadwal Pembelajaran
            </h2>
            <p class="text-slate-500 text-sm mt-1 ml-0 sm:ml-13">Pengaturan jadwal rutin penggunaan ruangan kelas/lab.</p>
        </div>
        <div>
            <a href="/schedules/create" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-2xl shadow-lg shadow-primary-200 transition-all duration-300 hover:-translate-y-0.5 active:scale-95 group">
                <i class="fas fa-plus group-hover:rotate-90 transition-transform duration-300"></i>
                Tambah Jadwal
            </a>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest w-20">No</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Ruangan</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Waktu</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Blok</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Kelas</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Guru Pengajar</th>
                        <th class="px-6 py-5 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($schedules as $schedule)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-slate-400">{{ ($schedules->currentPage() - 1) * $schedules->perPage() + $loop->iteration }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-xs font-bold">
                                        <i class="fas fa-chalkboard"></i>
                                    </div>
                                    <span class="text-sm font-bold text-slate-700 group-hover:text-primary-600 transition-colors">{{ $schedule->room->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col items-center">
                                    <span class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-600 uppercase tracking-tight mb-1">
                                        {{ $schedule->day }}
                                    </span>
                                    <span class="text-xs font-medium text-slate-500">{{ $schedule->start_time }} - {{ $schedule->end_time }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                        Blok {{ $schedule->block }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    <span class="text-sm font-semibold text-slate-600">{{ $schedule->class_name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-slate-600">{{ $schedule->teacher_name ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="/schedules/{{ $schedule->id }}/edit" class="p-2 rounded-xl text-amber-500 hover:bg-amber-50 border border-transparent hover:border-amber-100 transition-all duration-200" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/schedules/{{ $schedule->id }}" method="POST" class="inline">
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
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-slate-50 text-slate-300 flex items-center justify-center mb-4">
                                        <i class="fas fa-calendar-times text-2xl"></i>
                                    </div>
                                    <p class="text-slate-400 font-medium">Jadwal belum dikonfigurasi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($schedules->hasPages())
            <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
                {{ $schedules->links() }}
            </div>
        @endif
    </div>
@endsection