@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <style>
        .dashboard-header {
            background: linear-gradient(135deg, rgba(0, 82, 163, 0.9) 0%, rgba(0, 102, 204, 0.9) 100%),
                        url('/images/dashboard.png') center/cover;
            background-blend-mode: overlay;
            color: white;
            padding: 60px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .dashboard-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .dashboard-header p {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
        }

        .stat-card.primary {
            border-left-color: #0066cc;
        }

        .stat-card.success {
            border-left-color: #28a745;
        }

        .stat-card.warning {
            border-left-color: #ffc107;
        }

        .stat-card.danger {
            border-left-color: #dc3545;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-icon {
            font-size: 32px;
            opacity: 0.15;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin: 10px 0;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
        }

        .quick-actions .btn {
            padding: 12px 16px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
    </style>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1><i class="fas fa-chart-line"></i> Dashboard</h1>
        <p>Selamat datang, <strong>{{ Auth::user()->name }}</strong>! Kelola ruangan dan peminjaman dengan mudah.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stat-grid">
        <div class="stat-card primary">
            <div class="stat-header">
                <div>
                    <p class="stat-label">Total Ruangan</p>
                    <div class="stat-value">{{ $totalRooms }}</div>
                </div>
                <i class="fas fa-door-open stat-icon"></i>
            </div>
            <small class="text-muted">Ruangan yang tersedia</small>
        </div>

        <div class="stat-card success">
            <div class="stat-header">
                <div>
                    <p class="stat-label">Total Peminjam</p>
                    <div class="stat-value">{{ $totalBorrowers }}</div>
                </div>
                <i class="fas fa-handshake stat-icon"></i>
            </div>
            <small class="text-muted">Peminjaman sepanjang waktu</small>
        </div>

        <div class="stat-card warning">
            <div class="stat-header">
                <div>
                    <p class="stat-label">Total User</p>
                    <div class="stat-value">{{ $totalUsers }}</div>
                </div>
                <i class="fas fa-users stat-icon"></i>
            </div>
            <small class="text-muted">Pengguna sistem</small>
        </div>

        <div class="stat-card danger">
            <div class="stat-header">
                <div>
                    <p class="stat-label">Peminjaman Pending</p>
                    <div class="stat-value">{{ $pendingBorrowers }}</div>
                </div>
                <i class="fas fa-clock stat-icon"></i>
            </div>
            <small class="text-muted">Menunggu persetujuan</small>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-bolt"></i> Aksi Cepat</h5>
        </div>
        <div class="card-body">
            <div class="quick-actions">
                @if(Auth::user()->isAdmin())
                    <a href="/users/create" class="btn btn-outline-primary">
                        <i class="fas fa-user-plus"></i> Tambah User
                    </a>
                @endif

                @if(Auth::user()->isAdmin() || Auth::user()->isSarpras() || Auth::user()->isToolman())
                    <a href="/rooms/create" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Tambah Ruangan
                    </a>

                    <a href="/borrowers/create" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Tambah Peminjam
                    </a>

                    <a href="/schedules/create" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Tambah Jadwal
                    </a>

                    <a href="{{ route('reports.borrowers-pdf') }}" class="btn btn-outline-success" target="_blank">
                        <i class="fas fa-file-pdf"></i> Cetak Laporan Peminjam
                    </a>

                    <a href="{{ route('reports.schedules-pdf') }}" class="btn btn-outline-success" target="_blank">
                        <i class="fas fa-file-pdf"></i> Cetak Laporan Jadwal
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
