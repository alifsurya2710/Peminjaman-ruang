@extends('layouts.app')
@section('title', 'Pusat Laporan')
@section('content')
<div class="max-w-5xl">
    <div class="space-y-8">

        <!-- Header -->
        <div class="relative overflow-hidden p-8 rounded-[2.5rem] text-white card-3d">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight mb-2 flex items-center gap-3">
                        <span class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center border border-white/20">
                            <i class="fas fa-file-invoice text-white"></i>
                        </span>
                        Pusat Laporan
                    </h1>
                    <p class="text-white/85 font-medium max-w-md">
                        Unduh data sistem dalam format PDF untuk keperluan administrasi dan arsip resmi sekolah.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Laporan Peminjam Ruangan -->
            <div class="group relative">
                <div class="absolute inset-0 bg-emerald-500/5 rounded-3xl blur-2xl group-hover:bg-emerald-500/10 transition-all duration-500"></div>
                <div class="relative bg-white rounded-3xl border border-slate-100 p-8 shadow-sm hover:shadow-xl hover:shadow-emerald-100/50 hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-700"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6 shadow-sm">
                            <i class="fas fa-handshake text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-3">Laporan Peminjam</h3>
                        <p class="text-slate-500 font-medium mb-8 flex-grow">
                            Rekapitulasi seluruh data permohonan peminjaman ruangan, status persetujuan, dan detail waktu penggunaan.
                        </p>
                        <div class="flex flex-col gap-3">
                            <a href="{{ route('reports.borrowers-pdf') }}" target="_blank"
                               class="w-full px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl shadow-lg shadow-emerald-100 transition-all active:scale-95 flex items-center justify-center gap-3">
                                <i class="fas fa-file-pdf"></i>
                                <span>Cetak Laporan PDF</span>
                            </a>
                            <div class="flex items-center justify-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                <i class="fas fa-info-circle text-[8px]"></i> Data diperbarui secara real-time
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan Jadwal -->
            <div class="group relative">
                <div class="absolute inset-0 bg-blue-500/5 rounded-3xl blur-2xl group-hover:bg-blue-500/10 transition-all duration-500"></div>
                <div class="relative bg-white rounded-3xl border border-slate-100 p-8 shadow-sm hover:shadow-xl hover:shadow-blue-100/50 hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-700"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6 shadow-sm">
                            <i class="fas fa-calendar-alt text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-3">Laporan Jadwal</h3>
                        <p class="text-slate-500 font-medium mb-8 flex-grow">
                            Ekspor jadwal pembelajaran rutin yang terdaftar di sistem untuk setiap ruangan dan kategori jurusan.
                        </p>
                        <div class="flex flex-col gap-3">
                            <a href="{{ route('reports.schedules-pdf') }}" target="_blank"
                               class="w-full px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-blue-100 transition-all active:scale-95 flex items-center justify-center gap-3">
                                <i class="fas fa-file-pdf"></i>
                                <span>Cetak Laporan PDF</span>
                            </a>
                            <div class="flex items-center justify-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                <i class="fas fa-info-circle text-[8px]"></i> Filter berdasarkan semester aktif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan Peminjaman Barang (BARU) -->
            <div class="group relative md:col-span-2">
                <div class="absolute inset-0 bg-indigo-500/5 rounded-3xl blur-2xl group-hover:bg-indigo-500/10 transition-all duration-500"></div>
                <div class="relative bg-white rounded-3xl border border-slate-100 p-8 shadow-sm hover:shadow-xl hover:shadow-indigo-100/50 hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-700"></div>
                    <div class="relative z-10 flex flex-col md:flex-row md:items-center gap-8">
                        {{-- Icon + Text --}}
                        <div class="flex-1">
                            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-5 shadow-sm">
                                <i class="fas fa-people-carry-box text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 mb-3">Laporan Peminjaman Barang</h3>
                            <p class="text-slate-500 font-medium">
                                Rekapitulasi seluruh transaksi peminjaman barang (kursi, meja, tenda) beserta informasi
                                <strong>kelas</strong>, <strong>jurusan</strong>, <strong>ruangan</strong>, jumlah, status persetujuan,
                                dan tanggal pengembalian.
                            </p>

                            {{-- Stats --}}
                            @php
                                $total    = \App\Models\ItemBorrowing::count();
                                $pending  = \App\Models\ItemBorrowing::where('status','pending')->count();
                                $approved = \App\Models\ItemBorrowing::where('status','approved')->count();
                                $finished = \App\Models\ItemBorrowing::where('status','finished')->count();
                            @endphp
                            <div class="flex flex-wrap gap-4 mt-5">
                                <div class="text-center">
                                    <p class="text-2xl font-extrabold text-indigo-600">{{ $total }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">Total</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-2xl font-extrabold text-amber-500">{{ $pending }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">Pending</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-2xl font-extrabold text-emerald-500">{{ $approved }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">Disetujui</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-2xl font-extrabold text-slate-500">{{ $finished }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">Selesai</p>
                                </div>
                            </div>
                        </div>

                        {{-- Button --}}
                        <div class="md:w-64 flex flex-col gap-3">
                            <a href="{{ route('reports.item-borrowings-pdf') }}" target="_blank"
                               class="w-full px-6 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 transition-all active:scale-95 flex items-center justify-center gap-3">
                                <i class="fas fa-file-pdf"></i>
                                <span>Cetak Laporan PDF</span>
                            </a>
                            <div class="flex items-center justify-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                <i class="fas fa-boxes text-[8px]"></i> Mencakup semua barang & ruangan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection