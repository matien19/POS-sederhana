<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #000;
        }

        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        .subtitle {
            text-align: center;
            font-size: 11px;
            margin-bottom: 10px;
        }

        .info {
            margin-top: 5px;
            margin-bottom: 10px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #eaeaea;
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        td {
            border: 1px solid #000;
            padding: 4px;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="title">LAPORAN PENJUALAN</div>
    <div class="subtitle">Sistem Inventory POS</div>

    <!-- INFO FILTER -->
    <table class="info">
        <tr>
            <td width="15%">Tanggal</td>
            <td width="">
                {{ $request->tanggal_awal ?? '-' }} s/d {{ $request->tanggal_akhir ?? '-' }}
            </td>
        </tr>
    </table>

    <!-- TABEL DATA -->
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Nota</th>
                <th width="15%">Tanggal</th>
                <th width="15%">Kustomer</th>
                <th width="15%">Total Bayar</th>
                <th width="15%">Dibayar</th>
                <th width="15%">Hutang</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            $grandTotal = 0;
            $totalBayar = 0;
            $totalHutang = 0;
            @endphp

            @foreach($data as $row)
            @php
            $grandTotal += $row->total_bayar;
            $totalBayar += $row->pembayaran_sum_jumlah_bayar;
            $hutang = $row->total_bayar - ($row->pembayaran_sum_jumlah_bayar);
            $totalHutang += $hutang;

            @endphp
            <tr>
                <td class="center">{{ $no++ }}</td>
                <td>{{ $row->no_transaksi }}</td>
                <td class="center">{{ date('d-m-Y', strtotime($row->tanggal)) }}</td>
                <td>{{ $row->customer ??'-' }}</td>
                <td class="right">
                    Rp {{ number_format($row->total_bayar,0,',','.') }}
                </td>
                <td>
                    Rp {{ number_format($row->pembayaran_sum_jumlah_bayar ?? 0,0,',','.') }}
                </td>

                <td>
                    Rp {{ number_format($hutang ?? 0, 0,',','.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="right">GRAND TOTAL</th>
                <th class="right">
                    Rp {{ number_format($grandTotal,0,',','.') }}
                </th>
                <th class="right">
                    Rp {{ number_format($totalBayar,0,',','.') }}
                </th>
                <th class="right">
                    Rp {{ number_format($totalHutang,0,',','.') }}
                </th>
            </tr>
        </tfoot>
    </table>

</body>

</html>