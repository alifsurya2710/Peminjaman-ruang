<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Peminjam Ruangan</title>
    <style>
        @page {
            margin: 1cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #1e293b;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #0284c7;
        }

        .header h1 {
            margin: 0;
            color: #0284c7;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #64748b;
            font-weight: bold;
        }

        .meta {
            margin-bottom: 20px;
            font-size: 11px;
            color: #64748b;
            display: flex;
            justify-content: space-between;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table thead {
            background-color: #0284c7;
            color: white;
        }

        table th {
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #e2e8f0;
            font-size: 10px;
            text-transform: uppercase;
        }

        table td {
            padding: 10px 8px;
            border: 1px solid #e2e8f0;
            font-size: 10px;
        }

        table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .status {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8px;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .status-pending { color: #854d0e; }
        .status-approved { color: #166534; }
        .status-rejected { color: #991b1b; }
        .status-completed { color: #075985; }

        .footer {
            margin-top: 50px;
            font-size: 11px;
            color: #64748b;
        }

        .signature {
            float: right;
            text-align: center;
            width: 200px;
        }

        .signature-space {
            height: 60px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Data Peminjam Ruangan</h1>
        <p>SMKN 1 Katapang - Ruang Nekat</p>
    </div>

    <div class="meta">
        <div>Total Data: <strong>{{ count($borrowers) }} Peminjam</strong></div>
        <div style="text-align: right;">Dicetak: {{ now()->format('d F Y, H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Nama Peminjam</th>
                <th>Telepon</th>
                <th>Ruangan</th>
                <th>Keperluan</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowers as $borrower)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $borrower->name }}</strong><br><small style="color: #64748b">{{ $borrower->email ?? '-' }}</small></td>
                    <td>{{ $borrower->phone ?? '-' }}</td>
                    <td>{{ $borrower->room->name }}</td>
                    <td>{{ Str::limit($borrower->purpose, 40) }}</td>
                    <td>{{ $borrower->borrow_date->format('d/m/Y') }}</td>
                    <td>{{ $borrower->borrow_time }} - {{ $borrower->return_time }}</td>
                    <td>
                        @if($borrower->status == 'pending')
                            <span class="status status-pending">Pending</span>
                        @elseif($borrower->status == 'approved')
                            <span class="status status-approved">Disetujui</span>
                        @elseif($borrower->status == 'rejected')
                            <span class="status status-rejected">Ditolak</span>
                        @else
                            <span class="status status-completed">Selesai</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada data peminjam ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Bandung, {{ now()->format('d F Y') }}</p>
            <p>Petugas Sarpras,</p>
            <div class="signature-space"></div>
            <p><strong>{{ Auth::user()->name }}</strong></p>
            <p style="font-size: 9px">NIP. ...........................</p>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>