@extends('layouts.app')

@section('title', 'Pusat Laporan')

@section('content')
    <div class="max-w-5xl">
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="relative overflow-hidden p-8 rounded-[2.5rem] bg-gradient-to-br from-slate-900 to-slate-800 text-white shadow-2xl shadow-slate-200">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-primary-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 bg-rose-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight mb-2 flex items-center gap-3">
                        <span class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-md border border-white/10">
                            <i class="fas fa-file-invoice text-primary-400"></i>
                        </span>
                        Pusat Laporan
                    </h1>
                    <p class="text-slate-400 font-medium max-w-md">
                        Unduh data sistem dalam format PDF untuk keperluan administrasi dan arsip resmi sekolah.
                    </p>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Laporan Peminjam -->
            <div class="group relative">
                <div class="absolute inset-0 bg-primary-500/5 rounded-3xl blur-2xl group-hover:bg-primary-500/10 transition-all duration-500"></div>
                <div class="relative bg-white rounded-3xl border border-slate-100 p-8 shadow-sm hover:shadow-xl hover:shadow-primary-100/50 hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                    <!-- Background Decoration -->
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-700"></div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6 shadow-sm">
                            <i class="fas fa-handshake text-2xl"></i>
                        </div>
                        
                        <h3 class="text-xl font-bold text-slate-800 mb-3">Laporan Peminjam</h3>
                        <p class="text-slate-500 font-medium mb-8 flex-grow">
                            Rekapitulasi seluruh data permohonan peminjaman ruangan, status persetujuan, dan detail waktu penggunaan.
                        </p>
                        
                        <div class="flex flex-col gap-3">
                            <a href="{{ route('reports.borrowers-pdf') }}" target="_blank" class="w-full px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl shadow-lg shadow-emerald-100 transition-all active:scale-95 flex items-center justify-center gap-3">
                                <i class="fas fa-file-pdf"></i>
                                <span>Cetak Laporan PDF</span>
                            </a>
                            <div class="flex items-center justify-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                <i class="fas fa-info-circle text-[8px]"></i>
                                Data diperbarui secara real-time
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan Jadwal -->
            <div class="group relative">
                <div class="absolute inset-0 bg-primary-500/5 rounded-3xl blur-2xl group-hover:bg-primary-500/10 transition-all duration-500"></div>
                <div class="relative bg-white rounded-3xl border border-slate-100 p-8 shadow-sm hover:shadow-xl hover:shadow-primary-100/50 hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                    <!-- Background Decoration -->
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
                            <a href="{{ route('reports.schedules-pdf') }}" target="_blank" class="w-full px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-blue-100 transition-all active:scale-95 flex items-center justify-center gap-3">
                                <i class="fas fa-file-pdf"></i>
                                <span>Cetak Laporan PDF</span>
                            </a>
                            <div class="flex items-center justify-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                <i class="fas fa-info-circle text-[8px]"></i>
                                Filter berdasarkan semester aktif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection