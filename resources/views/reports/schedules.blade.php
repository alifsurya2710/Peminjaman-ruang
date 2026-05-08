<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Jadwal Pembelajaran</title>
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
            border-bottom: 2px solid #2563eb;
        }

        .header h1 {
            margin: 0;
            color: #2563eb;
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
            background-color: #2563eb;
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

        .badge {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 9px;
        }

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
        <h1>Laporan Jadwal Pembelajaran</h1>
        <p>SMKN 1 Katapang - Ruang Nekat</p>
    </div>

    <div class="meta">
        <div>Total Jadwal: <strong>{{ count($schedules) }} Data</strong></div>
        <div style="text-align: right;">Dicetak: {{ now()->format('d F Y, H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Ruangan</th>
                <th>Kategori</th>
                <th>Hari</th>
                <th>Waktu (Jam)</th>
                <th>Blok</th>
                <th>Kelas</th>
                <th>Guru Pengajar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $schedule->room->name }}</strong></td>
                    <td>{{ $schedule->room->category->name }}</td>
                    <td>{{ $schedule->day }}</td>
                    <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                    <td><span class="badge">Blok {{ $schedule->block }}</span></td>
                    <td>{{ $schedule->class_name ?? '-' }}</td>
                    <td>{{ $schedule->teacher_name ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada data jadwal ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Bandung, {{ now()->format('d F Y') }}</p>
            <p>Petugas Kurikulum / Sarpras,</p>
            <div class="signature-space"></div>
            <p><strong>{{ Auth::user()->name }}</strong></p>
            <p style="font-size: 9px">NIP. ...........................</p>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>