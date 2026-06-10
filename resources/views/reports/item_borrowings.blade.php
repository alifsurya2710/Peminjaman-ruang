<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Barang</title>
    <style>
        @page { margin: 1cm; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0; padding: 0;
            color: #1e293b;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 16px;
            border-bottom: 2px solid #4f46e5;
        }
        .header h1 {
            margin: 0;
            color: #4f46e5;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 4px 0 0;
            font-size: 12px;
            color: #64748b;
            font-weight: bold;
        }
        .meta {
            margin-bottom: 16px;
            font-size: 10px;
            color: #64748b;
        }
        .meta table { border: none; width: 100%; }
        .meta td { border: none; padding: 2px 0; background: none; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 9px;
        }
        table thead {
            background-color: #4f46e5;
            color: white;
        }
        table th {
            padding: 9px 6px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #e2e8f0;
            font-size: 8px;
            text-transform: uppercase;
        }
        table td {
            padding: 8px 6px;
            border: 1px solid #e2e8f0;
        }
        table tbody tr:nth-child(even) { background-color: #f8fafc; }
        .badge {
            font-weight: bold;
            font-size: 8px;
            padding: 2px 6px;
            border-radius: 4px;
        }
        .badge-pending  { color: #92400e; background: #fef3c7; }
        .badge-approved { color: #14532d; background: #dcfce7; }
        .badge-rejected { color: #7f1d1d; background: #fee2e2; }
        .badge-finished { color: #1e3a5f; background: #dbeafe; }
        .summary-box {
            background: #f1f5f9;
            border-left: 4px solid #4f46e5;
            padding: 10px 16px;
            margin-bottom: 16px;
            border-radius: 0 8px 8px 0;
        }
        .summary-box h3 { margin: 0 0 6px; font-size: 11px; color: #4f46e5; }
        .summary-grid { display: table; width: 100%; }
        .summary-cell { display: table-cell; width: 25%; font-size: 10px; }
        .summary-cell strong { display: block; font-size: 16px; color: #1e293b; }
        .footer {
            margin-top: 40px;
            font-size: 10px;
            color: #64748b;
        }
        .signature {
            float: right;
            text-align: center;
            width: 180px;
        }
        .signature-space { height: 55px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Peminjaman Barang</h1>
        <p>SMKN 1 Katapang &mdash; Sistem Peminjaman Ruang & Barang</p>
    </div>

    {{-- Summary boxes --}}
    <div class="summary-box">
        <h3>Ringkasan Data</h3>
        <div class="summary-grid">
            <div class="summary-cell">
                <strong>{{ $itemBorrowings->count() }}</strong>
                Total Peminjaman
            </div>
            <div class="summary-cell">
                <strong>{{ $itemBorrowings->where('status','pending')->count() }}</strong>
                Pending
            </div>
            <div class="summary-cell">
                <strong>{{ $itemBorrowings->where('status','approved')->count() }}</strong>
                Disetujui
            </div>
            <div class="summary-cell">
                <strong>{{ $itemBorrowings->where('status','finished')->count() }}</strong>
                Selesai
            </div>
        </div>
    </div>

    <div class="meta">
        <table>
            <tr>
                <td>Total Data: <strong>{{ $itemBorrowings->count() }} Transaksi</strong></td>
                <td style="text-align: right;">Dicetak: {{ now()->format('d F Y, H:i') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="20">No</th>
                <th>Peminjam</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Barang</th>
                <th>Ruangan</th>
                <th width="30">Jml</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Tujuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($itemBorrowings as $borrowing)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><strong>{{ $borrowing->borrower_name }}</strong></td>
                <td>{{ $borrowing->class_name ?? '—' }}</td>
                <td>{{ $borrowing->department ?? '—' }}</td>
                <td><strong>{{ $borrowing->item->name }}</strong></td>
                <td>{{ $borrowing->item->room?->name ?? '—' }}</td>
                <td style="text-align:center;">{{ $borrowing->amount }}</td>
                <td>{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                <td>{{ $borrowing->return_date->format('d/m/Y') }}</td>
                <td>{{ Str::limit($borrowing->purpose, 30) }}</td>
                <td>
                    @if($borrowing->status === 'pending')
                        <span class="badge badge-pending">Pending</span>
                    @elseif($borrowing->status === 'approved')
                        <span class="badge badge-approved">Disetujui</span>
                    @elseif($borrowing->status === 'rejected')
                        <span class="badge badge-rejected">Ditolak</span>
                    @else
                        <span class="badge badge-finished">Selesai</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="text-align:center; padding: 20px; color: #94a3b8;">
                    Tidak ada data peminjaman barang.
                </td>
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
            <p style="font-size:8px;">NIP. ...........................</p>
        </div>
        <div style="clear:both;"></div>
    </div>

</body>
</html>
