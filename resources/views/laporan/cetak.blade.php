<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #444;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
        td {
            padding: 6px;
        }
        .text-end {
            text-align: right;
        }
        .summary {
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Laporan Keuangan</h2>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Keterangan</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $t)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ ucfirst($t->jenis) }}</td>
                    <td>{{ $t->keterangan }}</td>
                    <td class="text-end">{{ number_format($t->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        Total Pemasukan: Rp {{ number_format($transaksis->where('jenis','pemasukan')->sum('jumlah'), 0, ',', '.') }} <br>
        Total Pengeluaran: Rp {{ number_format($transaksis->where('jenis','pengeluaran')->sum('jumlah'), 0, ',', '.') }} <br>
        Saldo Akhir: Rp {{ number_format(
            $transaksis->where('jenis','pemasukan')->sum('jumlah') -
            $transaksis->where('jenis','pengeluaran')->sum('jumlah'), 0, ',', '.')
        }}
    </div>
</body>
</html>
