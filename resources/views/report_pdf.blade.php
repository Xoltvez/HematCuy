<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan HematCuy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h2, h3 {
            text-align: center;
            margin-bottom: 5px;
        }
        .text-center {
            text-align: center;
        }
        .summary-box {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 5px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table.data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-success { color: #10b981; }
        .text-danger { color: #ef4444; }
        .text-right { text-align: right !important; }
    </style>
</head>
<body>

    <h2>Laporan Keuangan HematCuy</h2>
    <div class="text-center" style="margin-bottom: 20px;">
        @if($start_date && $end_date)
            Periode: {{ \Carbon\Carbon::parse($start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d M Y') }}
        @elseif($month && $year)
            Periode: {{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F') }} {{ $year }}
        @elseif($year)
            Periode: Tahun {{ $year }}
        @else
            Periode: Keseluruhan
        @endif
    </div>

    <div class="summary-box">
        <table class="summary-table">
            <tr>
                <td width="50%">
                    <strong>Total Pemasukan:</strong> <br>
                    <span class="text-success" style="font-size: 16px;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
                </td>
                <td width="50%">
                    <strong>Total Pengeluaran:</strong> <br>
                    <span class="text-danger" style="font-size: 16px;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Saldo Tunai (Dompet):</strong> <br>
                    <span>Rp {{ number_format($balanceCash, 0, ',', '.') }}</span>
                </td>
                <td>
                    <strong>Saldo Bank / E-Wallet:</strong> <br>
                    <span>Rp {{ number_format($balanceBank, 0, ',', '.') }}</span>
                </td>
            </tr>
        </table>
    </div>

    <h3>Rincian Transaksi</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th width="30%">Judul</th>
                <th width="20%">Kategori</th>
                <th width="15%">Tipe</th>
                <th width="20%" class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $tx)
                <tr>
                    <td>
                        {{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}
                        @if($tx->time)
                            <br><small style="color: #666;">{{ \Carbon\Carbon::parse($tx->time)->format('H:i') }}</small>
                        @endif
                    </td>
                    <td>{{ $tx->title }}</td>
                    <td>{{ $tx->category }}</td>
                    <td>
                        @if($tx->type == 'income')
                            <span class="text-success">Pemasukan</span>
                        @else
                            <span class="text-danger">Pengeluaran</span>
                        @endif
                    </td>
                    <td class="text-right">
                        @if($tx->type == 'income')
                            <span class="text-success">+ Rp {{ number_format($tx->amount, 0, ',', '.') }}</span>
                        @else
                            <span class="text-danger">- Rp {{ number_format($tx->amount, 0, ',', '.') }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
