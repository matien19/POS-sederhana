<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Struk</title>

<style>
body{ font-family:sans-serif; font-size:12px; }
.title{ font-size:18px; font-weight:bold; }

/* HR jadi titik titik */
hr{
 border:none;
 border-top:2px dotted #000;
 margin:6px 0;
 position:relative;
}

/* HR dengan + */
hr.plus::after{
 content:"+";
 position:absolute;
 right:0;
 top:-6px;
 font-weight:bold;
 font-size:14px;
}

/* HR dengan - */
hr.minus::after{
 content:"-";
 position:absolute;
 right:0;
 top:-6px;
 font-weight:bold;
 font-size:14px;
}

.table{ width:100%; }
.right{ text-align:right; }
.bold{ font-weight:bold; }
</style>

</head>

<body>

<p>
No.Nota - {{ $transaksi->no_transaksi }}
</p>

<hr class="minus">

<table class="table">
@foreach($detail as $item)
<tr>
    <td>{{ $item->barang->nama_barang }}</td>
</tr>

<tr>
    <td>
        Qty: {{ $item->jumlah_jual }} ×
        {{ number_format($item->harga_satuan,0,',','.') }},
    </td>

    <td class="right">
        {{ number_format($item->subtotal,0,',','.') }},
    </td>
</tr>

<tr><td colspan="2"><br></td></tr>
@endforeach
</table>

<hr class="plus">

<table class="table">
<tr>
    <td>Total Qty</td>
    <td>{{ $transaksi->total_qty ?? 0 }}</td>

    <td class="right bold">Sub Total</td>
    <td class="right bold">
        {{ number_format($transaksi->subtotal ?? $transaksi->total_bayar,0,',','.') }},
    </td>
</tr>

<tr>
    <td></td><td></td>
    <td class="right">Diskon</td>
    <td class="right">
        {{ number_format($transaksi->diskon ?? 0,0,',','.') }},
    </td>
</tr>

<tr>
    <td></td><td></td>
    <td class="right bold">Total</td>
    <td class="right bold">
        {{ number_format($transaksi->total_bayar,0,',','.') }},
    </td>
</tr>

<tr>
    <td></td><td></td>
    <td class="right">Bayar</td>
    <td class="right">
        {{ number_format($transaksi->jumlah_bayar,0,',','.') }},
    </td>
</tr>
</table>

<hr class="minus">

<table class="table">
<tr>
    <td></td><td></td>
    <td class="right">Kembali</td>
    <td class="right">
        {{ number_format($transaksi->kembalian ?? 0,0,',','.') }},
    </td>
</tr>
</table>

</body>
</html>
