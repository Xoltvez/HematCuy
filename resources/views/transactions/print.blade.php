<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi - HematCuy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .header p {
            margin: 0;
            color: #555;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .income { color: #166534; font-weight: bold; }
        .expense { color: #991b1b; font-weight: bold; }
        .footer {
            text-align: right;
            font-size: 12px;
            color: #777;
            margin-top: 50px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        @media print {
            body { padding: 0; }
            @page { margin: 1.5cm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #3b82f6; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Cetak Halaman Ini</button>
        <p style="font-size: 12px; color: #666; margin-top: 5px;">Dialog cetak akan otomatis terbuka. Jika tidak, klik tombol di atas.</p>
    </div>

    <div class="header">
        <h1>HematCuy.</h1>
        <p>Laporan Riwayat Transaksi Seluruh Waktu</p>
        <p>Tanggal Cetak: {{ now()->format('d M Y H:i') }} | Dicetak Oleh: {{ auth()->user()->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>Akun</th>
                <th>Judul</th>
                <th style="text-align: right;">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $totalIncome = 0;
                $totalExpense = 0;
            @endphp
            @foreach($transactions as $tx)
                @php
                    if($tx->type === 'income') $totalIncome += $tx->amount;
                    else $totalExpense += $tx->amount;
                @endphp
                <tr>
                    <td>
                        {{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}
                        @if($tx->time)
                            <br><small style="color: #666;">{{ \Carbon\Carbon::parse($tx->time)->format('H:i') }}</small>
                        @endif
                    </td>
                    <td>
                        @if($tx->type === 'income')
                            <span class="income">Pemasukan</span>
                        @else
                            <span class="expense">Pengeluaran</span>
                        @endif
                    </td>
                    <td>{{ $tx->category ?? 'Lainnya' }}</td>
                    <td>{{ $tx->account === 'cash' ? 'Tunai' : 'Rekening Bank' }}</td>
                    <td>{{ $tx->title }}</td>
                    <td style="text-align: right;">{{ number_format($tx->amount, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" style="text-align: right;">Total Pemasukan:</th>
                <th style="text-align: right; color: #166534;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th colspan="5" style="text-align: right;">Total Pengeluaran:</th>
                <th style="text-align: right; color: #991b1b;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th colspan="5" style="text-align: right;">Sisa Saldo:</th>
                <th style="text-align: right; font-size: 16px;">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Laporan dihasilkan secara otomatis oleh Sistem HematCuy.</p>
    </div>

    <script>
        // Trigger print dialog automatically when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
