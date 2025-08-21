
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Buku - Perpustakaan Digital</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            margin: 15px;
            padding: 0;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 5px 0;
            font-size: 20px;
            color: #2c3e50;
            font-weight: bold;
        }
        .header p {
            margin: 3px 0;
            font-size: 12px;
            color: #7f8c8d;
        }
        .info {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #3498db;
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
            margin-bottom: 20px;
            font-size: 11px;
        }
        table th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            padding: 8px 5px;
            text-align: left;
        }
        table td {
            padding: 6px 5px;
            border: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #e9f7fe;
        }
        .footer {
            text-align: right;
            font-size: 10px;
            color: #7f8c8d;
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .no-data {
            text-align: center;
            padding: 15px;
            color: #e74c3c;
            font-style: italic;
        }
        .print-button {
            text-align: right;
            margin-bottom: 20px;
        }
        .print-button button {
            padding: 6px 12px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA BUKU</h1>
        <p>Perpustakaan Digital</p>
        <p>Tanggal Cetak: {{ $tanggal }}</p>
    </div>

    <!-- Tombol Cetak PDF -->
    <div class="print-button">
        <form action="{{ route('laporan.buku.generate') }}" method="POST" target="_blank">
            @csrf
            <input type="hidden" name="penerbit" value="{{ $filter['penerbit'] }}">
            <input type="hidden" name="tahun_terbit" value="{{ $filter['tahun_terbit'] }}">
            <input type="hidden" name="sort_by" value="{{ $filter['sort_by'] }}">
            <input type="hidden" name="sort_order" value="{{ $filter['sort_order'] }}">
        </form>
    </div>

    <!-- Informasi Filter -->
    <div class="info">
        <p><strong>Parameter Laporan:</strong></p>
        <p><strong>Penerbit:</strong> {{ $filter['penerbit'] ?: 'Semua Penerbit' }}</p>
        <p><strong>Tahun Terbit:</strong> {{ $filter['tahun_terbit'] ?: 'Semua Tahun' }}</p>
        <p><strong>Urutan:</strong> Berdasarkan {{ ucfirst($filter['sort_by']) }} ({{ $filter['sort_order'] == 'asc' ? 'A-Z' : 'Z-A' }})</p>
        <p><strong>Total Data:</strong> {{ $jumlah }} buku</p>
    </div>

    <!-- Tabel Data Buku -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center">No</th>
                <th style="width: 35%">Judul Buku</th>
                <th style="width: 20%">Penulis</th>
                <th style="width: 20%">Penerbit</th>
                <th style="width: 10%; text-align: center">Tahun</th>
                <th style="width: 10%">Kategori</th>
            </tr>
        </thead>
        <tbody>
            @forelse($buku as $index => $item)
                <tr>
                    <td style="text-align: center">{{ $index + 1 }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->penulis }}</td>
                    <td>{{ $item->penerbit }}</td>
                    <td style="text-align: center">{{ $item->tahun_terbit }}</td>
                    <td>
                        @foreach($item->kategoribukus as $kategori)
                            {{ $kategori->nama_kategori }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="no-data">Tidak ditemukan data buku sesuai kriteria filter</td>
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
