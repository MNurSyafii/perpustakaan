
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Laporan Peminjaman Buku - Perpustakaan Digital</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 15px;
            padding: 0;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 5px 0;
            font-size: 22px;
            color: #2c3e50;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .header p {
            margin: 3px 0;
            font-size: 12px;
            color: #7f8c8d;
            font-style: italic;
        }
        .info {
            margin-bottom: 20px;
            padding: 12px 15px;
            background-color: #f8f9fa;
            border-radius: 6px;
            border-left: 6px solid #2c3e50;
            font-size: 13px;
        }
        .info p {
            margin: 5px 0;
        }
        .info strong {
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }
        table thead tr {
            background-color: #2c3e50;
            color: white;
            font-weight: 600;
            text-align: left;
        }
        table th, table td {
            padding: 8px 7px;
            border: 1px solid #ddd;
            vertical-align: middle;
        }
        table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tbody tr:hover {
            background-color: #e9f7fe;
        }
        .status {
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 10px;
            display: inline-block;
            text-transform: uppercase;
            text-align: center;
            min-width: 80px;
        }
        .dipinjam {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        .dikembalikan {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .terlambat {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .footer {
            text-align: right;
            font-size: 10px;
            color: #7f8c8d;
            margin-top: 35px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .no-data {
            text-align: center;
            padding: 18px;
            color: #e74c3c;
            font-style: italic;
            background-color: #f8f9fa;
        }
        .late-days {
            font-weight: 700;
            color: #721c24;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN TRANSAKSI PEMINJAMAN BUKU</h1>
        <p>Perpustakaan Digital</p>
        <p>Tanggal Cetak: {{ $tanggal }}</p>
    </div>

    <div class="info">
        <p><strong>Parameter Laporan:</strong></p>
        <p><strong>Peminjam:</strong> {{ $filter['user'] ?: 'Semua Peminjam' }}</p>
        <p><strong>Status:</strong> {{ $filter['status'] ? ucfirst($filter['status']) : 'Semua Status' }}</p>
        <p><strong>Periode:</strong> 
    @if($filter['tanggal_mulai'])
        {{ \Carbon\Carbon::parse($filter['tanggal_mulai'])->format('d/m/Y') }}
    @else
        Awal
    @endif

    s/d

    @if($filter['tanggal_selesai'])
        {{ \Carbon\Carbon::parse($filter['tanggal_selesai'])->format('d/m/Y') }}
    @else
        Sekarang
    @endif
</p>

        <p><strong>Urutan:</strong> Berdasarkan {{ ucfirst(str_replace('_', ' ', $filter['sort_by'])) }} ({{ $filter['sort_order'] == 'asc' ? 'Awal-Akhir' : 'Akhir-Awal' }})</p>
        <p><strong>Total Data:</strong> {{ $jumlah }} transaksi</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 20%;">Peminjam</th>
                <th style="width: 25%;">Judul Buku</th>
                <th style="width: 13%; text-align: center;">Tgl Pinjam</th>
                <th style="width: 13%; text-align: center;">Tgl Kembali</th>
                <th style="width: 13%; text-align: center;">Status</th>
                <th style="width: 11%; text-align: center;">Keterlambatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->buku->judul }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d/m/Y') }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        @php
                            $today = now();
                            $dueDate = \Carbon\Carbon::parse($item->tanggal_pengembalian);
                            $isLate = ($item->status_peminjaman == 'dipinjam' && $today->gt($dueDate));
                            $status = $isLate ? 'terlambat' : $item->status_peminjaman;
                        @endphp
                        <span class="status {{ $status }}">
                            {{ ucfirst($status) }}
                        </span>
                    </td>
                    <td class="text-center">
                        @if($isLate)
                            <span class="late-days">{{ $today->diffInDays($dueDate) }} hari</span>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="no-data">Tidak ditemukan data peminjaman sesuai kriteria filter</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ Auth::user()->name }} | {{ date('d/m/Y H:i:s') }}</p>
        <p>Halaman 1 dari 1</p>
    </div>
</body>
</html>