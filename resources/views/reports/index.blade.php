@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 style="color: #0066cc; font-weight: 700;">
                <i class="fas fa-file-pdf"></i> Laporan
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" style="background-color: #0066cc; color: white;">
                    <h5 class="mb-0"><i class="fas fa-handshake"></i> Laporan Peminjam</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Export data peminjam ruangan ke format PDF</p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('reports.borrowers-pdf') }}" class="btn btn-success flex-grow-1" target="_blank">
                            <i class="fas fa-file-pdf"></i> Cetak Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header" style="background-color: #0066cc; color: white;">
                    <h5 class="mb-0"><i class="fas fa-calendar"></i> Laporan Jadwal</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Export data jadwal pembelajaran ke format PDF</p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('reports.schedules-pdf') }}" class="btn btn-success flex-grow-1"" target="_blank">
                            <i class="fas fa-file-pdf"></i> Cetak Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
